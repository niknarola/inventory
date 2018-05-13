<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sales extends CI_Controller {

    public $layout = '';

    public function __construct() {
        parent::__construct();
        $this->load->library('Ajax_pagination');
        $this->perPage = 10;
        $this->load->model('Product_model', 'products');
        $this->load->model('Basic_model', 'basic');
        $this->load->model('Locations_model', 'location');
        $this->load->model('Sales_model', 'sales');
        if ($this->uri->segment(1) == 'admin' && !$this->session->userdata('admin_validated')) {
            redirect('admin/login');
        } else if ($this->uri->segment(1) != 'admin' && !$this->session->userdata('user_validated')) {
            redirect('login');
        }
        if ($this->uri->segment(1) == 'admin')
            $this->layout = 'admin/admin_layout';
        else
            $this->layout = 'layout';
    }

    public function index() {
        $data = array();
        $data['title'] = 'Sales';
        //total rows count
        $totalRec = count($this->sales->getRows());

        #nik-----------
        $data['cat_url'] = ($this->uri->segment(1) == 'admin') ? 'admin/barcode/get_sub_category' : 'barcode/get_sub_category';
        $category_names = $this->products->get_categories();
        $data['categories'] = $category_names;

        $condtion = $this->products->get_key_value_pair('original_condition');
        $data['condition'] = $condtion;
        #nik-----------
        //pagination configuration
        $data['ajax_url'] = ($this->session->userdata('admin_validated')) ? 'admin/inventory/master_sheet' : 'master_sheet';
        $url = ($this->session->userdata('admin_validated')) ? 'admin/sales/ajaxPaginationData' : 'sales/ajaxPaginationData';
        $data['url'] = $url;
        $data['print_url'] = ($this->uri->segment(1) == 'admin') ? 'admin/barcode/location_print' : 'barcode/location_print';
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . $url;
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $config['uri_segment'] = 3;
        $this->ajax_pagination->initialize($config);

        //get the posts data
//        $data['posts'] = $this->sales->getRows(array('limit' => $this->perPage), 'part');
//        pr($data['posts']);
//        exit;
        //load the view
        $this->template->load($this->layout, 'sales/dashboard', $data);
    }

    function ajaxPaginationData() {
        $conditions = array();
        $config1 = [];
        //calc offset number
        $page = $this->input->post('page');
        if (!$page) {
            $offset = 0;
        } else {
            $offset = $page;
        }
        $data['print_url'] = ($this->uri->segment(1) == 'admin') ? 'admin/barcode/location_print' : 'barcode/location_print';
        //set conditions for search
        $keywords = $this->input->post('keywords');
        $searchfor = $this->input->post('searchfor');
        #nik------------ 
        $category1 = $this->input->post('category1');
        $category2 = $this->input->post('category2');
        $condition = $this->input->post('condition');
        $grade = $this->input->post('grade');
        #nik------------
        if (!empty($keywords)) {
            $conditions['search']['keywords'] = $keywords;
            $config1 = 'searchFilter';
        }
        if (!empty($searchfor) && $searchfor != 'none') {
            $conditions['search']['searchfor'] = $searchfor;
            $config1 = 'searchFilter';
        }
        #nik------------
        if (!empty($category1) && $category1 != 'none') {
            $conditions['search']['category1'] = $category1;
            $config1 = 'searchFilter';
        }
        if (!empty($category2) && $category2 != 'none') {
            $conditions['search']['category2'] = $category2;
            $config1 = 'searchFilter';
        }
        if (!empty($condition) && $condition != 'none') {
            $conditions['search']['condition'] = $condition;
            $config1 = 'searchFilter';
        } else if (!empty($grade) && $grade != 'none') {
            $conditions['search']['grade'] = $grade;
            $config1 = 'searchFilter';
        } else if (!empty($condition) && $condition != 'none' && !empty($grade) && $grade != 'none') {
            $conditions['search']['condition'] = $condition;
            $conditions['search']['grade'] = $grade;
            $config1 = 'searchFilter';
        }
        if ($this->input->post('ready')) {
            $conditions['search']['ready'] = "Ready for sale";
            $config1 = 'displayReady';
        }
        if ($this->input->post('recent')) {
            $conditions['search']['recent'] = $this->db->order_by('ps.created', 'desc');
            $config1 = 'displayRecent';
        }
        if ($this->input->post('sold')) {
            $conditions['search']['sold'] = "Sold";
            $config1 = 'displaySold';
        }
        if ($this->input->post('topsellers')) {
            $conditions['search']['topsellers'] = "topsellers";
            $config1 = 'displayTopSellers';
        }
        #nik------------
        //total rows count
        $totalRec = count($this->sales->getRows($conditions, $searchfor));

        //pagination configuration
        $config['target'] = '#postList';
        $url = ($this->session->userdata('admin_validated')) ? 'admin/inventory/master_sheet/ajaxPaginationData' : 'master_sheet/ajaxPaginationData';
        $data['url'] = $url;
        $data['ajax_url'] = ($this->session->userdata('admin_validated')) ? 'admin/inventory/master_sheet' : 'master_sheet';
        $config['base_url'] = base_url() . $url;
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        // $config['link_func']   = 'searchFilter';
        $config['link_func'] = $config1;
        $config['uri_segment'] = 4;
        $this->ajax_pagination->initialize($config);

        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;

        //get posts data
        $posts = $this->sales->getRows($conditions, $searchfor);
        $final = array();
        if (!empty($posts)) {
            foreach ($posts as $key => $val) {
                $condition1 = array(
                    'product_id' => $val['pid'],
                    'status !=' => "sold"
                );
                $condition2 = array(
                    'product_id' => $val['pid'],
                    'status' => "ready for sale"
                );
                $serial_qty = $this->basic->get_all_data_by_criteria('product_serials', $condition1);
                $ready_for_sale = $this->basic->get_all_data_by_criteria('product_serials', $condition2);
                $final[$key] = $val;
                $final[$key]['ready_for_sale'] = count($ready_for_sale);
                $final[$key]['qty_in_stock'] = count($serial_qty);
            }
        }
        $data['posts'] = $final;
        $data['searchBy'] = $searchfor;
        //load the view
        $this->load->view('sales/ajax-pagination-data', $data, FALSE);
    }

    public function flag_item() {
        $part = $this->input->post('part');
        $update_arr = array(
            'is_flagged' => 1
        );
        $update = $this->basic->update('products', $update_arr, array('part' => $part));
        if ($update) {
            $response['status'] = 1;
            $response['message'] = "You have successfully flagged the part # " . $part;
        } else {
            $response['status'] = 0;
        }
        echo json_encode($response);
        exit;
    }

    public function remove_flag_item() {
        $part = $this->input->post('part');
        $update_arr = array(
            'is_flagged' => 0
        );
        $update = $this->basic->update('products', $update_arr, array('part' => $part));
        if ($update) {
            $response['status'] = 1;
            $response['message'] = "You have successfully remove flag of the part # " . $part;
        } else {
            $response['status'] = 0;
        }
        echo json_encode($response);
        exit;
    }

    public function ajax_list() {
        $list = $this->products->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $products) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $products->part;
            $row[] = $products->name;
            $row[] = $products->description;
            $row[] = ($products->category != null || $products->category != '') ? get_category_name($products->category) : '';
            $row[] = ($products->is_cto == 0) ? 'No' : 'Yes';
            $row[] = '<a title="View Product" href="' . (($this->session->userdata('admin_validated')) ? 'admin/' : '') . 'products/view/' . $products->id . '" class="btn-xs btn-default product_action_btn"><i class="icon-eye"></i></a><a title="Edit Product" href="' . (($this->session->userdata('admin_validated')) ? 'admin/' : '') . 'products/edit/' . $products->id . '" class="btn-xs btn-default product_action_btn"><i class="icon-pencil"></i></a><a title="Delete Product" href="' . (($this->session->userdata('admin_validated')) ? 'admin/' : '') . 'products/delete/' . $products->id . '" class="btn-xs btn-default product_action_btn"><i class="icon-cross2"></i></a>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->products->count_all(),
            "recordsFiltered" => $this->products->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
        exit;
    }

    public function view_notes($id) {
        $data['notes'] = $this->sales->get_notes_by_id($id);
        if ($data['notes']) {
            $resp['status'] = 1;
            $resp['data'] = $this->load->view('master_sheet/notes', $data, TRUE);
        } else {
            $resp['status'] = 0;
        }
        echo json_encode($resp);
    }

    public function view_specs($id) {
        $data['specs'] = $this->sales->get_specs_by_id($id);
        // pr($data['specs']);die;
        if ($data['specs']) {
            $resp['status'] = 1;
            $resp['data'] = $this->load->view('master_sheet/specs', $data, TRUE);
        } else {
            $resp['status'] = 0;
        }
        echo json_encode($resp);
    }

}
