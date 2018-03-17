<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Master_sheet extends CI_Controller {
    public $layout = '';
    public function __construct(){
        parent::__construct();
        $this->load->library('Ajax_pagination');
        $this->perPage = 10;
        $this->load->model('Product_model','products');
        $this->load->model('Basic_model','basic');
        $this->load->model('Locations_model','location');
        $this->load->model('Master_sheet_model','master');
        if($this->uri->segment(1)=='admin' && !$this->session->userdata('admin_validated')){
            redirect('admin/login');
        }else if($this->uri->segment(1)!='admin' && !$this->session->userdata('user_validated')) {
            redirect('login');
        }
        if($this->uri->segment(1)=='admin')
            $this->layout = 'admin/admin_layout';
        else
            $this->layout = 'layout'; 
    }
     public function index(){
        $data = array();
        $data['title'] = 'Master Sheet';
        //total rows count
        $totalRec = count($this->master->getRows());
        
        #nik-----------
        $data['cat_url'] = ($this->uri->segment(1)=='admin') ? 'admin/barcode/get_sub_category' : 'barcode/get_sub_category';
        $category_names = $this->products->get_categories();
        $data['categories'] = $category_names;
        
        $condtion = $this->products->get_key_value_pair('original_condition');
        $data['condition'] = $condtion;
        #nik-----------
        
        //pagination configuration
        $data['ajax_url'] = ($this->session->userdata('admin_validated')) ? 'admin/inventory/master_sheet' : 'master_sheet';
        $url = ($this->session->userdata('admin_validated')) ? 'admin/inventory/master_sheet/ajaxPaginationData' : 'master_sheet/ajaxPaginationData';
        $data['url'] = $url;
        $data['print_url'] = ($this->uri->segment(1)=='admin') ? 'admin/barcode/location_print' : 'barcode/location_print';
        $config['target']      = '#postList';
        $config['base_url']    = base_url().$url;
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $config['uri_segment']   = 4;
        $this->ajax_pagination->initialize($config);
        
        //get the posts data
        $data['posts'] = $this->master->getRows(array('limit'=>$this->perPage));
        //load the view
        $this->template->load($this->layout, 'master_sheet/index', $data);
    }
    
    function ajaxPaginationData(){
        $conditions = array();
        //calc offset number
        $page = $this->input->post('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }
        $data['print_url'] = ($this->uri->segment(1)=='admin') ? 'admin/barcode/location_print' : 'barcode/location_print';
        //set conditions for search
        $keywords = $this->input->post('keywords');
        $searchfor = $this->input->post('searchfor');
       #nik------------ 
        $category1 = $this->input->post('category1');
        $category2 = $this->input->post('category2');
        $condition = $this->input->post('condition');
        $grade = $this->input->post('grade');
       #nik------------
       if(!empty($keywords)){
        $conditions['search']['keywords'] = $keywords;
    }
    if(!empty($searchfor) && $searchfor!='none'){
        $conditions['search']['searchfor'] = $searchfor;
    }
    #nik------------
    if(!empty($category1) && $category1!='none'){
        $conditions['search']['category1'] = $category1;
    }
    if(!empty($category2) && $category2!='none'){
        $conditions['search']['category2'] = $category2;
    }
    if(!empty($condition) && $condition!='none')
    {
        $conditions['search']['condition'] = $condition;
    }
    else if(!empty($grade) && $grade!='none')
    {
        $conditions['search']['grade'] = $grade;
    }
    else if(!empty($condition) && $condition!='none' && !empty($grade) && $grade!='none'){
        $conditions['search']['condition'] = $condition;
        $conditions['search']['grade'] = $grade;
    }
    if($this->input->post('ready'))
    {
        $conditions['search']['ready'] = "Ready for sale";
    }
    if($this->input->post('recent'))
    {
        $conditions['search']['recent'] = $this->db->order_by('ps.created','desc');
    }
    if($this->input->post('sold'))
    {
        $conditions['search']['sold'] = "Sold";
    }
        #nik------------
        
        //total rows count
        $totalRec = count($this->master->getRows($conditions));
        
        //pagination configuration
        $config['target']      = '#postList';
        $url = ($this->session->userdata('admin_validated')) ? 'admin/inventory/master_sheet/ajaxPaginationData' : 'master_sheet/ajaxPaginationData';
        $data['url'] = $url;
        $data['ajax_url'] = ($this->session->userdata('admin_validated')) ? 'admin/inventory/master_sheet' : 'master_sheet';
        $config['base_url']    = base_url().$url;
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $config['uri_segment']   = 5;
        $this->ajax_pagination->initialize($config);
        
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        
        //get posts data
        $data['posts'] = $this->master->getRows($conditions);
        //load the view
        $this->load->view('master_sheet/ajax-pagination-data', $data, FALSE);
    }
    public function ajax_list(){
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
            $row[] = ($products->category!=null || $products->category != '') ? get_category_name($products->category) : '';
            $row[] = ($products->is_cto == 0) ? 'No' : 'Yes';
            $row[] = '<a title="View Product" href="'.(($this->session->userdata('admin_validated')) ? 'admin/' : '').'products/view/'.$products->id.'" class="btn-xs btn-default product_action_btn"><i class="icon-eye"></i></a><a title="Edit Product" href="'.(($this->session->userdata('admin_validated')) ? 'admin/' : '').'products/edit/'.$products->id.'" class="btn-xs btn-default product_action_btn"><i class="icon-pencil"></i></a><a title="Delete Product" href="'.(($this->session->userdata('admin_validated')) ? 'admin/' : '').'products/delete/'.$products->id.'" class="btn-xs btn-default product_action_btn"><i class="icon-cross2"></i></a>';
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

    public function view_notes($id){
        $data['notes'] = $this->master->get_notes_by_id($id);
        if ($data['notes'])
        {
            $resp['status'] = 1;
            $resp['data'] = $this->load->view('master_sheet/notes', $data, TRUE);
        }
        else
        {
            $resp['status'] = 0;
        }
        echo json_encode($resp);
    }

    public function view_specs($id){
        $data['specs'] = $this->master->get_specs_by_id($id);
        if ($data['specs'])
        {
            $resp['status'] = 1;
            $resp['data'] = $this->load->view('master_sheet/specs', $data, TRUE);
        }
        else
        {
            $resp['status'] = 0;
        }
        echo json_encode($resp);
    }
}