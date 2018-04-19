<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Picking extends CI_Controller {

    public $layout = '';

    public function __construct() {
        parent::__construct();
        $this->load->library('Ajax_pagination');
        $this->perPage = 10;
        $this->load->model('Product_model', 'products');
        $this->load->model('Basic_model', 'basic');
        $this->load->model('Locations_model', 'location');
        if ($this->uri->segment(1) == 'admin' && !$this->session->userdata('admin_validated')) {
            redirect('admin/login');
        } else if ($this->uri->segment(1) != 'admin' && !$this->session->userdata('user_validated')) {
            redirect('login');
        }
        if ($this->uri->segment(1) == 'admin') {
            $this->layout = 'admin/admin_layout';
            $this->admin_prefix = 'admin/';
        } else {
            $this->layout = 'layout';
            $this->admin_prefix = '';
        }
    }

    public function index() {
        $data = array();
        $data['title'] = 'Picking';
        $shipstation_authorization_key = 'Basic YmI3MTc5OTE0ZmYyNDYyNzk4OTg2YWJmZWJhMmY0NjM6MWM0MzM1ZmU5NWRmNDQxNjllYmNlOWQyNmJjYjgxMTY=';
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://ssapi.shipstation.com/orders");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Authorization: " . $shipstation_authorization_key
        ));

        $response = curl_exec($ch);
        curl_close($ch);
        echo "<pre>";
        pr($response);
        exit;
        $data['admin_prefix'] = $this->admin_prefix;
        $data['ajax_url'] = ($this->session->userdata('admin_validated')) ? 'admin/inventory/picking_list' : 'picking_list';

        //load the view
        $this->template->load($this->layout, 'picking/index', $data);
    }
    public function ajax_list(){
        $list = $this->picking->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $products) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = '<input type="checkbox" name="check[]" class="check_product" value="'.$products->id.'">';
            $row[] = $products->part;
            $row[] = $products->name;
            $row[] = $products->description;
            $row[] = ($products->category!=null || $products->category != '') ? get_category_name($products->category) : '';
            $row[] = $products->created;
            $text = 'Pending'; $class = 'bg-orange-300';
            if($products->status==1){
                $text = 'Approved'; $class = 'success';
            }
            $status = '<span style="margin-bottom: 5px;" class="label label-'.$class.'">'.$text.'</span>';
                if($products->requested_for_clarification==1){ 
                  if($this->session->userdata('admin_validated')){ 
                        $status .= '<span class="label label-warning">Requested for Clarification</span>';
                   }else{ 
                        $status .= '<a href="products/view/'.$products->id.'"><span class="label label-warning">Clarification Needed</span></a>';
                     } 
                }elseif ($products->requested_for_clarification==2){ 
                    $status .= '<span class="label label-success">Clarification Provided</span>';
             }
             $row[] = $status;
            if($this->session->userdata('admin_validated')){ 
                $row[] = '<td><a href="admin/temporary_products/view/'.$products->id.'" class="btn-xs btn-default"><i class="icon-eye"></i></a><a href="admin/temporary_products/edit/'.$products->id.'" class="btn-xs btn-default"><i class="icon-pencil"></i></a></td>';
                 }else{ 
                    $row[] = '<td><a href="products/view/'.$products->id.'" class="btn-xs btn-default"><i class="icon-eye"></i></a><a href="receiving/temporary_product_edit/'.$products->id.'" class="btn-xs btn-default"><i class="icon-pencil"></i></a></td>';
                    }       
            
            $data[] = $row;
        }
        $output = array(
                    "draw" => $_POST['draw'],
                    "recordsTotal" => $this->receiving->count_all(),
                    "recordsFiltered" => $this->receiving->count_filtered(),
                    "data" => $data,
                );
        //output to json format
        echo json_encode($output);
        exit;
    }

    function ajaxPaginationData() {
        $conditions = array();

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
        // $sortBy = $this->input->post('sortBy');
        if (!empty($keywords)) {
            $conditions['search']['keywords'] = $keywords;
        }
        if (!empty($searchfor) && $searchfor != 'none') {
            $conditions['search']['searchfor'] = $searchfor;
        }

        //total rows count
        $totalRec = count($this->location->getRows($conditions));

        //pagination configuration
        $config['target'] = '#postList';
        $url = ($this->session->userdata('admin_validated')) ? 'admin/inventory/locations/ajaxPaginationData' : 'locations/ajaxPaginationData';
        $data['url'] = $url;
        $data['ajax_url'] = ($this->session->userdata('admin_validated')) ? 'admin/inventory/locations' : 'locations';
        $config['base_url'] = base_url() . $url;
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $config['uri_segment'] = 5;
        $this->ajax_pagination->initialize($config);

        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;

        //get posts data
        $data['posts'] = $this->location->getRows($conditions);
//        pr($data['posts']);
        //load the view
        $this->load->view('locations/ajax-pagination-data', $data, FALSE);
    }


    public function master() {
        $data['title'] = 'Locations Master';
        $this->load->model('Receiving_model', 'receiving');
        $data['pallets'] = $this->receiving->get_key_value_pallets();
        $data['locations'] = $this->basic->get_all_data('locations');
        $data['admin_prefix'] = $this->admin_prefix;
        $data['print_url'] = ($this->uri->segment(1) == 'admin') ? 'admin/barcode/location_print' : 'barcode/location_print';
        if ($this->input->post()) {
            if ($this->input->post('complete')) {
                $pallet_id = $this->input->post('pallet_id');
                $location = $this->basic->get_single_data_by_criteria('locations', array('name' => trim($this->input->post('location'))));
                if (!empty($location)) {
                    // echo"in if";die;
                    $location_id = $location['id'];
                } else {
                    // echo"in else";die;
                    $insert_data = [
                        'name' => trim($this->input->post('location'))
                    ];
                    // pr($insert_data);die;
                    $location_id = $this->basic->insert('locations', $insert_data);
                }
                $ldata = [
                    'location_id' => $location_id
                ];
                if ($this->basic->update('product_serials', $ldata, ['pallet_id' => $pallet_id])) {
                    $product_serial_data = $this->basic->get_all_data_by_criteria('product_serials', ['pallet_id' => $pallet_id]);
                    $timestamp = [
                        'location_assigned_date' => date('Y-m-d H:i:s'),
                        'last_scan' => date('Y-m-d H:i:s')
                    ];
                    foreach ($product_serial_data as $key => $serial_data) {
                        $this->basic->update('serial_timestamps', $timestamp, ['serial_id' => $serial_data['id']]);
                    }
                    $this->session->set_flashdata('msg', 'Locations assigned successfully');
                }
            }
        }
        $this->template->load($this->layout, 'locations/locations_master', $data);
    }

    public function create_location() {
        $location = trim($this->input->post('location'));
        $response = [];
        if ($this->location->check_location_exists($location) > 0) {
            $response['status'] = 0;
            $response['msg'] = 'Location Name already exists';
        } else {
            $data = [
                'name' => $location
            ];
            if ($this->basic->insert('locations', $data)) {
                $response['sql'] = $this->db->last_query();
                $response['status'] = 1;
                $response['msg'] = 'Location added successfully';
            }
        }
        echo json_encode($response);
        exit;
    }

    public function assign_location() {
        $location = trim($this->input->post('location'));
        $serial = trim($this->input->post('serial'));
        $location_id = $this->location->get_location_id($location);
        $response = [];
        if ($location_id != '') {
            $data = [
                'location_id' => $location_id
            ];
            if ($this->basic->update('product_serials', $data, ['serial' => $serial])) {
                $response['status'] = 1;
                $response['msg'] = 'Location assigned successfully';
                $product_serial_data = $this->basic->get_single_data_by_criteria('product_serials', ['serial' => $serial]);
                $timestamp = [
                    'location_assigned_date' => date('Y-m-d H:i:s'),
                    'last_scan' => date('Y-m-d H:i:s')
                ];
                $this->basic->update('serial_timestamps', $timestamp, ['serial_id' => $product_serial_data['id']]);
            }
        } else {
            $response['status'] = 0;
            $response['msg'] = 'Location does not exists';
        }
        echo json_encode($response);
        exit;
    }

    public function move_location() {
        $location = trim($this->input->post('location'));
        $serial = trim($this->input->post('serial'));
        $location_id = $this->location->get_location_id($location);
        $response = [];
        if ($location_id != '') {
            $data = [
                'location_id' => $location_id
            ];
            if ($this->basic->update('product_serials', $data, ['serial' => $serial])) {
                $response['status'] = 1;
                $response['msg'] = 'Location moved successfully';
                $product_serial_data = $this->basic->get_single_data_by_criteria('product_serials', ['serial' => $serial]);
                $timestamp = [
                    'location_assigned_date' => date('Y-m-d H:i:s'),
                    'last_scan' => date('Y-m-d H:i:s')
                ];
                $this->basic->update('serial_timestamps', $timestamp, ['serial_id' => $product_serial_data['id']]);
            }
        } else {
            $response['status'] = 0;
            $response['msg'] = 'Location does not exists';
        }
        echo json_encode($response);
        exit;
    }

    public function get_serial_part_by_pallet() {
        $pallet_id = $this->input->post('pallet');
        $html = '';
        $status = 0;
        $cnt = 0;
        $products = $this->location->get_serial_part_by_pallet($pallet_id);
        if (!empty($products)) {
            $cnt = sizeof($products);
            $status = 1;
            $html = '<table class="table">';
            $html .= '<thead><tr><th>Serial Number</th><th>Part Number</th></tr></thead>';
            $html .= '<tbody>';
            foreach ($products as $key => $value) {
                $html .= '<tr><td>' . $value['serial'] . '</td><td>' . $value['part'] . '</td></tr>';
                // $html .= '<tr><td><input class="form-control" name="serial[]" value="'.$value['serial'].'"></td><td><input class="form-control" name="part[]" value="'.$value['part'].'"></td></tr>';
            }
            $html .= '</tbody>';
            $html .= '</table>';
        }
        $response['products'] = $products;
        $response['status'] = $status;
        $response['html'] = $html;
        $response['cnt'] = $cnt;

        echo json_encode($response);
        exit;
    }

}
