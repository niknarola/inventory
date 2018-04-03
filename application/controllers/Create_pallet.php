
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Create_pallet extends CI_Controller {
    public $layout = '';
    public function __construct(){
        parent::__construct();
        $this->load->library('Ajax_pagination');
        $this->perPage = 10;
        $this->load->model('Product_model','products');
        $this->load->model('Receiving_model','receiving');
        $this->load->model('Basic_model','basic');
        $this->load->model('Locations_model','location');
        $this->load->model('Master_sheet_model','master');
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
        $data['title'] = 'Create Pallet';
        $data['ajax_url'] = ($this->uri->segment(1)=='admin') ? 'admin/testing/find_product' : 'testing/find_product';
        //load the view
        $this->template->load($this->layout, 'create_pallet/index', $data);
    }

    public function print_contents()
    {
        $data['title'] = 'Print Contents';
        $data['admin_prefix'] = $this->admin_prefix;
        $data['ajax_url'] = ($this->uri->segment(1)=='admin') ? 'admin/testing/find_product' : 'testing/find_product';
        $get_todays_cnt = $this->receiving->get_todays_total_pallets();
        if($this->input->post()){
            $pallet_type='';
            $prefix='';
            $action='';
            if($this->input->post('action') == 'pallet'){
                $action = 'pallet';            
            }
            if($this->input->post('action') == 'cart'){
                $action = 'cart';            
            }
            if($this->input->post('action') == 'other'){
                $action = 'other';            
            }
            if($this->input->post('pallet_type') == 'receiving'){ 
                $pallet_type = 'receiving'; 
                $prefix = 'RE'; 
            }
            if($this->input->post('pallet_type') == 'testing'){ 
                $pallet_type = 'testing'; 
                $prefix = 'TE';
            }
            if($this->input->post('pallet_type') == 'packout'){ 
                $pallet_type = 'packing'; 
                $prefix = 'PO';
            }
            if($this->input->post('pallet_type') == 'inventory'){ 
                $pallet_type = 'inventory';
                $prefix = 'IN';
            }

			$loc_name = $this->input->post('location');
			$location = $this->basic->check_location_exists($loc_name);
			$data['serial_array'] =  $_POST['serials'];
			$data['action'] = $action;
			$data['pallet_type'] = $pallet_type;
			$data['serials'] = $this->master->get_data($data['serial_array']);

			$k=0; $j = $get_todays_cnt+1;
			$arr = [];
			$arr['pallet_id'] = $prefix .date('mdY').'-'.$j;
			$arr['location_id'] = $location['id'];
			$arr['received_by'] = $this->session->userdata('id');
			$insert_data[] = $arr;
			$k++; $j++;

			$this->basic->insert_batch('pallets', $insert_data);

			// if($this->input->post('print_labels')){
			// 	$this->session->set_userdata(array('pallet_print_data'=>$insert_data));
			// 	$session_data=[];
			// 	// $session_data['bol_or_tracking'] = $this->input->post('bol_or_tracking');
			// 	// $session_data['main_location'] = $main_location;
			// 	// $session_data['ref'] = $ref;
			// 	// $this->basic->insert_batch('pallets', $insert_data);
			// 	// $this->session->set_userdata(array('pallets_next'=>$session_data));
			// 	redirect($url.'barcode/pallet_labels');
			// }
        }
        $print = $this->load->view('create_pallet/print_contents', $data, true);
        echo json_encode($print);
        die;
    }
}
