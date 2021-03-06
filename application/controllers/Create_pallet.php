
<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Create_pallet extends CI_Controller
{
    public $layout = '';
    public function __construct()
    {
        parent::__construct();
        $this->load->library('Ajax_pagination');
        $this->perPage = 10;
        $this->load->model('Product_model', 'products');
        $this->load->model('Receiving_model', 'receiving');
        $this->load->model('Basic_model', 'basic');
        $this->load->model('Locations_model', 'location');
        $this->load->model('Master_sheet_model', 'master');
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
    public function index()
    {
        $data = array();
        $data['title'] = 'Create Pallet';
        $data['ajax_url'] = ($this->uri->segment(1) == 'admin') ? 'admin/testing/find_product' : 'testing/find_product';
        //load the view
        $this->template->load($this->layout, 'create_pallet/index', $data);
    }

    public function print_contents()
    {
        $data['title'] = 'Print Contents';
        $data['admin_prefix'] = $this->admin_prefix;
        $data['ajax_url'] = ($this->uri->segment(1) == 'admin') ? 'admin/testing/find_product' : 'testing/find_product';
        $get_todays_cnt = $this->receiving->get_todays_total_pallets();
        if ($this->input->post() || $this->input->post('print_contents')) {
            $pallet_type = '';
            $prefix = '';
            $action = '';
            if ($this->input->post('action') == 'pallet') {
                $action = 'pallet';
            }
            if ($this->input->post('action') == 'cart') {
                $action = 'cart';
            }
            if ($this->input->post('action') == 'other') {
                $action = 'other';
            }
            if ($this->input->post('pallet_type') == 'receiving') {
                $pallet_type = 'receiving';
                $prefix = 'RE';
            }
            if ($this->input->post('pallet_type') == 'testing') {
                $pallet_type = 'testing';
                $prefix = 'TE';
            }
            if ($this->input->post('pallet_type') == 'packout') {
                $pallet_type = 'packing';
                $prefix = 'PO';
            }
            if ($this->input->post('pallet_type') == 'inventory') {
                $pallet_type = 'inventory';
                $prefix = 'IN';
            }

            $data['serial_array'] = $_POST['serials'];
            $data['action'] = $action;
            $data['pallet_type'] = $pallet_type;
            $data['serials'] = $this->master->get_data($data['serial_array']);

            $loc_name = $this->input->post('scan_loc');
            $location = $this->basic->check_location_exists($loc_name);

            $k = 0;
            $j = $get_todays_cnt + 1;
            $arr = [];
            $arr['pallet_id'] = $prefix . date('mdY') . '-' . $j;
            $arr['location_id'] = $location;
            $arr['received_by'] = $this->session->userdata('id');
            $insert_data = $arr;
            $k++;
            $j++;
            $id = $this->basic->insert('pallets', $insert_data);

            $serials = $this->master->get_data($data['serial_array']);
            $update_arr = [];
            foreach ($serials as $k => $v) {
                $update_arr[] = [
                    'id' => $v['sid'],
                    'pallet_id' => $id,
                ];
            }
            $this->basic->update_multiple('product_serials', $update_arr, 'id');
        }
        $print = $this->load->view('create_pallet/print_contents', $data, true);
        echo json_encode($print);
        die;
    }

    public function print_labels()
    {
        $get_todays_cnt = $this->receiving->get_todays_total_pallets();
        $pallet_type = '';
        $prefix = '';
        $action = '';
        if ($this->input->post() || $this->input->post('print_labels')) {
            if ($this->input->post('action') == 'pallet') {
                $action = 'pallet';
            }
            if ($this->input->post('action') == 'cart') {
                $action = 'cart';
            }
            if ($this->input->post('action') == 'other') {
                $action = 'other';
            }
            if ($this->input->post('pallet_type') == 'receiving') {
                $pallet_type = 'receiving';
                $prefix = 'RE';
            }
            if ($this->input->post('pallet_type') == 'testing') {
                $pallet_type = 'testing';
                $prefix = 'TE';
            }
            if ($this->input->post('pallet_type') == 'packout') {
                $pallet_type = 'packing';
                $prefix = 'PO';
            }
            if ($this->input->post('pallet_type') == 'inventory') {
                $pallet_type = 'inventory';
                $prefix = 'IN';
            }
            
            
            $data['action'] = $action;
            $data['pallet_type'] = $pallet_type;
            $data['serial_array'] = $_POST['serials'];
            $data['serials'] = $this->master->get_data($data['serial_array']);
            $loc_name = $this->input->post('scan_loc');
            $location = $this->basic->check_location_exists($loc_name);
			
            $k = 0;
            $j = $get_todays_cnt + 1;
			$arr = [];
			if($action == 'cart'){
				$arr['pallet_id'] = $prefix . date('mdY') . '-' . $j.'C';
			}else if($action == 'other'){
				$arr['pallet_id'] = $prefix . date('mdY') . '-' . $j.'X';
			}else{
				$arr['pallet_id'] = $prefix . date('mdY') . '-' . $j;
			}
            $arr['location_id'] = $location;
            $arr['received_by'] = $this->session->userdata('id');
            $insert_data = $arr;
            $k++;
			$j++;
            
            $id = $this->basic->insert('pallets', $insert_data);
            $serials = $this->master->get_data($data['serial_array']);
            $update_arr = [];
            foreach ($serials as $k => $v) {
                $update_arr[] = [
                    'id' => $v['sid'],
                    'location_id' => $insert_data['location_id'],
                    'pallet_id' => $id,
                ];
            }
            $this->basic->update_multiple('product_serials', $update_arr, 'id');

            $this->session->set_userdata(array('pallet_data_new' => $insert_data));
            $session_data = [];
			$session_data['pallet_id'] = $insert_data['pallet_id'];
			$session_data['pallet_type'] = $pallet_type;
			$session_data['action'] = $action;
			$session_data['location'] = [];
			if($insert_data['location_id']!=''){
				$location_name = $this->basic->get_data_by_id('locations',$insert_data['location_id']);
				$session_data['location'] = $location_name['name'];
			}
            // pr($session_data);die;
			$this->session->set_userdata(array('pallets_new' => $session_data));
			echo json_encode($session_data);
			die;
        }
    }
}
