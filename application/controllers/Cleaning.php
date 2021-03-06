<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cleaning extends CI_Controller {

    public $layout = '';

    public function __construct() {
        parent::__construct();
        $this->load->model('Product_model', 'products');
		$this->load->model('Basic_model', 'basic');
		$this->load->model('Locations_model', 'locations');
        if ($this->uri->segment(1) == 'admin' && !$this->session->userdata('admin_validated')) {
            redirect('admin/login');
        } else if ($this->uri->segment(1) == 'cleaning' && !$this->session->userdata('user_validated')) {
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

    public function packout() {
        if ($this->input->post()) {
            $product_data = [
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description'),
            ];
            $category = [];
            if ($this->input->post('category1')) {
                $category[] = $this->input->post('category1');
            }
            if ($this->input->post('category2')) {
                $category[] = $this->input->post('category2');
            }
            if ($this->input->post('category3')) {
                $category[] = $this->input->post('category3');
            }
            $product_data['category'] = json_encode($category);
            $this->basic->update('products', $product_data, ['part' => $this->input->post('part')]);
            $packaging_fields = [
                'candy_box' => ($this->input->post('candy_box')) ? 1 : 0,
                'brown_box' => ($this->input->post('brown_box')) ? 1 : 0,
                'damaged_box' => ($this->input->post('damaged_box')) ? 1 : 0
            ];
            $cleaning_fields = [
                'cleaned' => ($this->input->post('cleaned')) ? 1 : 0,
                'taped' => ($this->input->post('taped')) ? 1 : 0,
                'bagged' => ($this->input->post('bagged')) ? 1 : 0
            ];
            $accessory_array = $this->input->post('access_name');
            $access_name = json_encode($accessory_array);
            $serial_data = [
                'new_serial' => $this->input->post('new_serial'),
                'recv_notes' => $this->input->post('recv_notes'),
                'additional_accessories' => $this->input->post('additional_accessories'),
                'accessory_name' => $access_name,
                'packaging' => json_encode($packaging_fields),
                'cleaning' => json_encode($cleaning_fields),
                'packaging_ui' => $this->input->post('packaging_ui'),
                'packaging_notes' => $this->input->post('packout_notes'),
                'packaging_condition' => ($this->input->post('packaging_condition')) ? $this->input->post('packaging_condition') : '',
                'other_status' => $this->input->post('other_status') ? $this->input->post('other_status') : null
            ];
            $pallet_name = $this->input->post('scan_loc');
            $pallet = $this->basic->check_pallet_exists($pallet_name);
            if ($this->input->post('scan_loc_check') && $this->input->post('add')) {
                $pallet_location_name = $this->input->post('scan_loc');
                $pallet_location = $this->basic->check_location_exists($pallet_location_name);
            } else {
                $serial_data['pallet_id'] = $pallet;
            }
            // $pallet_name = $this->input->post('current_pallet');
            // $pallet = $this->basic->check_pallet_exists($pallet_name);
            // $loc_name = $this->input->post('scan_loc');
            // $location = $this->basic->check_location_exists($loc_name);
            // if($this->input->post('add') && ($this->input->post('current_pallet') !='')){
            // $serial_data['pallet_id'] = $this->input->post('current_pallet_id');
            // $serial_data['location_id'] = $this->input->post('scan_loc_id');
            // }else 
            // if($this->input->post('add') && $this->input->post('current_pallet')){
            // 	$serial_data['pallet_id'] = $pallet['id'];
            // }
            // if($this->input->post('close') && ($this->input->post('scan_loc') !='')){
            // 	$serial_data['pallet_id'] = $this->input->post('current_pallet_id');
            // 	$serial_data['location_id'] = $this->input->post('scan_loc_id');
            // }else 
            // if($this->input->post('add') && $this->input->post('scan_loc')){
            // 	$serial_data['location_id'] = $location;
            // }
            // echo"serial data";pr($serial_data);
            // die;
            $serial_data['packout_complete'] = ($this->input->post('packout_complete')) ? 1 : 0;
            if ($serial_data['packout_complete'] == '1') {
                $serial_data['status'] = 'Ready For Sale';
            }
            // pr($serial_data);die;
            $serial_data['send_to_finished_goods'] = ($this->input->post('send_to_finished_goods')) ? 1 : 0;
            $serial_data['cd_software'] = ($this->input->post('cd_software')) ? 1 : 0;
            $serial_data['power_cord'] = ($this->input->post('power_cord')) ? 1 : 0;
            $serial_data['manual'] = ($this->input->post('manual')) ? 1 : 0;
            $filesCount = count($_FILES['product_files']['name']);
            $product_id = $this->input->post('product_id');
            $serial_id = $this->input->post('serial_id');
            $root_path = $this->input->server('DOCUMENT_ROOT');
            $serial_files = [];
            for ($i = 0; $i < $filesCount; $i++) {
                $_FILES['userFile']['name'] = $_FILES['product_files']['name'][$i];
                $_FILES['userFile']['type'] = $_FILES['product_files']['type'][$i];
                $_FILES['userFile']['tmp_name'] = $_FILES['product_files']['tmp_name'][$i];
                $_FILES['userFile']['error'] = $_FILES['product_files']['error'][$i];
                $_FILES['userFile']['size'] = $_FILES['product_files']['size'][$i];
                $folderPath = '/assets/uploads/' . $product_id . '/' . 'serials/' . $serial_id;
                $uploadPath = $root_path . $folderPath;
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }
                $config['upload_path'] = $uploadPath;
                $config['allowed_types'] = '*';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload('userFile')) {
                    $fileData = $this->upload->data();
                    $serial_files[] = $fileData['file_name'];
                }
            }
            if (!empty($serial_data)) {
                $serial_data['files'] = implode(',', $serial_files);
            }

			$product_serial = $this->basic->get_single_data_by_criteria('product_serials', ['serial' => $this->input->post('serial')]);
			$pallet_data = $this->locations->get_pallet_by_serial($this->input->post('serial'));
            if ($this->basic->update('product_serials', $serial_data, ['serial' => $this->input->post('serial')])) {
                $pallet_location_update_data = ['location_id' => $pallet_location];
                $this->basic->update('pallets', $pallet_location_update_data, ['id' => $product_serial['pallet_id']]);
                $timestamp = [
                    'last_scan' => date('Y-m-d H:i:s'),
                    'packout_date' => date('Y-m-d H:i:s')
				];
				if (isset($pallet_data['locid'])) {
                    if ($product_serial['pallet_id'] != $pallet_data['locid']) {
                        $timestamp['location_assigned_date'] = date('Y-m-d H:i:s');
                    }
                }
                $this->basic->update('serial_timestamps', $timestamp, ['serial_id' => $product_serial['id']]);
                $this->session->set_flashdata('msg', 'Details Saved');
            }
            $role_name = ($this->session->userdata('role_name') == 'Admin') ? 'cleaning' : $this->session->userdata('role_name');
            redirect($this->admin_prefix . $role_name . '/packout');
        }
        $data['title'] = 'Packout';
        $data['ajax_url'] = ($this->uri->segment(1) == 'admin') ? 'admin/products/find_product' : 'products/find_product';
        $data['original_condition'] = $this->products->get_key_value_pair('original_condition');
        $data['fail_options'] = $this->products->get_key_value_pair('fail_options');
        $data['cosmetic_issues'] = $this->products->get_key_value_pair('cosmetic_issues');
        $data['cat_url'] = ($this->uri->segment(1) == 'admin') ? 'admin/barcode/get_sub_category' : 'barcode/get_sub_category';
        $category_names = $this->products->get_categories();
        $data['categories'] = $category_names;
        $data['admin_prefix'] = $this->admin_prefix;
        //$data['current_pallet'] = $this->products->get_current_pallet();
        $this->template->load($this->layout, 'cleaning/packout', $data);
    }

}
