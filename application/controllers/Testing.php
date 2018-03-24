<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Testing extends CI_Controller {
	public $layout = '';
	public function __construct(){
		parent::__construct();
		$this->load->model('Product_model','products');
		$this->load->model('Basic_model','basic');
		if($this->uri->segment(1)=='admin' && !$this->session->userdata('admin_validated')){
			redirect('admin/login');
		}else if($this->uri->segment(1)=='testing' && !$this->session->userdata('user_validated')) {
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
	public function notebook(){
		if($this->input->post()){
        //    pr($this->input->post());die;
			$product_data = [
				'name' => $this->input->post('name'),
				'description' => $this->input->post('description'),
			];
			$category = [];
			if($this->input->post('category1')){
				$category[] = $this->input->post('category1');
			}
			if($this->input->post('category2')){
				$category[] = $this->input->post('category2');
			}
			if($this->input->post('category3')){
				$category[]  = $this->input->post('category3');
			}
			
			$product_data['category'] = json_encode($category);
			// pr($product_data,1);
			$this->basic->update('products', $product_data, ['part'=>$this->input->post('part')]);
			$cosmetic_issue = json_encode($this->input->post('cosmetic_issue'));
			$cosmetic_issues_text = json_encode([
				'cs1' => $this->input->post('cs1'),
				'cs2' => $this->input->post('cs2')
			]);
//			$fail_text = json_encode([
//				'fail_1' => $this->input->post('fail_1'),
//				'fail_2' => $this->input->post('fail_2'),
//				'fail_3' => $this->input->post('fail_3')
//			]);
            $fail_text = $this->input->post('fail_text');
            $cpu = json_encode($this->input->post('cpu'));
            
            $storage_array = $this->input->post('storage');
            $storage = json_encode($storage_array);
            $storage_cnt = sizeof($storage_array);
            $ssd_array = [];
            for($i=0;$i<$storage_cnt;$i++){
                $s = ($this->input->post('ssd'.$i)) ? 1 : 0;
                $ssd_array[] = $s;
            }
            $graphics_array = $this->input->post('graphics');
            $graphics = json_encode($graphics_array);
            $graphics_cnt = sizeof($graphics_array);
            $dedicated_array = [];
            for($i=0;$i<$graphics_cnt;$i++){
                $s = ($this->input->post('dedicated'.$i)) ? 1 : 0;
                $dedicated_array[] = $s;
            }
            

            $product_serial_data = $this->basic->get_single_data_by_criteria('product_serials', ['serial'=>$this->input->post('serial')]);
            $timestamp = [
            	'testing_date'=>date('Y-m-d H:i:s'),
            	'last_scan'=>date('Y-m-d H:i:s')
            ];

            $access_type_array = $this->input->post('access_type');
            $access_type = json_encode($access_type_array);

            $access_name_array = $this->input->post('access_name');
            $access_name = json_encode($access_name_array);
            $loc_name = $this->input->post('scan_loc');
            $location = $this->basic->check_location_exists($loc_name);
			$serial_data = [
				'new_serial' => $this->input->post('new_serial'),
				'recv_notes' => $this->input->post('recv_notes'),
				'cpu' => $cpu,
				'memory' => $this->input->post('memory'),
				'storage' => $storage,
				'graphics' => $graphics,
				'screen' => $this->input->post('screen'),
				'resolution' => $this->input->post('resolution'),
				'size' => $this->input->post('size'),
				'os' => $this->input->post('os'),
				'additional_info' => $this->input->post('additional_info'),
				'additional_features' => $this->input->post('additional_features'),
                'additional_accessories' => $this->input->post('additional_accessories'),
                'accessory_type' => $access_type,
                'accessory_name' => $access_name,	
				'fail_option' => $this->input->post('fail_option'),
				'fail_reason_notes' => ($this->input->post('fail_reason_notes')) ? $this->input->post('fail_reason_notes') : null,
				'condition' => $this->input->post('final_condition'),
				'warranty' => $this->input->post('warranty'),
				'tech_notes' => $this->input->post('tech_notes'),
				'cosmetic_issues_text' => $cosmetic_issues_text,
				'cosmetic_issue' => $cosmetic_issue,
				'fail_text' => $fail_text,
				// 'cosmetic_grade' => $this->input->post('cosmetic_grade'),
                // 'status' => $this->input->post('status'),
                'location_id' => $location['id'],
				'other_status' => $this->input->post('other_status') ? $this->input->post('other_status') : null
            ];
            if($product_serial_data['location_id'] != $serial_data['location_id']){
				$timestamp['location_assigned_date'] = date('Y-m-d H:i:s');
			}
            if($product_serial_data['status'] != $serial_data['status']){
				$timestamp['status_change_date'] = date('Y-m-d H:i:s');
            }
            $serial_data['cosmetic_grade'] = $this->input->post('cosmetic_grade');
            if($serial_data['cosmetic_grade'] == 'MN'){
                $serial_data['status'] = 'Packout';
            }else if($serial_data['cosmetic_grade'] == 'F'){
                $serial_data['status'] = 'Awating Repair';
            }else if($serial_data['cosmetic_grade'] == 'X'){
                $serial_data['status'] = 'Failed';
            }else{
                $serial_data['status'] = $this->input->post('status');
            }
			// $serial_data['ssd'] = ($this->input->post('ssd')) ? 1 : 0;
			$serial_data['ssd'] = json_encode($ssd_array);
			// $serial_data['dedicated'] = ($this->input->post('dedicated')) ? 1 : 0;
			$serial_data['dedicated'] = json_encode($dedicated_array);
			$serial_data['touch_screen'] = ($this->input->post('touch_screen')) ? 1 : 0;
			$serial_data['optical_drive'] = ($this->input->post('optical_drive')) ? 1 : 0;
			$serial_data['webcam'] = ($this->input->post('webcam')) ? 1 : 0;
			$serial_data['cd_software'] = ($this->input->post('cd_software')) ? 1 : 0;
			$serial_data['power_cord'] = ($this->input->post('power_cord')) ? 1 : 0;
			$serial_data['manual'] = ($this->input->post('manual')) ? 1 : 0;
			$serial_data['fail'] = ($this->input->post('fail')) ? 1 : 0;
			$serial_data['pass'] = ($this->input->post('pass')) ? 1 : 0;
            $serial_data['factory_reset'] = ($this->input->post('factory_reset')) ? 1 : 0;
            if($product_serial_data['factory_reset'] != $serial_data['factory_reset']){
				$timestamp['factory_reset_date'] = date('Y-m-d H:i:s');
			}
            $serial_data['hard_drive_wiped'] = ($this->input->post('hard_drive_wiped')) ? 1 : 0;
            if($product_serial_data['hard_drive_wiped'] != $serial_data['hard_drive_wiped']){
				$timestamp['hard_drive_wiped_date'] = date('Y-m-d H:i:s');
			}
			$serial_data['tested_by'] = $this->session->userdata('id');
			$filesCount = count($_FILES['product_files']['name']);
			$product_id = $this->input->post('product_id');
			$serial_id = $this->input->post('serial_id');
			$serial = trim($this->input->post('serial'));
            $root_path = $this->input->server('DOCUMENT_ROOT');
            $serial_files = [];
            $serial_files = ($this->input->post('files')!='') ? explode(',', $this->input->post('files')) : [];
            $no_of_files = sizeof($serial_files);
            for($i = 0; $i < $filesCount; $i++){
            	$j=$i+1;
            	$fn = explode('.',$_FILES['product_files']['name'][$i]);
            	$fn_extension = end($fn);
            	$cnt = $no_of_files+$j;
                $_FILES['userFile']['name'] = $serial.'_'.$cnt.'.'.$fn_extension;
                // $_FILES['userFile']['name'] = $_FILES['product_files']['name'][$i];
                $_FILES['userFile']['type'] = $_FILES['product_files']['type'][$i];
                $_FILES['userFile']['tmp_name'] = $_FILES['product_files']['tmp_name'][$i];
                $_FILES['userFile']['error'] = $_FILES['product_files']['error'][$i];
                $_FILES['userFile']['size'] = $_FILES['product_files']['size'][$i];
                $folderPath = '/assets/uploads/'.$product_id.'/'.'serials/'.$serial_id;
                $uploadPath = $root_path . $folderPath;
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }
                $config['upload_path'] = $uploadPath; 
                $config['allowed_types'] = '*';
                
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
               
                if($this->upload->do_upload('userFile')){
                    $fileData = $this->upload->data();
                    $serial_files[] = $fileData['file_name'];
                }
            }
           
            if(!empty($serial_data)){
            	$serial_data['files'] = implode(',',$serial_files);
            }
			if($this->basic->update('product_serials', $serial_data, ['serial'=>$this->input->post('serial')])){
                $this->basic->update('serial_timestamps', $timestamp, ['serial_id'=>$product_serial_data['id']]);
                $this->session->set_flashdata('msg', 'Details Saved');
			}
			$role_name = ($this->session->userdata('role_name') == 'Admin') ? 'testing' : $this->session->userdata('role_name');
			$tester = $this->basic->get_single_data_by_criteria('users',['id' => $this->session->userdata('id')]);
            $cnt = 0;
            $tester_data = [
                'notebook_count' => $tester['notebook_count'] + 1
            ];
            $this->basic->update('users', $tester_data,['id' => $this->session->userdata('id')]);
			redirect($this->admin_prefix.$role_name.'/notebook');
		}
		$data['title'] = 'Notebook Testing';
		$data['ajax_url'] = ($this->uri->segment(1)=='admin') ? 'admin/products/find_product' : 'products/find_product';
		$data['original_condition'] = $this->products->get_key_value_pair('original_condition');
		$data['fail_options'] = $this->products->get_key_value_pair('fail_options');
		$data['cosmetic_issues'] = $this->products->get_key_value_pair('cosmetic_issues');
		$data['cat_url'] = ($this->uri->segment(1)=='admin') ? 'admin/barcode/get_sub_category' : 'barcode/get_sub_category';
		$category_names = $this->products->get_categories();
        $data['categories'] = $category_names;
        $data['admin_prefix'] = $this->admin_prefix;
		$this->template->load($this->layout, 'testing/notebook', $data);
	}
	public function desktop(){
		if($this->input->post()){
			$product_data = [
				'name' => $this->input->post('name'),
				'description' => $this->input->post('description'),
			];
			$category = [];
			if($this->input->post('category1')){
				$category[] = $this->input->post('category1');
			}
			if($this->input->post('category2')){
				$category[] = $this->input->post('category2');
			}
			if($this->input->post('category3')){
				$category[]  = $this->input->post('category3');
			}
			
			$product_data['category'] = json_encode($category);
			// pr($product_data,1);
			$this->basic->update('products', $product_data, ['part'=>$this->input->post('part')]);
			$cosmetic_issue = json_encode($this->input->post('cosmetic_issue'));
			$cosmetic_issues_text = json_encode([
				'cs1' => $this->input->post('cs1'),
				'cs2' => $this->input->post('cs2')
			]);
			$fail_text = $this->input->post('fail_text');
            $cpu = json_encode($this->input->post('cpu'));
            
            $storage_array = $this->input->post('storage');
            $storage = json_encode($storage_array);
            $storage_cnt = sizeof($storage_array);
            $ssd_array = [];
            for($i=0;$i<$storage_cnt;$i++){
                $s = ($this->input->post('ssd'.$i)) ? 1 : 0;
                $ssd_array[] = $s;
            }
            $graphics_array = $this->input->post('graphics');
            $graphics = json_encode($graphics_array);
            $graphics_cnt = sizeof($graphics_array);
            $dedicated_array = [];
            for($i=0;$i<$graphics_cnt;$i++){
                $s = ($this->input->post('dedicated'.$i)) ? 1 : 0;
                $dedicated_array[] = $s;
            }
            $access_type_array = $this->input->post('access_type');
            $access_type = json_encode($access_type_array);

            $access_name_array = $this->input->post('access_name');
            $access_name = json_encode($access_name_array);
			$serial_data = [
				'new_serial' => $this->input->post('new_serial'),
				'recv_notes' => $this->input->post('recv_notes'),
				'cpu' => $cpu,
				'memory' => $this->input->post('memory'),
				'storage' => $storage,
				'graphics' => $graphics,
				'form_factor' => $this->input->post('form_factor'),
				'os' => $this->input->post('os'),
				'additional_info' => $this->input->post('additional_info'),
				'additional_features' => $this->input->post('additional_features'),
                'additional_accessories' => $this->input->post('additional_accessories'),
                'accessory_type' => $access_type,
                'accessory_name' => $access_name,
				'fail_option' => $this->input->post('fail_option'),
				'fail_reason_notes' => ($this->input->post('fail_reason_notes')) ? $this->input->post('fail_reason_notes') : null,
				'condition' => $this->input->post('final_condition'),
				'warranty' => $this->input->post('warranty'),
				'tech_notes' => $this->input->post('tech_notes'),
				'cosmetic_issues_text' => $cosmetic_issues_text,
				'cosmetic_issue' => $cosmetic_issue,
				'fail_text' => $fail_text,
				'cosmetic_grade' => $this->input->post('cosmetic_grade'),
				'status' => $this->input->post('status'),
				'location_id' => $location['id'],
				'other_status' => $this->input->post('other_status') ? $this->input->post('other_status') : null
            ];
            if($product_serial_data['location_id'] != $serial_data['location_id']){
				$timestamp['location_assigned_date'] = date('Y-m-d H:i:s');
			}
            if($product_serial_data['status'] != $serial_data['status']){
				$timestamp['status_change_date'] = date('Y-m-d H:i:s');
			}
			// $serial_data['ssd'] = ($this->input->post('ssd')) ? 1 : 0;
			$serial_data['ssd'] = json_encode($ssd_array);
			// $serial_data['dedicated'] = ($this->input->post('dedicated')) ? 1 : 0;
			$serial_data['dedicated'] = json_encode($dedicated_array);
			$serial_data['desktop_other'] = ($this->input->post('desktop_other')) ? 1 : 0;
			$serial_data['optical_drive'] = ($this->input->post('optical_drive')) ? 1 : 0;
			$serial_data['mouse_keyboard'] = ($this->input->post('mouse_keyboard')) ? 1 : 0;
			$serial_data['cd_software'] = ($this->input->post('cd_software')) ? 1 : 0;
			$serial_data['power_cord'] = ($this->input->post('power_cord')) ? 1 : 0;
			$serial_data['manual'] = ($this->input->post('manual')) ? 1 : 0;
			$serial_data['fail'] = ($this->input->post('fail')) ? 1 : 0;
			$serial_data['pass'] = ($this->input->post('pass')) ? 1 : 0;
			$serial_data['factory_reset'] = ($this->input->post('factory_reset')) ? 1 : 0;
			 if($product_serial_data['factory_reset'] != $serial_data['factory_reset']){
				$timestamp['factory_reset_date'] = date('Y-m-d H:i:s');
			}
            $serial_data['hard_drive_wiped'] = ($this->input->post('hard_drive_wiped')) ? 1 : 0;
            if($product_serial_data['hard_drive_wiped'] != $serial_data['hard_drive_wiped']){
				$timestamp['hard_drive_wiped_date'] = date('Y-m-d H:i:s');
			}
			$serial_data['tested_by'] = $this->session->userdata('id');
			$filesCount = count($_FILES['product_files']['name']);
			$product_id = $this->input->post('product_id');
			$serial_id = $this->input->post('serial_id');
            $root_path = $this->input->server('DOCUMENT_ROOT');
            $serial_files = [];
            $serial_files = ($this->input->post('files')!='') ? explode(',', $this->input->post('files')) : [];
            $no_of_files = sizeof($serial_files);
            for($i = 0; $i < $filesCount; $i++){
            	$j=$i+1;
            	$fn = explode('.',$_FILES['product_files']['name'][$i]);
            	$fn_extension = end($fn);
            	$cnt = $no_of_files+$j;
                $_FILES['userFile']['name'] = $serial.'_'.$cnt.'.'.$fn_extension;
                $_FILES['userFile']['type'] = $_FILES['product_files']['type'][$i];
                $_FILES['userFile']['tmp_name'] = $_FILES['product_files']['tmp_name'][$i];
                $_FILES['userFile']['error'] = $_FILES['product_files']['error'][$i];
                $_FILES['userFile']['size'] = $_FILES['product_files']['size'][$i];
                $folderPath = '/assets/uploads/'.$product_id.'/'.'serials/'.$serial_id;
                $uploadPath = $root_path . $folderPath;
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }
                $config['upload_path'] = $uploadPath; 
                $config['allowed_types'] = '*';
                
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
               
                if($this->upload->do_upload('userFile')){
                    $fileData = $this->upload->data();
                    $serial_files[] = $fileData['file_name'];
                }
            }
            
            if(!empty($serial_data)){
            	$serial_data['files'] = implode(',',$serial_files);
            }
			if($this->basic->update('product_serials', $serial_data, ['serial'=>$this->input->post('serial')])){
				$this->basic->update('serial_timestamps', $timestamp, ['serial_id'=>$product_serial_data['id']]);
				$this->session->set_flashdata('msg', 'Details Saved');
			}
			$role_name = ($this->session->userdata('role_name') == 'Admin') ? 'testing' : $this->session->userdata('role_name');
			$tester = $this->basic->get_single_data_by_criteria('users',['id' => $this->session->userdata('id')]);
            $cnt = 0;
            $tester_data = [
                'desktop_count' => $tester['desktop_count'] + 1
            ];
            $this->basic->update('users', $tester_data,['id' => $this->session->userdata('id')]);
			redirect($this->admin_prefix.$role_name.'/desktop');
		}
		$data['title'] = 'Desktop Testing';
		$data['ajax_url'] = ($this->uri->segment(1)=='admin') ? 'admin/products/find_product' : 'products/find_product';
		$data['original_condition'] = $this->products->get_key_value_pair('original_condition');
		$data['fail_options'] = $this->products->get_key_value_pair('fail_options');
		$data['cosmetic_issues'] = $this->products->get_key_value_pair('cosmetic_issues');
		$data['cat_url'] = ($this->uri->segment(1)=='admin') ? 'admin/barcode/get_sub_category' : 'barcode/get_sub_category';
		$category_names = $this->products->get_categories();
        $data['categories'] = $category_names;
        $data['admin_prefix'] = $this->admin_prefix;
		$this->template->load($this->layout, 'testing/desktop', $data);
	}
	public function thin_client(){
		if($this->input->post()){
			$product_data = [
				'name' => $this->input->post('name'),
				'description' => $this->input->post('description'),
			];
			$category = [];
			if($this->input->post('category1')){
				$category[] = $this->input->post('category1');
			}
			if($this->input->post('category2')){
				$category[] = $this->input->post('category2');
			}
			if($this->input->post('category3')){
				$category[]  = $this->input->post('category3');
			}
			
			$product_data['category'] = json_encode($category);
			// pr($product_data,1);
			$this->basic->update('products', $product_data, ['part'=>$this->input->post('part')]);
			$cosmetic_issue = json_encode($this->input->post('cosmetic_issue'));
			$cosmetic_issues_text = json_encode([
				'cs1' => $this->input->post('cs1'),
				'cs2' => $this->input->post('cs2')
			]);
			$fail_text = $this->input->post('fail_text');
			$cpu = json_encode($this->input->post('cpu'));
            
            $storage_array = $this->input->post('storage');
            $storage = json_encode($storage_array);
            $storage_cnt = sizeof($storage_array);
            $ssd_array = [];
            for($i=0;$i<$storage_cnt;$i++){
                $s = ($this->input->post('ssd'.$i)) ? 1 : 0;
                $ssd_array[] = $s;
            }
            $graphics_array = $this->input->post('graphics');
            $graphics = json_encode($graphics_array);
            $graphics_cnt = sizeof($graphics_array);
            $dedicated_array = [];
            for($i=0;$i<$graphics_cnt;$i++){
                $s = ($this->input->post('dedicated'.$i)) ? 1 : 0;
                $dedicated_array[] = $s;
            }
            

            $product_serial_data = $this->basic->get_single_data_by_criteria('product_serials', ['serial'=>$this->input->post('serial')]);
            $timestamp = [
            	'testing_date'=>date('Y-m-d H:i:s'),
            	'last_scan'=>date('Y-m-d H:i:s')
            ];
            $access_type_array = $this->input->post('access_type');
            $access_type = json_encode($access_type_array);

            $access_name_array = $this->input->post('access_name');
            $access_name = json_encode($access_name_array);
			$serial_data = [
				'new_serial' => $this->input->post('new_serial'),
				'recv_notes' => $this->input->post('recv_notes'),
				'cpu' => $cpu,
				'memory' => $this->input->post('memory'),
				'storage' => $storage,
				'graphics' => $graphics,
				'form_factor' => $this->input->post('form_factor'),
				'os' => $this->input->post('os'),
				'additional_info' => $this->input->post('additional_info'),
				'additional_features' => $this->input->post('additional_features'),
                'additional_accessories' => $this->input->post('additional_accessories'),
                'accessory_type' => $access_type,
                'accessory_name' => $access_name,	
				'fail_option' => $this->input->post('fail_option'),
				'fail_reason_notes' => ($this->input->post('fail_reason_notes')) ? $this->input->post('fail_reason_notes') : null,
				'condition' => $this->input->post('final_condition'),
				'warranty' => $this->input->post('warranty'),
				'tech_notes' => $this->input->post('tech_notes'),
				'cosmetic_issues_text' => $cosmetic_issues_text,
				'cosmetic_issue' => $cosmetic_issue,
				'fail_text' => $fail_text,
				'cosmetic_grade' => $this->input->post('cosmetic_grade'),
				'status' => $this->input->post('status'),
				'location_id' => $location['id'],
				'other_status' => $this->input->post('other_status') ? $this->input->post('other_status') : null
			];
			if($product_serial_data['location_id'] != $serial_data['location_id']){
				$timestamp['location_assigned_date'] = date('Y-m-d H:i:s');
			}
            if($product_serial_data['status'] != $serial_data['status']){
				$timestamp['status_change_date'] = date('Y-m-d H:i:s');
			}
			// $serial_data['ssd'] = ($this->input->post('ssd')) ? 1 : 0;
			$serial_data['ssd'] = json_encode($ssd_array);
			// $serial_data['dedicated'] = ($this->input->post('dedicated')) ? 1 : 0;
			$serial_data['dedicated'] = json_encode($dedicated_array);
			$serial_data['desktop_other'] = ($this->input->post('desktop_other')) ? 1 : 0;
			$serial_data['optical_drive'] = ($this->input->post('optical_drive')) ? 1 : 0;
			$serial_data['mouse_keyboard'] = ($this->input->post('mouse_keyboard')) ? 1 : 0;
			$serial_data['cd_software'] = ($this->input->post('cd_software')) ? 1 : 0;
			$serial_data['power_cord'] = ($this->input->post('power_cord')) ? 1 : 0;
			$serial_data['manual'] = ($this->input->post('manual')) ? 1 : 0;
			$serial_data['fail'] = ($this->input->post('fail')) ? 1 : 0;
			$serial_data['pass'] = ($this->input->post('pass')) ? 1 : 0;
			$serial_data['factory_reset'] = ($this->input->post('factory_reset')) ? 1 : 0;
			 if($product_serial_data['factory_reset'] != $serial_data['factory_reset']){
				$timestamp['factory_reset_date'] = date('Y-m-d H:i:s');
			}
            $serial_data['hard_drive_wiped'] = ($this->input->post('hard_drive_wiped')) ? 1 : 0;
            if($product_serial_data['hard_drive_wiped'] != $serial_data['hard_drive_wiped']){
				$timestamp['hard_drive_wiped_date'] = date('Y-m-d H:i:s');
			}
			$serial_data['tested_by'] = $this->session->userdata('id');
			$filesCount = count($_FILES['product_files']['name']);
			$product_id = $this->input->post('product_id');
			$serial_id = $this->input->post('serial_id');
            $root_path = $this->input->server('DOCUMENT_ROOT');
            $serial_files = [];
            $serial_files = ($this->input->post('files')!='') ? explode(',', $this->input->post('files')) : [];
            $no_of_files = sizeof($serial_files);
            for($i = 0; $i < $filesCount; $i++){
            	$j=$i+1;
            	$fn = explode('.',$_FILES['product_files']['name'][$i]);
            	$fn_extension = end($fn);
            	$cnt = $no_of_files+$j;
                $_FILES['userFile']['name'] = $serial.'_'.$cnt.'.'.$fn_extension;
                $_FILES['userFile']['type'] = $_FILES['product_files']['type'][$i];
                $_FILES['userFile']['tmp_name'] = $_FILES['product_files']['tmp_name'][$i];
                $_FILES['userFile']['error'] = $_FILES['product_files']['error'][$i];
                $_FILES['userFile']['size'] = $_FILES['product_files']['size'][$i];
                $folderPath = '/assets/uploads/'.$product_id.'/'.'serials/'.$serial_id;
                $uploadPath = $root_path . $folderPath;
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }
                $config['upload_path'] = $uploadPath; 
                $config['allowed_types'] = '*';
                
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
               
                if($this->upload->do_upload('userFile')){
                    $fileData = $this->upload->data();
                    $serial_files[] = $fileData['file_name'];
                }
            }
            
            if(!empty($serial_data)){
            	$serial_data['files'] = implode(',',$serial_files);
            }
			if($this->basic->update('product_serials', $serial_data, ['serial'=>$this->input->post('serial')])){
				$this->basic->update('serial_timestamps', $timestamp, ['serial_id'=>$product_serial_data['id']]);
				$this->session->set_flashdata('msg', 'Details Saved');
			}
			$role_name = ($this->session->userdata('role_name') == 'Admin') ? 'testing' : $this->session->userdata('role_name');
			$tester = $this->basic->get_single_data_by_criteria('users',['id' => $this->session->userdata('id')]);
            $cnt = 0;
            $tester_data = [
                'thinclient_count' => $tester['thinclient_count'] + 1
            ];
            $this->basic->update('users', $tester_data,['id' => $this->session->userdata('id')]);
			redirect($this->admin_prefix.$role_name.'/thin_client');
		
		}
		$data['title'] = 'Thin Client Testing';
		$data['ajax_url'] = ($this->uri->segment(1)=='admin') ? 'admin/products/find_product' : 'products/find_product';
		$data['cat_url'] = ($this->uri->segment(1)=='admin') ? 'admin/barcode/get_sub_category' : 'barcode/get_sub_category';
		$data['original_condition'] = $this->products->get_key_value_pair('original_condition');
		$data['fail_options'] = $this->products->get_key_value_pair('fail_options');
		$data['cosmetic_issues'] = $this->products->get_key_value_pair('cosmetic_issues');
		$category_names = $this->products->get_categories();
        $data['categories'] = $category_names;
        $data['admin_prefix'] = $this->admin_prefix;
		$this->template->load($this->layout, 'testing/thin_client', $data);
	}
	public function workstation(){
		if($this->input->post()){
			$product_data = [
				'name' => $this->input->post('name'),
				'description' => $this->input->post('description'),
			];
			$category = [];
			if($this->input->post('category1')){
				$category[] = $this->input->post('category1');
			}
			if($this->input->post('category2')){
				$category[] = $this->input->post('category2');
			}
			if($this->input->post('category3')){
				$category[]  = $this->input->post('category3');
			}
			
			$product_data['category'] = json_encode($category);
			// pr($product_data,1);
			$this->basic->update('products', $product_data, ['part'=>$this->input->post('part')]);
			$cosmetic_issue = json_encode($this->input->post('cosmetic_issue'));
			$cosmetic_issues_text = json_encode([
				'cs1' => $this->input->post('cs1'),
				'cs2' => $this->input->post('cs2')
			]);
			$fail_text = json_encode([
				'fail_1' => $this->input->post('fail_1'),
				'fail_2' => $this->input->post('fail_2'),
				'fail_3' => $this->input->post('fail_3')
			]);
			$serial_data = [
				'new_serial' => $this->input->post('new_serial'),
				'recv_notes' => $this->input->post('recv_notes'),
				'cpu' => $this->input->post('cpu'),
				'memory' => $this->input->post('memory'),
				'storage' => $this->input->post('storage'),
				'graphics' => $this->input->post('graphics'),
				'form_factor' => $this->input->post('form_factor'),
				'os' => $this->input->post('os'),
				'additional_info' => $this->input->post('additional_info'),
				'additional_features' => $this->input->post('additional_features'),
				'additional_accessories' => $this->input->post('additional_accessories'),
				'fail_option' => $this->input->post('fail_option'),
				'fail_reason_notes' => ($this->input->post('fail_reason_notes')) ? $this->input->post('fail_reason_notes') : null,
				'condition' => $this->input->post('final_condition'),
				'warranty' => $this->input->post('warranty'),
				'tech_notes' => $this->input->post('tech_notes'),
				'cosmetic_issues_text' => $cosmetic_issues_text,
				'cosmetic_issue' => $cosmetic_issue,
				'fail_text' => $fail_text,
				'cosmetic_grade' => $this->input->post('cosmetic_grade'),
				'status' => $this->input->post('status'),
				'other_status' => $this->input->post('other_status') ? $this->input->post('other_status') : null
			];
			$serial_data['ssd'] = ($this->input->post('ssd')) ? 1 : 0;
			$serial_data['dedicated'] = ($this->input->post('dedicated')) ? 1 : 0;
			$serial_data['desktop_other'] = ($this->input->post('desktop_other')) ? 1 : 0;
			$serial_data['optical_drive'] = ($this->input->post('optical_drive')) ? 1 : 0;
			$serial_data['secondary_storage'] = ($this->input->post('secondary_storage')) ? 1 : 0;
			$serial_data['mouse_keyboard'] = ($this->input->post('mouse_keyboard')) ? 1 : 0;
			$serial_data['cd_software'] = ($this->input->post('cd_software')) ? 1 : 0;
			$serial_data['power_cord'] = ($this->input->post('power_cord')) ? 1 : 0;
			$serial_data['manual'] = ($this->input->post('manual')) ? 1 : 0;
			$serial_data['fail'] = ($this->input->post('fail')) ? 1 : 0;
			$serial_data['pass'] = ($this->input->post('pass')) ? 1 : 0;
			$serial_data['factory_reset'] = ($this->input->post('factory_reset')) ? 1 : 0;
			$serial_data['hard_drive_wiped'] = ($this->input->post('hard_drive_wiped')) ? 1 : 0;
			$serial_data['tested_by'] = $this->session->userdata('id');
			$filesCount = count($_FILES['product_files']['name']);
			$product_id = $this->input->post('product_id');
			$serial_id = $this->input->post('serial_id');
            $root_path = $this->input->server('DOCUMENT_ROOT');
            $serial_files = [];
            $serial_files = ($this->input->post('files')!='') ? explode(',', $this->input->post('files')) : [];
            $no_of_files = sizeof($serial_files);
            for($i = 0; $i < $filesCount; $i++){
            	$j=$i+1;
            	$fn = explode('.',$_FILES['product_files']['name'][$i]);
            	$fn_extension = end($fn);
            	$cnt = $no_of_files+$j;
                $_FILES['userFile']['name'] = $serial.'_'.$cnt.'.'.$fn_extension;
                $_FILES['userFile']['type'] = $_FILES['product_files']['type'][$i];
                $_FILES['userFile']['tmp_name'] = $_FILES['product_files']['tmp_name'][$i];
                $_FILES['userFile']['error'] = $_FILES['product_files']['error'][$i];
                $_FILES['userFile']['size'] = $_FILES['product_files']['size'][$i];
                $folderPath = '/assets/uploads/'.$product_id.'/'.'serials/'.$serial_id;
                $uploadPath = $root_path . $folderPath;
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }
                $config['upload_path'] = $uploadPath; 
                $config['allowed_types'] = '*';
                
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
               
                if($this->upload->do_upload('userFile')){
                    $fileData = $this->upload->data();
                    $serial_files[] = $fileData['file_name'];
                }
            }
            
            if(!empty($serial_data)){
            	$serial_data['files'] = implode(',',$serial_files);
            }
			if($this->basic->update('product_serials', $serial_data, ['serial'=>$this->input->post('serial')])){
				$this->session->set_flashdata('msg', 'Details Saved');
			}
			$role_name = ($this->session->userdata('role_name') == 'Admin') ? 'testing' : $this->session->userdata('role_name');
			$tester = $this->basic->get_single_data_by_criteria('users',['id' => $this->session->userdata('id')]);
            $cnt = 0;
            $tester_data = [
                'workstation_count' => $tester['workstation_count'] + 1
            ];
            $this->basic->update('users', $tester_data,['id' => $this->session->userdata('id')]);
			redirect($this->admin_prefix.$role_name.'/workstation');
		
		}
		$data['title'] = 'Wokstation Testing';
		$data['ajax_url'] = ($this->uri->segment(1)=='admin') ? 'admin/products/find_product' : 'products/find_product';
		$data['original_condition'] = $this->products->get_key_value_pair('original_condition');
		$data['fail_options'] = $this->products->get_key_value_pair('fail_options');
		$data['cosmetic_issues'] = $this->products->get_key_value_pair('cosmetic_issues');
		$data['cat_url'] = ($this->uri->segment(1)=='admin') ? 'admin/barcode/get_sub_category' : 'barcode/get_sub_category';
		$category_names = $this->products->get_categories();
        $data['categories'] = $category_names;
        $data['admin_prefix'] = $this->admin_prefix;
		$this->template->load($this->layout, 'testing/workstation', $data);
	
	}
	public function all_in_one(){
		if($this->input->post()){
			$product_data = [
				'name' => $this->input->post('name'),
				'description' => $this->input->post('description'),
			];
			$category = [];
			if($this->input->post('category1')){
				$category[] = $this->input->post('category1');
			}
			if($this->input->post('category2')){
				$category[] = $this->input->post('category2');
			}
			if($this->input->post('category3')){
				$category[]  = $this->input->post('category3');
			}
			
			$product_data['category'] = json_encode($category);
			// pr($product_data,1);
			$this->basic->update('products', $product_data, ['part'=>$this->input->post('part')]);
			$cosmetic_issue = json_encode($this->input->post('cosmetic_issue'));
			$cosmetic_issues_text = json_encode([
				'cs1' => $this->input->post('cs1'),
				'cs2' => $this->input->post('cs2')
			]);
			$fail_text = $this->input->post('fail_text');
			$cpu = json_encode($this->input->post('cpu'));
            
            $storage_array = $this->input->post('storage');
            $storage = json_encode($storage_array);
            $storage_cnt = sizeof($storage_array);
            $ssd_array = [];
            for($i=0;$i<$storage_cnt;$i++){
                $s = ($this->input->post('ssd'.$i)) ? 1 : 0;
                $ssd_array[] = $s;
            }
            $graphics_array = $this->input->post('graphics');
            $graphics = json_encode($graphics_array);
            $graphics_cnt = sizeof($graphics_array);
            $dedicated_array = [];
            for($i=0;$i<$graphics_cnt;$i++){
                $s = ($this->input->post('dedicated'.$i)) ? 1 : 0;
                $dedicated_array[] = $s;
            }
            
            $access_type_array = $this->input->post('access_type');
            $access_type = json_encode($access_type_array);

            $access_name_array = $this->input->post('access_name');
            $access_name = json_encode($access_name_array);
			$serial_data = [
				'new_serial' => $this->input->post('new_serial'),
				'recv_notes' => $this->input->post('recv_notes'),
				'cpu' => $cpu,
				'memory' => $this->input->post('memory'),
				'storage' => $storage,
				'graphics' => $graphics,
				'screen' => $this->input->post('screen'),
				'size' => $this->input->post('size'),
				'os' => $this->input->post('os'),
				'additional_info' => $this->input->post('additional_info'),
				'additional_features' => $this->input->post('additional_features'),
                'additional_accessories' => $this->input->post('additional_accessories'),
                'accessory_type' => $access_type,
                'accessory_name' => $access_name,
				'fail_option' => $this->input->post('fail_option'),
				'fail_reason_notes' => ($this->input->post('fail_reason_notes')) ? $this->input->post('fail_reason_notes') : null,
				'condition' => $this->input->post('final_condition'),
				'warranty' => $this->input->post('warranty'),
				'tech_notes' => $this->input->post('tech_notes'),
				'cosmetic_issues_text' => $cosmetic_issues_text,
				'cosmetic_issue' => $cosmetic_issue,
				'fail_text' => $fail_text,
				'cosmetic_grade' => $this->input->post('cosmetic_grade'),
				'status' => $this->input->post('status'),
				'location_id' => $location['id'],
				'other_status' => $this->input->post('other_status') ? $this->input->post('other_status') : null
			];
			if($product_serial_data['location_id'] != $serial_data['location_id']){
				$timestamp['location_assigned_date'] = date('Y-m-d H:i:s');
			}
            if($product_serial_data['status'] != $serial_data['status']){
				$timestamp['status_change_date'] = date('Y-m-d H:i:s');
			}
			// $serial_data['ssd'] = ($this->input->post('ssd')) ? 1 : 0;
			$serial_data['ssd'] = json_encode($ssd_array);
			// $serial_data['dedicated'] = ($this->input->post('dedicated')) ? 1 : 0;
			$serial_data['dedicated'] = json_encode($dedicated_array);
			$serial_data['desktop_other'] = ($this->input->post('desktop_other')) ? 1 : 0;
			$serial_data['optical_drive'] = ($this->input->post('optical_drive')) ? 1 : 0;
			$serial_data['mouse_keyboard'] = ($this->input->post('mouse_keyboard')) ? 1 : 0;
			$serial_data['cd_software'] = ($this->input->post('cd_software')) ? 1 : 0;
			$serial_data['power_cord'] = ($this->input->post('power_cord')) ? 1 : 0;
			$serial_data['manual'] = ($this->input->post('manual')) ? 1 : 0;
			$serial_data['fail'] = ($this->input->post('fail')) ? 1 : 0;
			$serial_data['pass'] = ($this->input->post('pass')) ? 1 : 0;
			$serial_data['factory_reset'] = ($this->input->post('factory_reset')) ? 1 : 0;
            if($product_serial_data['factory_reset'] != $serial_data['factory_reset']){
				$timestamp['factory_reset_date'] = date('Y-m-d H:i:s');
			}
            $serial_data['hard_drive_wiped'] = ($this->input->post('hard_drive_wiped')) ? 1 : 0;
            if($product_serial_data['hard_drive_wiped'] != $serial_data['hard_drive_wiped']){
				$timestamp['hard_drive_wiped_date'] = date('Y-m-d H:i:s');
			}
			$serial_data['tested_by'] = $this->session->userdata('id');
			$filesCount = count($_FILES['product_files']['name']);
			$product_id = $this->input->post('product_id');
			$serial_id = $this->input->post('serial_id');
            $root_path = $this->input->server('DOCUMENT_ROOT');
            $serial_files = [];
             $serial_files = ($this->input->post('files')!='') ? explode(',', $this->input->post('files')) : [];
            $no_of_files = sizeof($serial_files);
            for($i = 0; $i < $filesCount; $i++){
            	$j=$i+1;
            	$fn = explode('.',$_FILES['product_files']['name'][$i]);
            	$fn_extension = end($fn);
            	$cnt = $no_of_files+$j;
                $_FILES['userFile']['name'] = $serial.'_'.$cnt.'.'.$fn_extension;
                $_FILES['userFile']['type'] = $_FILES['product_files']['type'][$i];
                $_FILES['userFile']['tmp_name'] = $_FILES['product_files']['tmp_name'][$i];
                $_FILES['userFile']['error'] = $_FILES['product_files']['error'][$i];
                $_FILES['userFile']['size'] = $_FILES['product_files']['size'][$i];
                $folderPath = '/assets/uploads/'.$product_id.'/'.'serials/'.$serial_id;
                $uploadPath = $root_path . $folderPath;
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }
                $config['upload_path'] = $uploadPath; 
                $config['allowed_types'] = '*';
                
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
               
                if($this->upload->do_upload('userFile')){
                    $fileData = $this->upload->data();
                    $serial_files[] = $fileData['file_name'];
                }
            }
            
            if(!empty($serial_data)){
            	$serial_data['files'] = implode(',',$serial_files);
            }
			if($this->basic->update('product_serials', $serial_data, ['serial'=>$this->input->post('serial')])){
				$this->basic->update('serial_timestamps', $timestamp, ['serial_id'=>$product_serial_data['id']]);
				$this->session->set_flashdata('msg', 'Details Saved');
			}
			$role_name = ($this->session->userdata('role_name') == 'Admin') ? 'testing' : $this->session->userdata('role_name');
			$tester = $this->basic->get_single_data_by_criteria('users',['id' => $this->session->userdata('id')]);
            $cnt = 0;
            $tester_data = [
                'allinone_count' => $tester['allinone_count'] + 1
            ];
            $this->basic->update('users', $tester_data,['id' => $this->session->userdata('id')]);
			redirect($this->admin_prefix.$role_name.'/all_in_one');
		}
		$data['title'] = 'All-In-One Testing';
		$data['ajax_url'] = ($this->uri->segment(1)=='admin') ? 'admin/products/find_product' : 'products/find_product';
		$data['original_condition'] = $this->products->get_key_value_pair('original_condition');
		$data['fail_options'] = $this->products->get_key_value_pair('fail_options');
		$data['cosmetic_issues'] = $this->products->get_key_value_pair('cosmetic_issues');
		$data['cat_url'] = ($this->uri->segment(1)=='admin') ? 'admin/barcode/get_sub_category' : 'barcode/get_sub_category';
		$category_names = $this->products->get_categories();
        $data['categories'] = $category_names;
        $data['admin_prefix'] = $this->admin_prefix;
		$this->template->load($this->layout, 'testing/all_in_one', $data);
	
	}
	public function tablet(){
		if($this->input->post()){
            
			$product_data = [
				'name' => $this->input->post('name'),
				'description' => $this->input->post('description'),
			];
			$category = [];
			if($this->input->post('category1')){
				$category[] = $this->input->post('category1');
			}
			if($this->input->post('category2')){
				$category[] = $this->input->post('category2');
			}
			if($this->input->post('category3')){
				$category[]  = $this->input->post('category3');
			}	
			$product_data['category'] = json_encode($category);
			// pr($product_data,1);
			$this->basic->update('products', $product_data, ['part'=>$this->input->post('part')]);
			$cosmetic_issue = json_encode($this->input->post('cosmetic_issue'));
			$cosmetic_issues_text = json_encode([
				'cs1' => $this->input->post('cs1'),
				'cs2' => $this->input->post('cs2')
			]);
			$fail_text = $this->input->post('fail_text');
			$cpu = json_encode($this->input->post('cpu'));
            
            $storage_array = $this->input->post('storage');
            $storage = json_encode($storage_array);
            $storage_cnt = sizeof($storage_array);
            $ssd_array = [];
            for($i=0;$i<$storage_cnt;$i++){
                $s = ($this->input->post('ssd'.$i)) ? 1 : 0;
                $ssd_array[] = $s;
            }
            $graphics_array = $this->input->post('graphics');
            $graphics = json_encode($graphics_array);
            $graphics_cnt = sizeof($graphics_array);
            $dedicated_array = [];
            for($i=0;$i<$graphics_cnt;$i++){
                $s = ($this->input->post('dedicated'.$i)) ? 1 : 0;
                $dedicated_array[] = $s;
            }
			$product_serial_data = $this->basic->get_single_data_by_criteria('product_serials', ['serial'=>$this->input->post('serial')]);
            $timestamp = [
            	'testing_date'=>date('Y-m-d H:i:s'),
            	'last_scan'=>date('Y-m-d H:i:s')
            ];

            $loc_name = $this->input->post('scan_loc');
            $location = $this->basic->check_location_exists($loc_name);
            $access_type_array = $this->input->post('access_type');
            $access_type = json_encode($access_type_array);

            $access_name_array = $this->input->post('access_name');
            $access_name = json_encode($access_name_array);
			$serial_data = [
				'new_serial' => $this->input->post('new_serial'),
				'recv_notes' => $this->input->post('recv_notes'),
				'cpu' => $this->input->post('cpu'),
				'memory' => $this->input->post('memory'),
				'storage' => $this->input->post('storage'),
				'graphics' => $this->input->post('graphics'),
				'screen' => $this->input->post('screen'),
				'size' => $this->input->post('size'),
				'os' => $this->input->post('os'),
				'additional_info' => $this->input->post('additional_info'),
				'additional_features' => $this->input->post('additional_features'),
                'additional_accessories' => $this->input->post('additional_accessories'),
                'accessory_type' => $access_type,
                'accessory_name' => $access_name,	
				'fail_option' => $this->input->post('fail_option'),
				'fail_reason_notes' => ($this->input->post('fail_reason_notes')) ? $this->input->post('fail_reason_notes') : null,
				'condition' => $this->input->post('final_condition'),
				'warranty' => $this->input->post('warranty'),
				'tech_notes' => $this->input->post('tech_notes'),
				'cosmetic_issues_text' => $cosmetic_issues_text,
				'cosmetic_issue' => $cosmetic_issue,
				'fail_text' => $fail_text,
				'cosmetic_grade' => $this->input->post('cosmetic_grade'),
				'status' => $this->input->post('status'),
				'location_id' => $location['id'],
				'other_status' => $this->input->post('other_status') ? $this->input->post('other_status') : null
			];
			if($product_serial_data['location_id'] != $serial_data['location_id']){
				$timestamp['location_assigned_date'] = date('Y-m-d H:i:s');
			}
            if($product_serial_data['status'] != $serial_data['status']){
				$timestamp['status_change_date'] = date('Y-m-d H:i:s');
			}
			// $serial_data['ssd'] = ($this->input->post('ssd')) ? 1 : 0;
			$serial_data['ssd'] = json_encode($ssd_array);
			// $serial_data['dedicated'] = ($this->input->post('dedicated')) ? 1 : 0;
			$serial_data['dedicated'] = json_encode($dedicated_array);
			$serial_data['stylus'] = ($this->input->post('cd_software')) ? 1 : 0;
			$serial_data['power_cord'] = ($this->input->post('power_cord')) ? 1 : 0;
			$serial_data['power_keyboard'] = ($this->input->post('power_keyboard')) ? 1 : 0;
			$serial_data['travel_keyboard'] = ($this->input->post('travel_keyboard')) ? 1 : 0;
			$serial_data['fail'] = ($this->input->post('fail')) ? 1 : 0;
			$serial_data['pass'] = ($this->input->post('pass')) ? 1 : 0;
			$serial_data['factory_reset'] = ($this->input->post('factory_reset')) ? 1 : 0;
            if($product_serial_data['factory_reset'] != $serial_data['factory_reset']){
				$timestamp['factory_reset_date'] = date('Y-m-d H:i:s');
			}
            $serial_data['hard_drive_wiped'] = ($this->input->post('hard_drive_wiped')) ? 1 : 0;
            if($product_serial_data['hard_drive_wiped'] != $serial_data['hard_drive_wiped']){
				$timestamp['hard_drive_wiped_date'] = date('Y-m-d H:i:s');
			}
			$serial_data['tested_by'] = $this->session->userdata('id');
			$serial_data['tgfg_capable'] = ($this->input->post('tgfg_capable')) ? 1 : 0;
			$filesCount = count($_FILES['product_files']['name']);
			$product_id = $this->input->post('product_id');
			$serial_id = $this->input->post('serial_id');
            $root_path = $this->input->server('DOCUMENT_ROOT');
            $serial_files = [];
             $serial_files = ($this->input->post('files')!='') ? explode(',', $this->input->post('files')) : [];
            $no_of_files = sizeof($serial_files);
            for($i = 0; $i < $filesCount; $i++){
            	$j=$i+1;
            	$fn = explode('.',$_FILES['product_files']['name'][$i]);
            	$fn_extension = end($fn);
            	$cnt = $no_of_files+$j;
                $_FILES['userFile']['name'] = $serial.'_'.$cnt.'.'.$fn_extension;
                $_FILES['userFile']['type'] = $_FILES['product_files']['type'][$i];
                $_FILES['userFile']['tmp_name'] = $_FILES['product_files']['tmp_name'][$i];
                $_FILES['userFile']['error'] = $_FILES['product_files']['error'][$i];
                $_FILES['userFile']['size'] = $_FILES['product_files']['size'][$i];
                $folderPath = '/assets/uploads/'.$product_id.'/'.'serials/'.$serial_id;
                $uploadPath = $root_path . $folderPath;
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }
                $config['upload_path'] = $uploadPath; 
                $config['allowed_types'] = '*';
                
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
               
                if($this->upload->do_upload('userFile')){
                    $fileData = $this->upload->data();
                    $serial_files[] = $fileData['file_name'];
                }
            }
            
            if(!empty($serial_data)){
            	$serial_data['files'] = implode(',',$serial_files);
            }
			if($this->basic->update('product_serials', $serial_data, ['serial'=>$this->input->post('serial')])){
				$this->basic->update('serial_timestamps', $timestamp, ['serial_id'=>$product_serial_data['id']]);
				$this->session->set_flashdata('msg', 'Details Saved');
			}
			$role_name = ($this->session->userdata('role_name') == 'Admin') ? 'testing' : $this->session->userdata('role_name');
			$tester = $this->basic->get_single_data_by_criteria('users',['id' => $this->session->userdata('id')]);
            $cnt = 0;
            $tester_data = [
                'tablet_count' => $tester['tablet_count'] + 1
            ];
            $this->basic->update('users', $tester_data,['id' => $this->session->userdata('id')]);
			redirect($this->admin_prefix.$role_name.'/tablet');
		}
		$data['title'] = 'Tablet Testing';
		$data['ajax_url'] = ($this->uri->segment(1)=='admin') ? 'admin/products/find_product' : 'products/find_product';
		$data['original_condition'] = $this->products->get_key_value_pair('original_condition');
		$data['fail_options'] = $this->products->get_key_value_pair('fail_options');
		$data['cosmetic_issues'] = $this->products->get_key_value_pair('cosmetic_issues');
		$data['cat_url'] = ($this->uri->segment(1)=='admin') ? 'admin/barcode/get_sub_category' : 'barcode/get_sub_category';
		$category_names = $this->products->get_categories();
        $data['categories'] = $category_names;
        $data['admin_prefix'] = $this->admin_prefix;
		$this->template->load($this->layout, 'testing/tablet', $data);
	}
	public function monitor(){
		if($this->input->post()){
            // pr($this->input->post());die;
			$product_data = [
				'name' => $this->input->post('name'),
				'description' => $this->input->post('description'),
			];
			$category = [];
			if($this->input->post('category1')){
				$category[] = $this->input->post('category1');
			}
			if($this->input->post('category2')){
				$category[] = $this->input->post('category2');
			}
			if($this->input->post('category3')){
				$category[]  = $this->input->post('category3');
			}
			
			$product_data['category'] = json_encode($category);
			// pr($product_data,1);
			$this->basic->update('products', $product_data, ['part'=>$this->input->post('part')]);
			$cosmetic_issue = json_encode($this->input->post('cosmetic_issue'));
			$cosmetic_issues_text = json_encode([
				'cs1' => $this->input->post('cs1'),
				'cs2' => $this->input->post('cs2')
			]);

			$fail_text = $this->input->post('fail_text');
			
            $loc_name = $this->input->post('scan_loc');
            $location = $this->basic->check_location_exists($loc_name);
			$product_serial_data = $this->basic->get_single_data_by_criteria('product_serials', ['serial'=>$this->input->post('serial')]);
            $timestamp = [
            	'testing_date'=>date('Y-m-d H:i:s'),
            	'last_scan'=>date('Y-m-d H:i:s')
            ];

            $access_type_array = $this->input->post('access_type');
            $access_type = json_encode($access_type_array);

            $access_name_array = $this->input->post('access_name');
            $access_name = json_encode($access_name_array);
            
			$serial_data = [
				'new_serial' => $this->input->post('new_serial'),
				'recv_notes' => $this->input->post('recv_notes'),
				'screen' => $this->input->post('screen'),
				'size' => $this->input->post('size'),
				'curved' => $this->input->post('curved'),
				'additional_info' => $this->input->post('additional_info'),
				'additional_features' => $this->input->post('additional_features'),
				'additional_accessories' => $this->input->post('additional_accessories'),
                'accessory_type' => $access_type,
                'accessory_name' => $access_name,
				'fail_option' => $this->input->post('fail_option'),
				'fail_reason_notes' => ($this->input->post('fail_reason_notes')) ? $this->input->post('fail_reason_notes') : null,
				'condition' => $this->input->post('final_condition'),
				'warranty' => $this->input->post('warranty'),
				'tech_notes' => $this->input->post('tech_notes'),
				'cosmetic_issues_text' => $cosmetic_issues_text,
				'cosmetic_issue' => $cosmetic_issue,
				'fail_text' => $fail_text,
				'cosmetic_grade' => $this->input->post('cosmetic_grade'),
				'status' => $this->input->post('status'),
				'location_id'=>$location['id'],
                'other_status' => $this->input->post('other_status') ? $this->input->post('other_status') : null
            ];
			if($product_serial_data['location_id'] != $serial_data['location_id']){
				$timestamp['location_assigned_date'] = date('Y-m-d H:i:s');
			}
            if($product_serial_data['status'] != $serial_data['status']){
				$timestamp['status_change_date'] = date('Y-m-d H:i:s');
			}
			// $serial_data['ssd'] = ($this->input->post('ssd')) ? 1 : 0;
			$serial_data['ssd'] = json_encode($ssd_array);
			// $serial_data['dedicated'] = ($this->input->post('dedicated')) ? 1 : 0;
			$serial_data['dedicated'] = json_encode($dedicated_array);
			$serial_data['desktop_other'] = ($this->input->post('desktop_other')) ? 1 : 0;
			$serial_data['stand'] = ($this->input->post('stand')) ? 1 : 0;
			$serial_data['cd_software'] = ($this->input->post('cd_software')) ? 1 : 0;
			$serial_data['power_cord'] = ($this->input->post('power_cord')) ? 1 : 0;
			$serial_data['hdmi_cable'] = ($this->input->post('hdmi_cable')) ? 1 : 0;
			$serial_data['fail'] = ($this->input->post('fail')) ? 1 : 0;
			$serial_data['pass'] = ($this->input->post('pass')) ? 1 : 0;
			$serial_data['factory_reset'] = ($this->input->post('factory_reset')) ? 1 : 0;
			$serial_data['hard_drive_wiped'] = ($this->input->post('hard_drive_wiped')) ? 1 : 0;
			$serial_data['tested_by'] = $this->session->userdata('id');
			$filesCount = count($_FILES['product_files']['name']);
			$product_id = $this->input->post('product_id');
			$serial_id = $this->input->post('serial_id');
            $root_path = $this->input->server('DOCUMENT_ROOT');
            $serial_files = [];
             $serial_files = ($this->input->post('files')!='') ? explode(',', $this->input->post('files')) : [];
            $no_of_files = sizeof($serial_files);
            for($i = 0; $i < $filesCount; $i++){
            	$j=$i+1;
            	$fn = explode('.',$_FILES['product_files']['name'][$i]);
            	$fn_extension = end($fn);
            	$cnt = $no_of_files+$j;
                $_FILES['userFile']['name'] = $serial.'_'.$cnt.'.'.$fn_extension;
                $_FILES['userFile']['type'] = $_FILES['product_files']['type'][$i];
                $_FILES['userFile']['tmp_name'] = $_FILES['product_files']['tmp_name'][$i];
                $_FILES['userFile']['error'] = $_FILES['product_files']['error'][$i];
                $_FILES['userFile']['size'] = $_FILES['product_files']['size'][$i];
                $folderPath = '/assets/uploads/'.$product_id.'/'.'serials/'.$serial_id;
                $uploadPath = $root_path . $folderPath;
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }
                $config['upload_path'] = $uploadPath; 
                $config['allowed_types'] = '*';
                
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
               
                if($this->upload->do_upload('userFile')){
                    $fileData = $this->upload->data();
                    $serial_files[] = $fileData['file_name'];
                }
            }
            
            if(!empty($serial_data)){
            	$serial_data['files'] = implode(',',$serial_files);
            }
			if($this->basic->update('product_serials', $serial_data, ['serial'=>$this->input->post('serial')])){
				$this->basic->update('serial_timestamps', $timestamp, ['serial_id'=>$product_serial_data['id']]);
				$this->session->set_flashdata('msg', 'Details Saved');
			}
			$role_name = ($this->session->userdata('role_name') == 'Admin') ? 'testing' : $this->session->userdata('role_name');
			$tester = $this->basic->get_single_data_by_criteria('users',['id' => $this->session->userdata('id')]);
            $cnt = 0;
            $tester_data = [
                'monitor_count' => $tester['monitor_count'] + 1
            ];
            $this->basic->update('users', $tester_data,['id' => $this->session->userdata('id')]);
			redirect($this->admin_prefix.$role_name.'/monitor');
		
		}
		$data['title'] = 'Monitor Testing';
		$data['ajax_url'] = ($this->uri->segment(1)=='admin') ? 'admin/products/find_product' : 'products/find_product';
		$data['original_condition'] = $this->products->get_key_value_pair('original_condition');
		$data['fail_options'] = $this->products->get_key_value_pair('fail_options');
		$data['cosmetic_issues'] = $this->products->get_key_value_pair('cosmetic_issues');
		$data['cat_url'] = ($this->uri->segment(1)=='admin') ? 'admin/barcode/get_sub_category' : 'barcode/get_sub_category';
		$category_names = $this->products->get_categories();
        $data['categories'] = $category_names;
        $data['admin_prefix'] = $this->admin_prefix;
		$this->template->load($this->layout, 'testing/monitor', $data);
	
	}
	public function accessory(){

		if($this->input->post()){
			$product_data = [
				'name' => $this->input->post('name'),
				'description' => $this->input->post('description'),
			];
			$category = [];
			if($this->input->post('category1')){
				$category[] = $this->input->post('category1');
			}
			if($this->input->post('category2')){
				$category[] = $this->input->post('category2');
			}
			if($this->input->post('category3')){
				$category[]  = $this->input->post('category3');
			}
			
			$product_data['category'] = json_encode($category);
			// pr($product_data,1);
			$this->basic->update('products', $product_data, ['part'=>$this->input->post('part')]);
			$cosmetic_issue = json_encode($this->input->post('cosmetic_issue'));
			$cosmetic_issues_text = json_encode([
				'cs1' => $this->input->post('cs1'),
				'cs2' => $this->input->post('cs2')
			]);
			$fail_text = $this->input->post('fail_text');
			$accessory_fields = [
				'cable' => ($this->input->post('cable')) ? 1 : 0,
				'docking_station' => ($this->input->post('docking_station')) ? 1 : 0,
				'pc_part' => ($this->input->post('pc_part')) ? 1 : 0,
				'pc_part_ui' => $this->input->post('pc_part_ui'),
				'printer_part' => ($this->input->post('printer_part')) ? 1 : 0,
				'printer_part_ui' => $this->input->post('printer_part_ui'),
				'retail' => ($this->input->post('retail')) ? 1 : 0,
				'retail_ui' => $this->input->post('retail_ui'),
				'accessory_other' => ($this->input->post('accessory_other')) ? 1 : 0,
				'accessory_other_ui' => $this->input->post('accessory_other_ui')
			];
			$specifications_ui = [
				'sp_ui1' => $this->input->post('sp_ui1'),
				'sp_ui2' => $this->input->post('sp_ui2'),
				'sp_ui3' => $this->input->post('sp_ui3'),
				'sp_ui4' => $this->input->post('sp_ui4'),
				'sp_ui5' => $this->input->post('sp_ui5'),
				'sp_ui6' => $this->input->post('sp_ui6')
			];
			$loc_name = $this->input->post('scan_loc');
            $location = $this->basic->check_location_exists($loc_name);
			$product_serial_data = $this->basic->get_single_data_by_criteria('product_serials', ['serial'=>$this->input->post('serial')]);
            $timestamp = [
            	'testing_date'=>date('Y-m-d H:i:s'),
            	'last_scan'=>date('Y-m-d H:i:s')
            ];
			$loc_name = $this->input->post('scan_loc');
            $location = $this->basic->check_location_exists($loc_name);
            $access_type_array = $this->input->post('access_type');
            $access_type = json_encode($access_type_array);

            $access_name_array = $this->input->post('access_name');
            $access_name = json_encode($access_name_array);
			$serial_data = [
				'new_serial' => $this->input->post('new_serial'),
				'recv_notes' => $this->input->post('recv_notes'),
				'additional_info' => $this->input->post('additional_info'),
				'additional_features' => $this->input->post('additional_features'),
                'additional_accessories' => $this->input->post('additional_accessories'),
                'accessory_type' => $access_type,
                'accessory_name' => $access_name,	
				'fail_option' => $this->input->post('fail_option'),
				'fail_reason_notes' => ($this->input->post('fail_reason_notes')) ? $this->input->post('fail_reason_notes') : null,
				'condition' => $this->input->post('final_condition'),
				'warranty' => $this->input->post('warranty'),
				'tech_notes' => $this->input->post('tech_notes'),
				'cosmetic_issues_text' => $cosmetic_issues_text,
				'cosmetic_issue' => $cosmetic_issue,
				'fail_text' => $fail_text,
				'cosmetic_grade' => $this->input->post('cosmetic_grade'),
				'status' => $this->input->post('status'),
				'location_id'=>$location['id'],
				'other_status' => $this->input->post('other_status') ? $this->input->post('other_status') : null,
				'accessory_fields'=>json_encode($accessory_fields),
				'specifications_ui'=>json_encode($specifications_ui)
			];
			if($product_serial_data['location_id'] != $serial_data['location_id']){
				$timestamp['location_assigned_date'] = date('Y-m-d H:i:s');
			}
            if($product_serial_data['status'] != $serial_data['status']){
				$timestamp['status_change_date'] = date('Y-m-d H:i:s');
			}
			$serial_data['cd_software'] = ($this->input->post('cd_software')) ? 1 : 0;
			$serial_data['power_cord'] = ($this->input->post('power_cord')) ? 1 : 0;
			$serial_data['manual'] = ($this->input->post('manual')) ? 1 : 0;
			$serial_data['fail'] = ($this->input->post('fail')) ? 1 : 0;
			$serial_data['pass'] = ($this->input->post('pass')) ? 1 : 0;
			$serial_data['factory_reset'] = ($this->input->post('factory_reset')) ? 1 : 0;
            if($product_serial_data['factory_reset'] != $serial_data['factory_reset']){
				$timestamp['factory_reset_date'] = date('Y-m-d H:i:s');
			}
            $serial_data['hard_drive_wiped'] = ($this->input->post('hard_drive_wiped')) ? 1 : 0;
            if($product_serial_data['hard_drive_wiped'] != $serial_data['hard_drive_wiped']){
				$timestamp['hard_drive_wiped_date'] = date('Y-m-d H:i:s');
			}
			$serial_data['tested_by'] = $this->session->userdata('id');
			$filesCount = count($_FILES['product_files']['name']);
			$product_id = $this->input->post('product_id');
			$serial_id = $this->input->post('serial_id');
            $root_path = $this->input->server('DOCUMENT_ROOT');
            $serial_files = [];
             $serial_files = ($this->input->post('files')!='') ? explode(',', $this->input->post('files')) : [];
            $no_of_files = sizeof($serial_files);
            for($i = 0; $i < $filesCount; $i++){
            	$j=$i+1;
            	$fn = explode('.',$_FILES['product_files']['name'][$i]);
            	$fn_extension = end($fn);
            	$cnt = $no_of_files+$j;
                $_FILES['userFile']['name'] = $serial.'_'.$cnt.'.'.$fn_extension;
                $_FILES['userFile']['type'] = $_FILES['product_files']['type'][$i];
                $_FILES['userFile']['tmp_name'] = $_FILES['product_files']['tmp_name'][$i];
                $_FILES['userFile']['error'] = $_FILES['product_files']['error'][$i];
                $_FILES['userFile']['size'] = $_FILES['product_files']['size'][$i];
                $folderPath = '/assets/uploads/'.$product_id.'/'.'serials/'.$serial_id;
                $uploadPath = $root_path . $folderPath;
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }
                $config['upload_path'] = $uploadPath; 
                $config['allowed_types'] = '*';
                
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
               
                if($this->upload->do_upload('userFile')){
                    $fileData = $this->upload->data();
                    $serial_files[] = $fileData['file_name'];
                }
            }    
            if(!empty($serial_data)){
            	$serial_data['files'] = implode(',',$serial_files);
            }
			if($this->basic->update('product_serials', $serial_data, ['serial'=>$this->input->post('serial')])){
				$this->basic->update('serial_timestamps', $timestamp, ['serial_id'=>$product_serial_data['id']]);
				$this->session->set_flashdata('msg', 'Details Saved');
			}
			$role_name = ($this->session->userdata('role_name') == 'Admin') ? 'testing' : $this->session->userdata('role_name');
			$tester = $this->basic->get_single_data_by_criteria('users',['id' => $this->session->userdata('id')]);
            $cnt = 0;
            $tester_data = [
                'accessory_count' => $tester['accessory_count'] + 1
            ];
            $this->basic->update('users', $tester_data,['id' => $this->session->userdata('id')]);
			redirect($this->admin_prefix.$role_name.'/accessory');
		}
		$data['title'] = 'Accessory Testing';
		$data['ajax_url'] = ($this->uri->segment(1)=='admin') ? 'admin/products/find_product' : 'products/find_product';
		$data['original_condition'] = $this->products->get_key_value_pair('original_condition');
		$data['fail_options'] = $this->products->get_key_value_pair('fail_options');
		$data['cosmetic_issues'] = $this->products->get_key_value_pair('cosmetic_issues');
		$data['cat_url'] = ($this->uri->segment(1)=='admin') ? 'admin/barcode/get_sub_category' : 'barcode/get_sub_category';
		$category_names = $this->products->get_categories();
        $data['categories'] = $category_names;
        $data['admin_prefix'] = $this->admin_prefix;
		$this->template->load($this->layout, 'testing/accessory', $data);
	}
	public function printer(){
		if($this->input->post()){
			$ink_level = array_filter($this->input->post('ink_level'));
			$product_data = [
				'name' => $this->input->post('name'),
				'description' => $this->input->post('description'),
			];
			$category = [];
			if($this->input->post('category1')){
				$category[] = $this->input->post('category1');
			}
			if($this->input->post('category2')){
				$category[] = $this->input->post('category2');
			}
			if($this->input->post('category3')){
				$category[]  = $this->input->post('category3');
			}
			
			$product_data['category'] = json_encode($category);
			// pr($product_data,1);
			$this->basic->update('products', $product_data, ['part'=>$this->input->post('part')]);
			$cosmetic_issue = json_encode($this->input->post('cosmetic_issue'));
			$cosmetic_issues_text = json_encode([
				'cs1' => $this->input->post('cs1'),
				'cs2' => $this->input->post('cs2')
			]);
			$fail_text = $this->input->post('fail_text');
			$physical_inspection = [
				'missing_tray' => ($this->input->post('missing_tray')) ? 1 : 0,
				'missing_tray_ui' => $this->input->post('missing_tray_ui'),
				'missing_ink_toner' => ($this->input->post('missing_ink_toner')) ? 1 : 0,
				'missing_ink_toner_ui' => $this->input->post('missing_ink_toner_ui'),
				'broken_glass' => ($this->input->post('broken_glass')) ? 1 : 0,
				'broken_glass_ui' => $this->input->post('broken_glass_ui'),
				'physical_damage' => ($this->input->post('physical_damage')) ? 1 : 0,
				'physical_damage_ui' => $this->input->post('physical_damage_ui'),
				'physical_inspection_ui' => $this->input->post('pi_ui')
			];
			$printer_testing_fields = [
				'no_power' => ($this->input->post('no_power')) ? 1 : 0,
				'no_power_ui' => $this->input->post('no_power_ui'),
				'not_loading' => ($this->input->post('not_loading')) ? 1 : 0,
				'not_loading_ui' => $this->input->post('not_loading_ui'),
				'loud_noise' => ($this->input->post('loud_noise')) ? 1 : 0,
				'loud_noise_ui' => $this->input->post('loud_noise_ui'),
				'paper_jam' => ($this->input->post('paper_jam')) ? 1 : 0,
				'paper_jam_ui' => $this->input->post('paper_jam_ui'),
				'ink_system' => ($this->input->post('ink_system')) ? 1 : 0,
				'ink_system_ui' => $this->input->post('ink_system_ui'),
			];
			$product_serial_data = $this->basic->get_single_data_by_criteria('product_serials', ['serial'=>$this->input->post('serial')]);
            $timestamp = [
            	'testing_date'=>date('Y-m-d H:i:s'),
            	'last_scan'=>date('Y-m-d H:i:s')
            ];

            $loc_name = $this->input->post('scan_loc');
            $location = $this->basic->check_location_exists($loc_name);
            
            $access_type_array = $this->input->post('access_type');
            $access_type = json_encode($access_type_array);

            $access_name_array = $this->input->post('access_name');
            $access_name = json_encode($access_name_array);
			$serial_data = [
				'new_serial' => $this->input->post('new_serial'),
				'recv_notes' => $this->input->post('recv_notes'),
				'additional_info' => $this->input->post('additional_info'),
				'fail_option' => $this->input->post('fail_option'),
				'fail_reason_notes' => ($this->input->post('fail_reason_notes')) ? $this->input->post('fail_reason_notes') : null,
				'condition' => $this->input->post('final_condition'),
                'warranty' => $this->input->post('warranty'),
                'accessory_type' => $access_type,
                'accessory_name' => $access_name,	
				'tech_notes' => $this->input->post('tech_notes'),
				'cosmetic_issues_text' => $cosmetic_issues_text,
				'cosmetic_issue' => $cosmetic_issue,
				'fail_text' => $fail_text,
				'cosmetic_grade' => $this->input->post('cosmetic_grade'),
				'status' => $this->input->post('status'),
				'location_id' => $location['id'],
				'other_status' => $this->input->post('other_status') ? $this->input->post('other_status') : null,
				'physical_inspection_fields'=> json_encode($physical_inspection),
				'printer_testing_fields'=> json_encode($printer_testing_fields),
				'error_code'=>$this->input->post('error_code'),
				'pages_printed'=>$this->input->post('pages_printed'),
				'ink_toner_ui'=>$this->input->post('ink_toner_ui'),
				'ink_condition'=>($this->input->post('ink_condition')) ? $this->input->post('ink_condition') : '',
				'ink_level'=>json_encode($ink_level),
			];
			$serial_data['fail'] = ($this->input->post('fail')) ? 1 : 0;
			$serial_data['pass'] = ($this->input->post('pass')) ? 1 : 0;
			$serial_data['factory_reset'] = ($this->input->post('factory_reset')) ? 1 : 0;
            if($product_serial_data['factory_reset'] != $serial_data['factory_reset']){
				$timestamp['factory_reset_date'] = date('Y-m-d H:i:s');
			}
            $serial_data['hard_drive_wiped'] = ($this->input->post('hard_drive_wiped')) ? 1 : 0;
            if($product_serial_data['hard_drive_wiped'] != $serial_data['hard_drive_wiped']){
				$timestamp['hard_drive_wiped_date'] = date('Y-m-d H:i:s');
			}
			$serial_data['tested_by'] = $this->session->userdata('id');
			$filesCount = count($_FILES['product_files']['name']);
			$product_id = $this->input->post('product_id');
			$serial_id = $this->input->post('serial_id');
            $root_path = $this->input->server('DOCUMENT_ROOT');
            $serial_files = [];
             $serial_files = ($this->input->post('files')!='') ? explode(',', $this->input->post('files')) : [];
            $no_of_files = sizeof($serial_files);
            for($i = 0; $i < $filesCount; $i++){
            	$j=$i+1;
            	$fn = explode('.',$_FILES['product_files']['name'][$i]);
            	$fn_extension = end($fn);
            	$cnt = $no_of_files+$j;
                $_FILES['userFile']['name'] = $serial.'_'.$cnt.'.'.$fn_extension;
                $_FILES['userFile']['type'] = $_FILES['product_files']['type'][$i];
                $_FILES['userFile']['tmp_name'] = $_FILES['product_files']['tmp_name'][$i];
                $_FILES['userFile']['error'] = $_FILES['product_files']['error'][$i];
                $_FILES['userFile']['size'] = $_FILES['product_files']['size'][$i];
                $folderPath = '/assets/uploads/'.$product_id.'/'.'serials/'.$serial_id;
                $uploadPath = $root_path . $folderPath;
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }
                $config['upload_path'] = $uploadPath; 
                $config['allowed_types'] = '*';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
               
                if($this->upload->do_upload('userFile')){
                    $fileData = $this->upload->data();
                    $serial_files[] = $fileData['file_name'];
                }
            }
            if(!empty($serial_data)){
            	$serial_data['files'] = implode(',',$serial_files);
            }
			if($this->basic->update('product_serials', $serial_data, ['serial'=>$this->input->post('serial')])){
				$this->basic->update('serial_timestamps', $timestamp, ['serial_id'=>$product_serial_data['id']]);
				$this->session->set_flashdata('msg', 'Details Saved');
			}
			$role_name = ($this->session->userdata('role_name') == 'Admin') ? 'testing' : $this->session->userdata('role_name');
			$tester = $this->basic->get_single_data_by_criteria('users',['id' => $this->session->userdata('id')]);
            $cnt = 0;
            $tester_data = [
                'printer_count' => $tester['printer_count'] + 1
            ];
            $this->basic->update('users', $tester_data,['id' => $this->session->userdata('id')]);
			redirect($this->admin_prefix.$role_name.'/printer');
		}
		$data['title'] = 'Printer Testing';
		$data['ajax_url'] = ($this->uri->segment(1)=='admin') ? 'admin/products/find_product' : 'products/find_product';
		$data['original_condition'] = $this->products->get_key_value_pair('original_condition');
		$data['fail_options'] = $this->products->get_key_value_pair('fail_options');
		$data['cosmetic_issues'] = $this->products->get_key_value_pair('cosmetic_issues');
		$data['cat_url'] = ($this->uri->segment(1)=='admin') ? 'admin/barcode/get_sub_category' : 'barcode/get_sub_category';
		$category_names = $this->products->get_categories();
        $data['categories'] = $category_names;
        $data['admin_prefix'] = $this->admin_prefix;
		$this->template->load($this->layout, 'testing/printer', $data);
	
	}

	public function other_item(){

		if($this->input->post()){
			$product_data = [
				'name' => $this->input->post('name'),
				'description' => $this->input->post('description'),
			];
			$category = [];
			if($this->input->post('category1')){
				$category[] = $this->input->post('category1');
			}
			if($this->input->post('category2')){
				$category[] = $this->input->post('category2');
			}
			if($this->input->post('category3')){
				$category[]  = $this->input->post('category3');
			}
			
			$product_data['category'] = json_encode($category);
			// pr($product_data,1);
			$this->basic->update('products', $product_data, ['part'=>$this->input->post('part')]);
			$cosmetic_issue = json_encode($this->input->post('cosmetic_issue'));
			$cosmetic_issues_text = json_encode([
				'cs1' => $this->input->post('cs1'),
				'cs2' => $this->input->post('cs2')
			]);
			$fail_text = $this->input->post('fail_text');
			$specifications_ui = [
				'sp_ui1' => $this->input->post('sp_ui1'),
				'sp_ui2' => $this->input->post('sp_ui2'),
				'sp_ui3' => $this->input->post('sp_ui3'),
				'sp_ui4' => $this->input->post('sp_ui4'),
				'sp_ui5' => $this->input->post('sp_ui5'),
				'sp_ui6' => $this->input->post('sp_ui6')
			];
			$other_item_inputs = [
				'ot_ui1' => $this->input->post('ot_ui1'),
				'ot_ui2' => $this->input->post('ot_ui2'),
				'ot_ui3' => $this->input->post('ot_ui3'),
				'ot_ui4' => $this->input->post('ot_ui4'),
				'ot_ui5' => $this->input->post('ot_ui5'),
				'ot_ui6' => $this->input->post('ot_ui6'),
				'ot_ui7' => $this->input->post('ot_ui7'),
				'ot_ui8' => $this->input->post('ot_ui8'),
				'ot_ui9' => $this->input->post('ot_ui9')
			];
			$product_serial_data = $this->basic->get_single_data_by_criteria('product_serials', ['serial'=>$this->input->post('serial')]);
            $timestamp = [
            	'testing_date'=>date('Y-m-d H:i:s'),
            	'last_scan'=>date('Y-m-d H:i:s')
            ];

            $loc_name = $this->input->post('scan_loc');
            $location = $this->basic->check_location_exists($loc_name);
            $access_type_array = $this->input->post('access_type');
            $access_type = json_encode($access_type_array);

            $access_name_array = $this->input->post('access_name');
            $access_name = json_encode($access_name_array);
			$serial_data = [
				'new_serial' => $this->input->post('new_serial'),
				'recv_notes' => $this->input->post('recv_notes'),
				'additional_info' => $this->input->post('additional_info'),
				'additional_accessories' => $this->input->post('additional_accessories'),
				'fail_option' => $this->input->post('fail_option'),
				'fail_reason_notes' => ($this->input->post('fail_reason_notes')) ? $this->input->post('fail_reason_notes') : null,
				'condition' => $this->input->post('final_condition'),
                'warranty' => $this->input->post('warranty'),
                'accessory_type' => $access_type,
                'accessory_name' => $access_name,	
				'tech_notes' => $this->input->post('tech_notes'),
				'cosmetic_issues_text' => $cosmetic_issues_text,
				'cosmetic_issue' => $cosmetic_issue,
				'fail_text' => $fail_text,
				'cosmetic_grade' => $this->input->post('cosmetic_grade'),
				'status' => $this->input->post('status'),
				'location_id'=> $location['id'],
				'other_status' => $this->input->post('other_status') ? $this->input->post('other_status') : null,
				'specifications_ui' => json_encode($specifications_ui),
				'other_item_inputs' => json_encode($other_item_inputs),
			];
			 if($product_serial_data['location_id'] != $serial_data['location_id']){
				$timestamp['location_assigned_date'] = date('Y-m-d H:i:s');
			}
            if($product_serial_data['status'] != $serial_data['status']){
				$timestamp['status_change_date'] = date('Y-m-d H:i:s');
			}
			$serial_data['cd_software'] = ($this->input->post('cd_software')) ? 1 : 0;
			$serial_data['power_cord'] = ($this->input->post('power_cord')) ? 1 : 0;
			$serial_data['manual'] = ($this->input->post('manual')) ? 1 : 0;
			$serial_data['fail'] = ($this->input->post('fail')) ? 1 : 0;
			$serial_data['pass'] = ($this->input->post('pass')) ? 1 : 0;
			$serial_data['factory_reset'] = ($this->input->post('factory_reset')) ? 1 : 0;
            if($product_serial_data['factory_reset'] != $serial_data['factory_reset']){
				$timestamp['factory_reset_date'] = date('Y-m-d H:i:s');
			}
            $serial_data['hard_drive_wiped'] = ($this->input->post('hard_drive_wiped')) ? 1 : 0;
            if($product_serial_data['hard_drive_wiped'] != $serial_data['hard_drive_wiped']){
				$timestamp['hard_drive_wiped_date'] = date('Y-m-d H:i:s');
			}
			$serial_data['tested_by'] = $this->session->userdata('id');
			$filesCount = count($_FILES['product_files']['name']);
			$product_id = $this->input->post('product_id');
			$serial_id = $this->input->post('serial_id');
            $root_path = $this->input->server('DOCUMENT_ROOT');
            $serial_files = [];
             $serial_files = ($this->input->post('files')!='') ? explode(',', $this->input->post('files')) : [];
            $no_of_files = sizeof($serial_files);
            for($i = 0; $i < $filesCount; $i++){
            	$j=$i+1;
            	$fn = explode('.',$_FILES['product_files']['name'][$i]);
            	$fn_extension = end($fn);
            	$cnt = $no_of_files+$j;
                $_FILES['userFile']['name'] = $serial.'_'.$cnt.'.'.$fn_extension;
                $_FILES['userFile']['type'] = $_FILES['product_files']['type'][$i];
                $_FILES['userFile']['tmp_name'] = $_FILES['product_files']['tmp_name'][$i];
                $_FILES['userFile']['error'] = $_FILES['product_files']['error'][$i];
                $_FILES['userFile']['size'] = $_FILES['product_files']['size'][$i];
                $folderPath = '/assets/uploads/'.$product_id.'/'.'serials/'.$serial_id;
                $uploadPath = $root_path . $folderPath;
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }
                $config['upload_path'] = $uploadPath; 
                $config['allowed_types'] = '*';
                
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
               
                if($this->upload->do_upload('userFile')){
                    $fileData = $this->upload->data();
                    $serial_files[] = $fileData['file_name'];
                }
            }
            
            if(!empty($serial_data)){
            	$serial_data['files'] = implode(',',$serial_files);
            }
			if($this->basic->update('product_serials', $serial_data, ['serial'=>$this->input->post('serial')])){
				$this->basic->update('serial_timestamps', $timestamp, ['serial_id'=>$product_serial_data['id']]);
				$this->session->set_flashdata('msg', 'Details Saved');
			}
			$role_name = ($this->session->userdata('role_name') == 'Admin') ? 'testing' : $this->session->userdata('role_name');
			$tester = $this->basic->get_single_data_by_criteria('users',['id' => $this->session->userdata('id')]);
            $cnt = 0;
            $tester_data = [
                'other_count' => $tester['other_count'] + 1
            ];
            $this->basic->update('users', $tester_data,['id' => $this->session->userdata('id')]);
			redirect($this->admin_prefix.$role_name.'/other_item');
		
		}
		$data['title'] = 'Other Item Testing';
		$data['ajax_url'] = ($this->uri->segment(1)=='admin') ? 'admin/products/find_product' : 'products/find_product';
		$data['original_condition'] = $this->products->get_key_value_pair('original_condition');
		$data['fail_options'] = $this->products->get_key_value_pair('fail_options');
		$data['cosmetic_issues'] = $this->products->get_key_value_pair('cosmetic_issues');
		$data['cat_url'] = ($this->uri->segment(1)=='admin') ? 'admin/get_sub_category' : 'barcode/get_sub_category';
		$category_names = $this->products->get_categories();
        $data['categories'] = $category_names;
        $data['admin_prefix'] = $this->admin_prefix;
		$this->template->load($this->layout, 'testing/other_item', $data);
	
	}

    public function audit(){
        $data['title'] = 'Audit';
		// $data['ajax_url'] = ($this->uri->segment(1)=='admin') ? 'admin/products/find_product' : 'products/find_product';
		$data['original_condition'] = $this->products->get_key_value_pair('original_condition');
		$data['fail_options'] = $this->products->get_key_value_pair('fail_options');
		$data['cosmetic_issues'] = $this->products->get_key_value_pair('cosmetic_issues');
		$data['cat_url'] = ($this->uri->segment(1)=='admin') ? 'admin/barcode/get_sub_category' : 'barcode/get_sub_category';
		$category_names = $this->products->get_categories();
        $data['categories'] = $category_names;
        $data['admin_prefix'] = $this->admin_prefix;
		$this->template->load($this->layout, 'testing/audit', $data);
    }
    public function quality(){
        $data['title'] = 'Quality Control';
		// $data['ajax_url'] = ($this->uri->segment(1)=='admin') ? 'admin/products/find_product' : 'products/find_product';
		$data['original_condition'] = $this->products->get_key_value_pair('original_condition');
		$data['fail_options'] = $this->products->get_key_value_pair('fail_options');
		$data['cosmetic_issues'] = $this->products->get_key_value_pair('cosmetic_issues');
		$data['cat_url'] = ($this->uri->segment(1)=='admin') ? 'admin/barcode/get_sub_category' : 'barcode/get_sub_category';
		$category_names = $this->products->get_categories();
        $data['categories'] = $category_names;
        $data['admin_prefix'] = $this->admin_prefix;
		$this->template->load($this->layout, 'testing/quality', $data);
    }
    public function repair(){
        $data['title'] = 'Repair';
		// $data['ajax_url'] = ($this->uri->segment(1)=='admin') ? 'admin/products/find_product' : 'products/find_product';
		$data['original_condition'] = $this->products->get_key_value_pair('original_condition');
		$data['fail_options'] = $this->products->get_key_value_pair('fail_options');
		$data['cosmetic_issues'] = $this->products->get_key_value_pair('cosmetic_issues');
		$data['cat_url'] = ($this->uri->segment(1)=='admin') ? 'admin/barcode/get_sub_category' : 'barcode/get_sub_category';
		$category_names = $this->products->get_categories();
        $data['categories'] = $category_names;
        $data['admin_prefix'] = $this->admin_prefix;
		$this->template->load($this->layout, 'testing/repair', $data);
    }

}
