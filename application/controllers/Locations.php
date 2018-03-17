<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Locations extends CI_Controller {
	public $layout = '';
	public function __construct(){
		parent::__construct();
		$this->load->library('Ajax_pagination');
		$this->perPage = 10;
		$this->load->model('Product_model','products');
		$this->load->model('Basic_model','basic');
		$this->load->model('Locations_model','location');
		if($this->uri->segment(1)=='admin' && !$this->session->userdata('admin_validated')){
			redirect('admin/login');
		}else if($this->uri->segment(1)!='admin' && !$this->session->userdata('user_validated')) {
			redirect('login');
        }
        if($this->uri->segment(1)=='admin'){
            $this->layout = 'admin/admin_layout';
            $this->admin_prefix = 'admin/';
        }else{
            $this->layout = 'layout'; 
            $this->admin_prefix = '';
        }
	}
	 public function index(){
        $data = array();
        $data['title'] = 'Locations';
        //total rows count
        $totalRec = count($this->location->getRows());
        
        //pagination configuration
        $data['ajax_url'] = ($this->session->userdata('admin_validated')) ? 'admin/inventory/locations' : 'locations';
        $url = ($this->session->userdata('admin_validated')) ? 'admin/inventory/locations/ajaxPaginationData' : 'locations/ajaxPaginationData';
        $data['url'] = $url;
        $data['admin_prefix'] = $this->admin_prefix;
        $data['print_url'] = ($this->uri->segment(1)=='admin') ? 'admin/barcode/location_print' : 'barcode/location_print';
        $config['target']      = '#postList';
        $config['base_url']    = base_url().$url;
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $config['uri_segment']   = 4;
        $this->ajax_pagination->initialize($config);
        
        //get the posts data
        $data['posts'] = $this->location->getRows(array('limit'=>$this->perPage));
        //load the view
        $this->template->load($this->layout, 'locations/index', $data);
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
        // $sortBy = $this->input->post('sortBy');
        if(!empty($keywords)){
            $conditions['search']['keywords'] = $keywords;
        }
        if(!empty($searchfor) && $searchfor!='none'){
            $conditions['search']['searchfor'] = $searchfor;
        }
        
        //total rows count
        $totalRec = count($this->location->getRows($conditions));
        
        //pagination configuration
        $config['target']      = '#postList';
        $url = ($this->session->userdata('admin_validated')) ? 'admin/inventory/locations/ajaxPaginationData' : 'locations/ajaxPaginationData';
        $data['url'] = $url;
        $data['ajax_url'] = ($this->session->userdata('admin_validated')) ? 'admin/inventory/locations' : 'locations';
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
        $data['posts'] = $this->location->getRows($conditions);
//        pr($data['posts']);
        //load the view
        $this->load->view('locations/ajax-pagination-data', $data, FALSE);
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
    public function master(){
        $data['title'] = 'Locations Master';
        $this->load->model('Receiving_model','receiving');
         $data['pallets'] = $this->receiving->get_key_value_pallets();
        $data['locations'] = $this->basic->get_all_data('locations');
        $data['admin_prefix'] = $this->admin_prefix;
        $data['print_url'] = ($this->uri->segment(1)=='admin') ? 'admin/barcode/location_print' : 'barcode/location_print';
        if($this->input->post()){
            if($this->input->post('complete')){
               
                $pallet_id = $this->input->post('pallet_id');
                $location = $this->basic->get_single_data_by_criteria('locations', array('name' => trim($this->input->post('location'))));
                if(!empty($location)){
                    $location_id = $location['id']; 
                }else{
                    $insert_data = [
                        'name'=>trim($this->input->post('location'))
                    ];
                    $location_id = $this->basic->insert('locations', $insert_data);
                }
                $data = [
                    'location_id'=>$location_id
                ];
            if($this->basic->update('product_serials', $data, ['pallet_id'=>$pallet_id])){
                $product_serial_data = $this->basic->get_all_data_by_criteria('product_serials', ['pallet_id'=>$pallet_id]);
                $timestamp = [
                    'location_assigned_date'=>date('Y-m-d H:i:s'),
                    'last_scan'=>date('Y-m-d H:i:s')
                ];
                foreach ($product_serial_data as $key => $serial_data) {
                    $this->basic->update('serial_timestamps', $timestamp, ['serial_id'=>$serial_data['id']]);
                }
                $this->session->set_flashdata('msg', 'Locations assigned successfully');
            }
            }
        }
        $this->template->load($this->layout, 'locations/locations_master', $data);
    }

    public function create_location(){
    	$location = trim($this->input->post('location'));
    	$response = [];
    	if($this->location->check_location_exists($location) > 0){
    		$response['status'] = 0;
    		$response['msg'] = 'Location Name already exists';
    	}else{
    		$data = [
            	'name'=>$location
            ];
	        if($this->basic->insert('locations', $data)){
	        	$response['sql'] = $this->db->last_query();
	        	$response['status'] = 1;
    			$response['msg'] = 'Location added successfully';
	        }
    	}
    	echo json_encode($response);
    	exit;
    }
    public function assign_location(){
    	$location = trim($this->input->post('location'));
    	$serial = trim($this->input->post('serial'));
    	$location_id = $this->location->get_location_id($location);
    	$response = [];
    	if($location_id != ''){
    		$data = [
            	'location_id'=>$location_id
            ];
	        if($this->basic->update('product_serials', $data, ['serial'=>$serial])){
	        	$response['status'] = 1;
                $response['msg'] = 'Location assigned successfully';
                $product_serial_data = $this->basic->get_single_data_by_criteria('product_serials', ['serial'=>$serial]);
                $timestamp = [
                    'location_assigned_date'=>date('Y-m-d H:i:s'),
                    'last_scan'=>date('Y-m-d H:i:s')
                ];
                $this->basic->update('serial_timestamps', $timestamp, ['serial_id'=>$product_serial_data['id']]);
	        }
	    }else{
	    	$response['status'] = 0;
			$response['msg'] = 'Location does not exists';
	    }
    	echo json_encode($response);
    	exit;
    }
    public function move_location(){
    	$location = trim($this->input->post('location'));
    	$serial = trim($this->input->post('serial'));
    	$location_id = $this->location->get_location_id($location);
    	$response = [];
    	if($location_id != ''){
    		$data = [
            	'location_id'=>$location_id
            ];
	        if($this->basic->update('product_serials', $data, ['serial'=>$serial])){
	        	$response['status'] = 1;
                $response['msg'] = 'Location moved successfully';
                $product_serial_data = $this->basic->get_single_data_by_criteria('product_serials', ['serial'=>$serial]);
                $timestamp = [
                    'location_assigned_date'=>date('Y-m-d H:i:s'),
                    'last_scan'=>date('Y-m-d H:i:s')
                ];
                $this->basic->update('serial_timestamps', $timestamp, ['serial_id'=>$product_serial_data['id']]);
	        }
	    }else{
	    	$response['status'] = 0;
			$response['msg'] = 'Location does not exists';
	    }
    	echo json_encode($response);
    	exit;
    }
    public function get_serial_part_by_pallet(){
        $pallet_id = $this->input->post('pallet');
        $html = '';
        $status = 0;
        $cnt = 0;
        $products = $this->location->get_serial_part_by_pallet($pallet_id);
        if(!empty($products)){
            $cnt = sizeof($products);
            $status = 1;
            $html = '<table class="table">';
            $html .='<thead><tr><th>Serial Number</th><th>Part Number</th></tr></thead>';
            $html .= '<tbody>';
            foreach ($products as $key => $value) {
                $html .= '<tr><td>'.$value['serial'].'</td><td>'.$value['part'].'</td></tr>';
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