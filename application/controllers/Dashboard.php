<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('User_model');
		if (!$this->session->userdata('user_validated')) {
            redirect('login');
        }
	}
	public function index(){
		$data['title'] = 'Dashboard';
		$this->template->load('layout', 'dashboard/index', $data);
	}

	public function edit_profile() {
		$session_data = $this->session->userdata();
        $data['user_data'] = $this->User_model->check_if_user_exist(['id' => $session_data['id']], false, true,['2','3','4','5','6','7','8','9','10']);
        $data['title'] = 'Edit Profile';
        $this->form_validation->set_rules('email', 'email', 'trim');
        $this->form_validation->set_rules('name', 'name', 'trim');

        if($this->form_validation->run() == FALSE){
            $this->template->load('layout', 'dashboard/edit_profile', $data);
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
                redirect('dashboard/edit_profile');
            }             
    }

    public function change_password() {
		$session_data = $this->session->userdata();
        $data['user_data'] = $this->User_model->check_if_user_exist(['id' => $session_data['id']], false, true,['2','3','4','5','6','7','8','9','10']);
        if (empty($data['user_data'])) {
            redirect('login');
        }        
        $data['title'] = 'Change Password';
        $sess_pass = $data['user_data']['password'];
        $decode_pass = $this->encrypt->decode($sess_pass);

        $user_id = $session_data['id'];
        $this->form_validation->set_rules('curr_pass', 'Current Password', 'trim|required|in_list[' . $decode_pass . ']', ['in_list' => 'Current Password Incorrect.', 'required' => 'Please fill the field' . ' %s .']);
        $this->form_validation->set_rules('pass', 'Password', 'trim|required|min_length[6]|matches[re_pass]', array('required' => 'Please fill the field' . ' %s .', 'min_length' => 'Please enter password min 6 letter', 'matches' => 'Please enter same password'));
        $this->form_validation->set_rules('re_pass', 'Repeat Password', 'trim|required', array('required' => 'Please fill the field' . ' %s .'));

        if ($this->form_validation->run() == FALSE) {
            $this->template->load('layout', 'dashboard/change_password', $data);
        } else {

            $password = $this->input->post('pass');

            if ($password == $decode_pass) {
                $this->session->set_flashdata('message', ['message'=>'Please do not use existing password.','class'=>'alert alert-danger']);
                redirect('dashboard/change_password');
            }
            $encode_pass = $this->encrypt->encode($password);

            $this->User_model->update_user_data($user_id, ['password' => $encode_pass]);
            $this->session->set_flashdata('msg', 'Password has been set Successfully.');
            redirect('dashboard/change_password');
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
