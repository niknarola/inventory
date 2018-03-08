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
}