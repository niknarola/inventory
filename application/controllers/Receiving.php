<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Receiving extends CI_Controller {
	public $layout = '';
	public function __construct(){
		parent::__construct();
        $this->load->library('Ajax_pagination');
        $this->perPage = 8;
		$this->load->model('Product_model','products');
        $this->load->model('Basic_model','basic');
		$this->load->model('Receiving_model','receiving');
		if($this->uri->segment(1)=='admin' && !$this->session->userdata('admin_validated')){
			redirect('admin/login');
		}else if($this->uri->segment(1)=='receiving' && !$this->session->userdata('user_validated')) {
			redirect('login');
        }
        if($this->uri->segment(1)=='admin')
            $this->layout = 'admin/admin_layout';
        else
            $this->layout = 'layout'; 
	}
	public function search(){
		$data['title'] = 'Receiving - Search';
        $data['ajax_url'] = ($this->uri->segment(1)=='admin') ? 'admin/receiving/' : 'receiving/';
		$this->template->load($this->layout, 'receiving/search', $data);
	}
	public function search_results(){
		$page_data['title'] = 'Product Search Results';
		if($this->input->post()){
			if($this->input->post('part')!='')
				$data['part'] = $this->input->post('part');
			
			if($this->input->post('name')!='')
				$data['name'] = $this->input->post('name');

			if($this->input->post('original_condition_id')!='')
				$data['original_condition_id'] = $this->input->post('original_condition_id');
			if($this->input->post('description')!='')
				$data['description'] = $this->input->post('description');		
			$result = $this->products->product_search($data);
			$page_data['result'] = $result;
			$this->template->load($this->layout, 'receiving/search_results', $page_data);
		}
	}
	public function temporary_product_flagged(){
		$data['title'] = 'Temporary Product Flagged';
		// $temp_products = $this->products->get_temp_products();
		// $data['temp_products'] = $temp_products;

        $data['ajax_url'] = ($this->uri->segment(1)=='admin') ? 'admin/receiving/ajax_list' : 'receiving/ajax_list';
		$this->template->load($this->layout, 'receiving/temporary_product_flagged', $data);
    }

    public function ajax_list(){
        $list = $this->receiving->get_datatables();
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

	public function approve($id){
		$data = [
			'status'=>1
		];
		if($this->basic->update('products', $data, ['id'=>$id])){
			$this->session->set_flashdata('msg', 'Product Approved');
		}
		redirect('admin/temporary_product_review');
	}
	public function find_product(){
        $part = $this->input->post('part');
        $product = $this->products->get_product_by_part($part);
        $view['status'] = 0;
        if(!empty($product)){
            $serial_products = $this->products->get_serials_by_product_id($product['id']);
            $product['serial_products'] = $serial_products;
            $category = ($product['category']!='') ? get_category_name($product['category']) : '';
            $product['category_names'] = $category;
            $data['product'] = $product;
            $view['product'] = $product;
            $view['html_data'] = $this->load->view('products/serial_product', $data, true);
            $view['status'] = 1;
        }
        echo json_encode($view); 
        exit;
    }
    public function find_serial(){
        $serial = $this->input->post('serial');
		$product_id = $this->input->post('product_id');
        $serial_product = $this->products->get_serial($serial, $product_id);
        $view['status'] = 0;
        if(!empty($serial_product)){
            $view['serial'] = $serial_product;
            $view['status'] = 1;
        }
        echo json_encode($view); 
        exit;
    }

    public function temporary_product(){
        $data['title'] = 'Add Temporary Product';
        $data['cat_url'] = ($this->uri->segment(1)=='admin') ? 'admin/barcode/get_sub_category' : 'barcode/get_sub_category';
        $data['original_condition'] = $this->products->get_key_value_pair('original_condition');
        $category_names = $this->products->get_categories();
        $data['categories'] = $category_names;
        $data['product_line'] = $this->products->get_key_value_pair('product_line');
        if($this->input->post()){
         // pr($this->input->post(),1);
         $category = [];
            $category[] = $this->input->post('category1');
            if($this->input->post('category2')){
                 $category[] = $this->input->post('category2');
            }
            if($this->input->post('category3')){
                 $category[] = $this->input->post('category3');
            }
            $part = trim($this->input->post('part'));
            $name = $this->input->post('name');
            $is_cto = 0;
            if(strpos($name, 'CTO') !== false){
                $is_cto = 1;
            }
            $data = [
                'part'=>$this->input->post('part'),
                'name'=>$this->input->post('name'),
                'description'=>$this->input->post('description'),
                'original_condition_id'=>$this->input->post('original_condition_id'),
                'product_line_id'=>$this->input->post('product_line_id'),
                'cpu'=>$this->input->post('cpu'),
                'memory'=>$this->input->post('memory'),
                'storage'=>$this->input->post('storage'),
                'graphics'=>$this->input->post('graphics'),
                'screen'=>$this->input->post('screen'),
                'os'=>$this->input->post('os'),
                'size'=>$this->input->post('size'),
                'release_date'=>$this->input->post('release_date'),
                'category'=>json_encode($category),
                'status'=>0,
                'added_as_temp' => 1,
                'product_added_by'=>$this->session->userdata('id'),
                'is_cto' => $is_cto
            ];
            $data['touch_screen'] = ($this->input->post('touchscreen')) ? 1 : 0;
            $data['webcam'] = ($this->input->post('webcam')) ? 1 : 0;
            $data['ssd'] = ($this->input->post('ssd')) ? 1 : 0;
            $data['dedicated'] = ($this->input->post('dedicated')) ? 1 : 0;
            if($this->basic->insert('products', $data)){
                if($this->input->post('serial')!=''){
                $id = $this->db->insert_id();
                $serial_data = [
                    'serial' => $this->input->post('serial'),
                    'product_id' => $id,
                    'cpu'=>$this->input->post('cpu'),
                    'memory'=>$this->input->post('memory'),
                    'storage'=>$this->input->post('storage'),
                    'graphics'=>$this->input->post('graphics'),
                    'screen'=>$this->input->post('screen'),
                    'os'=>$this->input->post('os'),
                    'size'=>$this->input->post('size'),
                ];
            $serial_data['touch_screen'] = ($this->input->post('touchscreen')) ? 1 : 0;
            $serial_data['webcam'] = ($this->input->post('webcam')) ? 1 : 0;
            $serial_data['ssd'] = ($this->input->post('ssd')) ? 1 : 0;
            $serial_data['dedicated'] = ($this->input->post('dedicated')) ? 1 : 0;
                $this->basic->insert('product_serials', $serial_data);
            }
            $filesCount = count($_FILES['product_images']['name']);
            $root_path = $this->input->server('DOCUMENT_ROOT');
            for($i = 0; $i < $filesCount; $i++){
                $j = $i+1;
                $fn = explode('.',$_FILES['product_images']['name'][$i]);
                $fn_extension = end($fn);
                $_FILES['userFile']['name'] = $part.'_'.$j.'.'.$fn_extension;
                $_FILES['userFile']['name'] = $_FILES['product_images']['name'][$i];
                $_FILES['userFile']['tmp_name'] = $_FILES['product_images']['tmp_name'][$i];
                $_FILES['userFile']['error'] = $_FILES['product_images']['error'][$i];
                $_FILES['userFile']['size'] = $_FILES['product_images']['size'][$i];
                $folderPath = '/assets/uploads/'.$id;
                $uploadPath = $root_path . $folderPath;
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }
                $config['upload_path'] = $uploadPath; 
                $config['allowed_types'] = 'gif|jpg|png';
                
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if($this->upload->do_upload('userFile')){
                    $fileData = $this->upload->data();
                    $uploadData[$i]['image'] = $fileData['file_name'];
                    $uploadData[$i]['product_id'] = $id;
                }
            }
            if(!empty($uploadData)){
                $insert = $this->products->add_product_images($uploadData);
                // $statusMsg = $insert?'Files uploaded successfully.':'Some problem occurred, please try again.';
                // $this->session->set_flashdata('statusMsg',$statusMsg);
            }
                $this->session->set_flashdata('msg', 'Product has been saved successfully');
            }else{
                $this->session->set_flashdata('msg', 'Something went wrong');
            }
            redirect('receiving/search');
        }
        $this->template->load($this->layout, 'receiving/temporary_product', $data);
    }
    public function temporary_product_edit($id){
        $data['title'] = 'Edit Temporary Product';
        $data['cat_url'] = ($this->uri->segment(1)=='admin') ? 'admin/barcode/get_sub_category' : 'barcode/get_sub_category';
        $category_names = $this->products->get_categories();
        $data['categories'] = $category_names;
        $data['original_condition'] = $this->products->get_key_value_pair('original_condition');
        $data['product_line'] = $this->products->get_key_value_pair('product_line');
        $data['product'] = $this->products->get_product_by_id($id);
        $image_count = $this->products->get_product_images_count($id);
        // pr($data['product'],1);
        if($this->input->post()){
            $category = [];
            $category[] = $this->input->post('category1');
            if($this->input->post('category2')){
                 $category[] = $this->input->post('category2');
            }
            if($this->input->post('category3')){
                 $category[] = $this->input->post('category3');
            }
            $part = trim($this->input->post('part'));
            $name = $this->input->post('name');
            $is_cto = 0;
            if(strpos($name, 'CTO') !== false){
                $is_cto = 1;
            }
            $data = [
                'part'=>$this->input->post('part'),
                'name'=>$this->input->post('name'),
                'description'=>$this->input->post('description'),
                'category'=>json_encode($category),
                'original_condition_id'=>$this->input->post('original_condition_id'),
                'product_line_id'=>$this->input->post('product_line_id'),
                'release_date'=>$this->input->post('release_date'),
                'cpu'=>$this->input->post('cpu'),
                'memory'=>$this->input->post('memory'),
                'storage'=>$this->input->post('storage'),
                'graphics'=>$this->input->post('graphics'),
                'screen'=>$this->input->post('screen'),
                'os'=>$this->input->post('os'),
                'size'=>$this->input->post('size'),
                'is_cto'=>$is_cto
            ];
            $data['touch_screen'] = ($this->input->post('touchscreen')) ? 1 : 0;
            $data['webcam'] = ($this->input->post('webcam')) ? 1 : 0;
            $data['ssd'] = ($this->input->post('ssd')) ? 1 : 0;
            $data['dedicated'] = ($this->input->post('dedicated')) ? 1 : 0;
            if($this->basic->update('products', $data, ['id'=>$id])){
                $filesCount = count($_FILES['product_images']['name']);
            $root_path = $this->input->server('DOCUMENT_ROOT');

            for($i = 0; $i < $filesCount; $i++){
                $j = $i+1;
                $fn = explode('.',$_FILES['product_images']['name'][$i]);
                $fn_extension = end($fn);
                $_FILES['userFile']['name'] = $part.'_'.$j.'.'.$fn_extension;
                $_FILES['userFile']['name'] = $_FILES['product_images']['name'][$i];
                $_FILES['userFile']['tmp_name'] = $_FILES['product_images']['tmp_name'][$i];
                $_FILES['userFile']['error'] = $_FILES['product_images']['error'][$i];
                $_FILES['userFile']['size'] = $_FILES['product_images']['size'][$i];
                $folderPath = '/assets/uploads/'.$id;
                $uploadPath = $root_path . $folderPath;
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }
                $config['upload_path'] = $uploadPath; 
                $config['allowed_types'] = 'gif|jpg|png';
                
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if($this->upload->do_upload('userFile')){
                    $fileData = $this->upload->data();
                    $uploadData[$i]['image'] = $fileData['file_name'];
                    $uploadData[$i]['product_id'] = $id;
                }
            }
            if(!empty($uploadData)){
                $insert = $this->products->add_product_images($uploadData);
                // $statusMsg = $insert?'Files uploaded successfully.':'Some problem occurred, please try again.';
                // $this->session->set_flashdata('statusMsg',$statusMsg);
            }
                $this->session->set_flashdata('msg', 'Product has been updated successfully');
            }else{
                $this->session->set_flashdata('msg', 'Something went wrong');
            }
            if($this->uri->segment(1)=='admin')
                redirect('admin/temporary_product_review');
            else
                redirect('receiving/search');
        }
        $this->template->load($this->layout, 'receiving/temporary_product_edit', $data);
    }
    public function add_serial($product_id)
    {
        $data = [
            'serial'=>$this->input->post('serial'),
            'product_id'=>$product_id
        ];
        if($this->basic->insert('product_serials', $data)){
            $this->session->set_flashdata('msg', 'Product Serial has been added successfully');
        }else{
            $this->session->set_flashdata('msg', 'Something went wrong');
        }
        redirect('receiving/search');
    }
    public function request_clarification($id)
    {
    	$product = $this->products->get_product($id);
    	$request_data = [
    		'requested_for_clarification'=>1
    	];
    	if($this->basic->update('products', $request_data, ['id'=>$id])){
    		$configs = mail_config();
			$message = '<p>You have been requested to provide clarification for the product you added.</p>';
			$message .= '<p>Below are the details of the product:</p>';
			$message .= '<ul>';
			$message .= '<li>Part: '.$product['part'].'</li>';
			$message .= '<li>Name: '.$product['name'].'</li>';
			$message .= '<li>Description: '.$product['description'].'</li>';
			$message .= '</ul>';
			$message .= '<p>Thank you.</p>';
	        $this->load->library('email');
			$this->email->initialize($configs);
	        $this->email->set_newline("\r\n");
	        $this->email->from('demo.narola@gmail.com');
	        $this->email->to($product['user_email']);
	        // $this->email->to('nav@narola.email');
	        $this->email->subject('Provide clarification');
	        $this->email->message($message);
	        if($this->email->send()){
				$this->session->set_flashdata('msg', 'Request sent successfully');
	        }else{
	        	show_error($this->email->print_debugger());
	        }
			// $this->session->set_flashdata('msg', 'Request sent successfully');
    	}
    	redirect('admin/temporary_products/view/'.$id);
    }
    public function provide_clarification($id)
    {
    	$data = [
    		'clarification_text' =>$this->input->post('clarification_text'),
			'requested_for_clarification'=>2
    	];
    	if($this->basic->update('products', $data, ['id'=>$id])){
    		$this->session->set_flashdata('msg', 'Successfully sumitted');
    	}
    	redirect('receiving/temporary_product_flagged');
    }
    public function add_notes(){
        $data['title'] = 'Add Notes';
        if($this->input->post()){
            $serial_id = $this->input->post('serial_id');
            $serial_data = $this->basic->get_data_by_id('product_serials', $serial_id);
            $data = [
                'recv_notes' => $this->input->post('recv_notes')
            ];
            $pr_data = [];
            if($serial_data['recv_notes']==null || $serial_data['recv_notes']==''){
                $product_data = $this->basic->get_data_by_id('products', $serial_data['product_id']);
                $pr_data['name'] = $product_data['name'].'*';
            }
            if($this->basic->update('product_serials', $data, ['id'=>$serial_id])){
                if(!empty($pr_data)){
                    $this->basic->update('products', $pr_data, ['id'=>$serial_data['product_id']]);
                }
                $this->session->set_flashdata('msg', 'Notes Added');
            }
        redirect('receiving/add_notes');
        }
        $this->template->load($this->layout, 'receiving/add_notes', $data);
    }
    public function product_actions(){
        $check = $this->input->post('check');
        if($this->input->post('check') && sizeof($check) > 0){
            if($this->input->post('delete_all')){
                $update_product_arr = [];
                for ($i=0; $i < sizeof($check); $i++) { 
                    $update_product_arr[] = array(
                        'id' => $check[$i],
                        'is_delete' => 1
                    );
                    $update_serial_arr[] = array(
                        'product_id' => $check[$i],
                        'is_delete' => 1
                    );
                }
                if($this->basic->update_batch('products', $update_product_arr, 'id')){
                    $this->basic->update_batch('product_serials', $update_serial_arr, 'product_serials');
                    $this->session->set_flashdata('msg', 'Products deleted successfully');
                }
            }
            if($this->input->post('approve_all')){
                $update_product_arr = [];
                for ($i=0; $i < sizeof($check); $i++) { 
                    $update_product_arr[] = array(
                        'id' => $check[$i],
                        'status' => 1
                    );
                }
                if($this->basic->update_batch('products', $update_product_arr, 'id')){
                    $this->session->set_flashdata('msg', 'Products approved successfully');
                }
            }
        }else{
            $this->session->set_flashdata('msg', 'No products were selected. Please try again');
        }
        $url = ($this->session->userdata('admin_validated')) ? 'admin/' : '';
        redirect($url.'receiving/temporary_product_flagged');
    }

    public function quick_receive(){
        $data['title'] = 'Quick Receive';
        $data['pallets'] = $this->receiving->get_key_value_pallets();
        $data['ajax_url'] = ($this->uri->segment(1)=='admin') ? 'admin/products/find_product' : 'products/find_product';
        $data['cat_url'] = ($this->uri->segment(1)=='admin') ? 'admin/barcode/get_sub_category' : 'barcode/get_sub_category';
        $data['condition'] = $this->products->get_key_value_pair('original_condition');
        $category_names = $this->products->get_categories();
        $data['categories'] = $category_names;
        $url = ($this->session->userdata('admin_validated')) ? 'admin/' : '';
        if($this->input->post()){
            
            $products = ($this->session->userdata('products')) ? $this->session->userdata('products') : [];
            if ($this->input->post('complete') || $this->input->post('print_labels')) {

                $serials = array_filter($this->input->post('serial'));
                $parts = array_filter($this->input->post('part'));
                //$notes = array_filter($this->input->post('notes'));
                $description = array_filter($this->input->post('description'));
                $category1 = array_filter($this->input->post('category1'));
                $category2 = array_filter($this->input->post('category2'));
                $condition = array_filter($this->input->post('condition'));
                $i=sizeof($products) + 1;
                foreach ($serials as $key => $serial) {
                    $condition_name = $this->basic->get_single_data_by_criteria('original_condition', array('id' => $condition[$key]));
                    $cat = [];
                    $cat[] = $category1[$key];
                    if($category2[$key]!=''){
                        $cat[] = $category2[$key];
                    }
                    $arr = [
                        'id'=>$i,
                        'serial'=>$serial,
                        'part'=>$parts[$key],
                        // 'inspection_notes'=>$notes[$key],
                        'description'=>$description[$key],
                        'category'=>json_encode($cat),
                        'condition'=>$condition[$key],
                        'condition_name'=>$condition_name['name'],
                        'pallet_id' => $this->input->post('pallet_id'),
                    ];
                    $i++;
                    $products[] = $arr;
                }
               
               $this->session->set_userdata( 'products',$products );
                
            }
            if($this->input->post('accept') || $this->input->post('print_labels') ){
                
               foreach ($products as $key => $product) {
                       $id_exists = $this->products->product_exists($product['part']);
                        if($id_exists==0){
                           $insert_data = [
                                'part'=>$product['part'],
                                'description'=>$product['description'],
                                'original_condition_id'=>$product['condition'],
                                'added_as_temp'=>1,
                                'category'=>$product['category'],
                                'status'=>0
                            ];
                            $id = $this->basic->insert('products', $insert_data);
                        }else{
                            $id = $id_exists;
                        }
                        $serial_exists = $this->products->get_serial($product['serial'], $id);
                if(empty($serial_exists)){
                    $serial_data = [
                        'serial' => $product['serial'],
                        //'inspection_notes' => $product['inspection_notes'],
                        'product_id' => $id,
                        'pallet_id'=>$product['pallet_id'],
                        'condition'=>$product['condition']
                    ];
                    $this->basic->insert('product_serials', $serial_data);
                }
            }
            if($this->input->post('print_labels')){
                $barcode_name = $barcode_part = $barcode_serial = $barcode_condition = $barcode_categories = $barcode_product_line =  $barcode_description = $barcode_data =[];
                foreach ($products as $key => $value) {
                    $pro_data = $this->basic->get_single_data_by_criteria('products',['part'=>$value['part']]);
                    $barcode_name[] = $pro_data['name'];
                    $barcode_part[] = $value['part'];
                    $barcode_serial[] = $value['serial'];
                    $barcode_categories[] = get_category_name($value['category']);
                    $barcode_condition[] = $value['condition_name'];
                    $barcode_product_line[] = $pro_data['product_line_id'];
                    $barcode_description[] = $value['description'];
                }
                $barcode_data['name'] = $barcode_name;
                $barcode_data['part'] = $barcode_part;
                $barcode_data['serial'] = $barcode_serial;
                $barcode_data['categories'] = $barcode_categories;
                $barcode_data['condition'] = $barcode_condition;
                $barcode_data['product_line'] = $barcode_product_line;
                $barcode_data['description'] = $barcode_description;
                $this->session->set_userdata( 'quick_receive_barcode',$barcode_data );
                 $this->session->unset_userdata('products');
                redirect($url.'receiving/quick_receive_barcodes');
            }
           $this->session->unset_userdata('products');
            }
            if($this->input->post('remove')){
                $new_products = [];
                $checked = $this->input->post('check');
                $i = 1;
                foreach ($products as $key => $value) {
                    if(!in_array($value['id'], $checked)){
                        $products[$key]['id'] = $i; 
                        $new_products[] = $products[$key];
                        $i++;
                    }
                }
                $this->session->set_userdata( 'products',$new_products );
            }        
            redirect($url.'receiving/quick_receive');
        }
        $this->template->load($this->layout, 'receiving/quick_receive', $data);
    }
    public function quick_receive_barcodes(){
        $data = $this->session->userdata('quick_receive_barcode');
        $data['title'] = 'Quick Receive Barcodes';
        $this->template->load($this->layout, 'receiving/quick_receive_barcode', $data);
    }
    public function dock_receive(){
        $data['title'] = 'Dock Receive';
        $data['ajax_url'] = ($this->uri->segment(1)=='admin') ? 'admin/receiving/' : 'receiving/';
        $data['locations'] = $this->products->get_key_value_pair('locations');
        $totalRec = count($this->receiving->getRows());
        $url = ($this->session->userdata('admin_validated')) ? 'admin/receiving/dockPagination' : 'receiving/dockPagination';
        $data['url'] = $url;
        $config['target']      = '#palletList';
        $config['base_url']    = base_url().$url;
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $config['uri_segment']   = 4;
        $this->ajax_pagination->initialize($config);
        
        //get the posts data
        $data['pallets'] = $this->receiving->getRows(array('limit'=>$this->perPage));
        //$data['pallets'] = $this->receiving->get_pallets();
        $conditions = []; 
        $this->session->set_userdata('pallets_search', false);
        if($this->input->post()){
            $main_location = $this->input->post('main_location');
            // $bol_or_tracking = ($this->input->post('bol')) ? $this->input->post('bol') : $this->input->post('tracking');
            $bol_or_tracking = $this->input->post('bol_or_tracking');
            $ref = $this->input->post('ref');
            if($this->input->post('search')){
                $this->session->unset_userdata('pallets_next');
                $conditions = array(
                    'limit'=>$this->perPage,
                    'bol_or_tracking'=>$bol_or_tracking,
                    'location'=>$main_location,
                    'ref'=>$ref
                );
                $this->session->set_userdata('pallets_search', true);
                $config['total_rows']  = count($this->receiving->getRows($conditions));
                $data['pallets'] = $this->receiving->getRows($conditions);
            }else{
            $pallet_count = (int) $this->input->post('pallet_count');
            $get_todays_cnt = $this->receiving->get_todays_total_pallets();
            $stored_pallet_count = (int) $this->receiving->get_total_pallets_by_bol_or_tracking($bol_or_tracking);
            $pallet_count = $stored_pallet_count + $pallet_count;
            $insert_data = [];
            $item_count = $this->input->post('item_count');
            $weight = $this->input->post('weight');
            $location = $this->input->post('location');
            $k=0; $j = $get_todays_cnt+1;
            for ($i=$stored_pallet_count; $i < $pallet_count ; $i++) {
                $arr = [];
                $arr['bol_or_tracking'] = $bol_or_tracking;
                // $arr['is_bol_or_tracking'] = ($this->input->post('bol')) ? 1 : 2;
                $arr['pallet_id'] = 'DR'.date('mdY').'-'.$j;
                $arr['pallet_part'] = $i+1;
                $arr['total_pallet'] = $pallet_count;
                $arr['item_count'] = $item_count[$k];
                $arr['weight'] = $weight[$k];
                $arr['location_id'] = $location[$k];
                $arr['ref'] = $ref;
                $arr['received_by'] = $this->session->userdata('id');
                $insert_data[] = $arr;
                $k++; $j++;
            }
            $url = ($this->session->userdata('admin_validated')) ? 'admin/' : '';
            // pr($insert_data,1);
            if($this->input->post('print_labels')){
                $this->session->set_userdata(array('pallet_print_data'=>$insert_data));
                    $session_data=[];
                    $session_data['bol_or_tracking'] = $this->input->post('bol_or_tracking');
                    $session_data['main_location'] = $main_location;
                    $session_data['ref'] = $ref;
                    $this->basic->insert_batch('pallets', $insert_data);
                    $this->session->set_userdata(array('pallets_next'=>$session_data));
                redirect($url.'barcode/pallet_labels');
            }
            else if($this->input->post('next') || $this->input->post('complete')){
                if($this->input->post('next')){
                    $session_data=[];
                    $session_data['bol_or_tracking'] = $this->input->post('bol_or_tracking');
                    $session_data['main_location'] = $main_location;
                    $session_data['ref'] = $ref;
                    $this->session->set_userdata(array('pallets_next'=>$session_data));
                }else{
                    $this->session->unset_userdata('pallets_next');
                }
                $this->basic->insert_batch('pallets', $insert_data);
                $update_data = [];
                $update_data = [
                    'total_pallet' => $pallet_count
                ];
                /*for($i=1; $i <= $pallet_count; $i++){
                    $arr = [];
                    $arr['total_pallet'] = $pallet_count;
                    $arr['bol_or_tracking'] = $bol_or_tracking;           
                    $update_data[] = $arr;
                }*/

            $this->basic->update('pallets', $update_data, ['bol_or_tracking'=>$bol_or_tracking]);
           
            // $this->basic->update_batch('pallets', $update_data, 'bol_or_tracking');

                redirect($url.'receiving/dock_receive');
            }
            else if($this->input->post('delete')){
                $this->session->unset_userdata('pallets_next');
                $check = $this->input->post('check');
                if(!empty($check)){
                    if($this->receiving->delete_pallets($check)){
                        $this->session->set_flashdata('msg', 'Pallets are deleted successfully');
                    }else{
                        $this->session->set_flashdata('msg', 'Something went wrong! Please try again');
                    }
                }
                redirect($url.'receiving/dock_receive');
            }
            }
        }
        
        $this->template->load($this->layout, 'receiving/dock_receive', $data);
    }
    function dockPagination(){
        $conditions = array();
        
        //calc offset number
        $page = $this->input->post('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }
        //set conditions for search
        if($this->session->userdata('pallets_search')){
            $main_location = $this->input->post('main_location');
            $bol_or_tracking = ($this->input->post('bol')) ? $this->input->post('bol') : $this->input->post('tracking');
            $conditions = array(
                'bol_or_tracking'=>$bol_or_tracking,
                'location'=>$main_location
            );
        }
        //total rows count
        $totalRec = count($this->receiving->getRows($conditions));
        
        //pagination configuration
        $config['target']  = '#pallettList';
        $url = ($this->session->userdata('admin_validated')) ? 'admin/receiving/dockPagination' : 'receiving/dockPagination';
        $data['url'] = $url;
        $data['ajax_url'] = ($this->session->userdata('admin_validated')) ? 'admin/receiving/dock_receive' : 'receiving/dock_receive';
        $config['base_url']    = base_url().$url;
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $config['uri_segment']   = 4;
        $this->ajax_pagination->initialize($config);
        
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        
        //get posts data
        $data['pallets'] = $this->receiving->getRows($conditions);
        //load the view
        $this->load->view('receiving/dock-pagination', $data, FALSE);
    }
    public function add_inspection_notes(){
        $pallet_id = $this->input->post('pallet_id');
        $note = $this->input->post('inspection_notes');
        if($note!='' && $pallet_id!=''){
            $data = [ 'inspection_notes' => $note];
            if($this->basic->update('pallets', $data, ['id'=>$pallet_id])){
                $this->session->set_flashdata('msg', 'Notes added');
            }else{
                $this->session->set_flashdata('msg', 'Something went wrong! Please try again');
            }
        }
        $url = ($this->session->userdata('admin_validated')) ? 'admin/' : '';
        redirect($url.'receiving/dock_receive');
    }
}