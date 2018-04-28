<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
	public function __construct(){
		parent::__construct();
		if (!$this->session->userdata('admin_validated')) {
            redirect('admin/login');
        }
        $this->load->model('User_model');
        $this->load->model('Basic_model');
	}
	public function index(){
		$data['title'] = 'Users';
		$data['users'] = $this->User_model->get_users();
		$this->template->load('admin/admin_layout', 'user/index', $data);
	}
	public function add($id=null){
		$data['title'] = ($id==null) ? 'Add User' : 'Edit User';
		$data['roles'] = $this->User_model->get_roles();
		$data['user'] = '';
		if($id!=null){
			$data['user'] = $this->Basic_model->get_data_by_id('users', $id);
		}
		if($this->input->post()){
			$user_data = [
				'name' => $this->input->post('name'),
				'email' => $this->input->post('email'),
				'role_id' => $this->input->post('role_id'),
			];
			if($id!=null){
				if($this->Basic_model->update('users', $user_data, ['id'=>$id])){
					$this->session->set_flashdata('msg', 'User details updated successfully');
				}
			}else{
				$password = $this->random_password(8);
				$user_data['password'] = $this->encrypt->encode($password);
				if($this->Basic_model->insert('users', $user_data)){
					$configs = mail_config();
						$role = $this->Basic_model->get_single_data_by_criteria('user_roles', ['id'=>$user_data['role_id']]);
	            		$message = '<p>You have been added to Inventory Management! under '.$role['name'].'</p>';
	            		$message .= '<p>Below are your login credentials:</p>';
	            		$message .= '<ul>';
	            		$message .= '<li><a href="'.base_url().'login">Link</a></li>';
	            		$message .= '<li>Email: '.$user_data['email'].'</li>';
	            		$message .= '<li>Password: '.$password.'</li>';
	            		$message .='</ul>';
	            		$message .='<p>Thank you.</p>';
			            $this->load->library('email');

 						$this->email->initialize($configs);
			            $this->email->set_newline("\r\n");
			            $this->email->from('nv.narola@gmail.com');
			            $this->email->to($user_data['email']);
			            $this->email->subject('Inventory Management');
			            $this->email->message($message);
			            if($this->email->send()){
							$this->session->set_flashdata('msg', 'User added successfully and details sent in mail');
			            }else{
			            	show_error($this->email->print_debugger());
			            }
			            
				}
			}
			redirect('admin/user');
		}
		$this->template->load('admin/admin_layout', 'user/add', $data);
	}
	public function random_password( $length = 8 ) {
	    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
	    $password = substr( str_shuffle( $chars ), 0, $length );
	    return $password;
	}

	public function edit_profile() {
		$session_data = $this->session->userdata();
        $data['user_data'] = $this->User_model->check_if_user_exist(['id' => $session_data['id']], false, true,['1']);
        $data['title'] = 'Edit Profile';
        $this->form_validation->set_rules('email', 'email', 'trim');
        $this->form_validation->set_rules('name', 'name', 'trim');

        if($this->form_validation->run() == FALSE){
            $this->template->load('admin/admin_layout', 'user/edit_profile', $data);
        }else{
                $email = $this->input->post('email');
                $name = $this->input->post('name');
                $upd_arr = [
					'name'=>$name,
					'email'=>$email,
            	];                                
                $this->User_model->update_user_data($session_data['id'],$upd_arr);
                $user_data = $this->User_model->get_data(['id'=>$session_data['id']],true);
                $this->session->set_userdata($user_data);
                $this->session->set_flashdata('msg','Profile has been updated successfully.');
                redirect('admin/user/edit_profile');
            }             
    }

    public function change_password() {
		$session_data = $this->session->userdata();
        $data['user_data'] = $this->User_model->check_if_user_exist(['id' => $session_data['id']], false, true,['1']);
        if (empty($data['user_data'])) {
            redirect('admin/login');
        }        
        $data['title'] = 'Change Password';
        $sess_pass = $data['user_data']['password'];
        $decode_pass = $this->encrypt->decode($sess_pass);

        $user_id = $session_data['id'];
        $this->form_validation->set_rules('curr_pass', 'Current Password', 'trim|required|in_list[' . $decode_pass . ']', ['in_list' => 'Current Password Incorrect.', 'required' => 'Please fill the field' . ' %s .']);
        $this->form_validation->set_rules('pass', 'Password', 'trim|required|min_length[6]|matches[re_pass]', array('required' => 'Please fill the field' . ' %s .', 'min_length' => 'Please enter password min 6 letter', 'matches' => 'Please enter same password'));
        $this->form_validation->set_rules('re_pass', 'Repeat Password', 'trim|required', array('required' => 'Please fill the field' . ' %s .'));

        if ($this->form_validation->run() == FALSE) {
            $this->template->load('admin/admin_layout', 'user/change_password', $data);
        } else {

            $password = $this->input->post('pass');

            if ($password == $decode_pass) {
                $this->session->set_flashdata('message', ['message'=>'Please do not use existing password.','class'=>'alert alert-danger']);
                redirect('admin/user/change_password');
            }
            $encode_pass = $this->encrypt->encode($password);

            $this->User_model->update_user_data($user_id, ['password' => $encode_pass]);
            $this->session->set_flashdata('msg', 'Password has been set Successfully.');
            redirect('admin/user/change_password');
        }
    }
    
    public function file_upload(){

    	$config['upload_path'] = './uploads/avatars/';
    	$config['allowed_types'] = 'jpg|png|jpeg';
    	$config['max_size']  = '100000000000';    	
    	$config['encrypt_name'] = true;

    	$this->load->library('upload', $config);
    	
    	if ( ! $this->upload->do_upload('my_img')){    	
            $error_msg = strip_tags($this->upload->display_errors());
    		if($error_msg == 'You did not select a file to upload.'){                
    			return true;
    		}else{
	    		$this->form_validation->set_message('file_upload', $this->upload->display_errors());
    			return false;
    		}    		
    	} else {
    		$data = array('upload_data' => $this->upload->data());
            
            $file_name = random_string('alnum', 16).'.jpg';            
            $old_path = $data['upload_data']['full_path'];
            $new_path = $data['upload_data']['file_path'].$file_name;
            exec(FFMPEG_PATH . ' -i '.$old_path.' -vf scale=500:-1 '.$new_path);
            unlink($data['upload_data']['full_path']);

    		$this->img_var = 'uploads/avatars/'.$file_name;
    		return true;
    	}
    }
}
