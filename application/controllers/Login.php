<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Login extends CI_Controller
{
    public function __construct()
    {
		parent::__construct();
		$this->load->model('User_model');
    }
    public function index()
    {
        $data['title'] = 'Login';
        $this->load->view('login/login', $data);
    }
    public function process()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $result = $this->User_model->login($email, $password);
        if ($result == 0) {
			$this->session->set_flashdata('err_msg', 'Invalid Email Id or Password.');
			redirect('login');
        } else {
            if ($result == 1) {
				$this->session->set_flashdata('msg', 'Login Successful');
                redirect('admin/user');
            } else {
				$this->session->set_flashdata('msg', 'Login Successful');
                redirect('dashboard');
            }
        }
    }
    public function logout()
    {
        if ($this->uri->segment(1) == 'admin') {
			$this->session->unset_userdata('admin_validated');
			$this->session->set_flashdata('msg', 'Logout Successful.');
            redirect('admin/login');
        } else {
			$this->session->unset_userdata('user_validated');
			$this->session->set_flashdata('msg', 'Logout Successful.');
            redirect('login');
        }
    }
    //function created to insert permissions per role
    public function modules()
    {
        $this->load->model('Basic_model');
        $filepath = dirname(__FILE__) . '/modules.txt';
        $myfile = fopen($filepath, "r") or die("Unable to open file!");
        $modules = fread($myfile, filesize($filepath));
        $arr = explode(',', $modules);
        foreach ($arr as $value) {
            $data = [
                'role_id' => 10,
                'module_id' => $this->get_cat_id($value, 'modules'),
            ];
            // $this->Basic_model->insert('roles_modules', $data);
        }
        fclose($myfile);
    }
    public function get_cat_id($name, $tbl)
    {
        $this->load->model('Basic_model');
        $cond = ['name' => trim($name)];
        $get_cat = $this->Basic_model->get_single_data_by_criteria($tbl, $cond);
        return $get_cat['id'];
	}
	
	public function forgotpassword(){ 
		$data['title'] ="Forgot Password";
		$this->load->view('login/forgot_password',$data);        
	}
	
	public function forgot_process(){
		$user_data=$this->User_model->check_if_user_exist(['email' => $this->input->post('email')], false, true,['1','3']);
		if($user_data){
			$random_no = $this->random_string(8);
			$this->db->set('activation_code', $random_no);
			$this->db->where('id',$user_data['id']);
			$this->db->update('users');
			
			$configs = mail_config();
			$message = '<p>Your Forgot Password request has been accepted. Below is the link to reset your password</p>';
			$message .= '<ul>';
			$message .= '<li><a href="'.base_url().'login/set_password/'.$random_no.'"> Click Here </a></li>';
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
				$this->session->set_flashdata('msg', 'Email has been sent to reset password');
			}else{
				show_error($this->email->print_debugger());
			}
			redirect('login');
		}  
	}

	public function random_string( $length = 8 ) {
	    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	    $random_no = substr( str_shuffle( $chars ), 0, $length );
	    return $random_no;
	}


	public function set_password($rand_no){
        $data['title'] = "Reset Password";
        $this->session->unset_userdata('admin');
        
        $res = $this->User_model->get_data(['activation_code'=>$rand_no],true);        

        if(empty($res)){ 
			$this->session->set_flashdata('err_msg', 'Password Reset link is either invalid or expired');
            redirect('admin/login',$data);
         }
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('re_password', 'Re-type Password', 'required|matches[password]');

        if($this->form_validation->run() == FALSE){
            $this->load->view('login/set_password',$data);
        }else{
            $password = $this->input->post('password');
            $encode_password = $this->encrypt->encode($password);
			if($this->User_model->update_user_data($res['id'],['password'=>$encode_password,'activation_code'=>NULL])){
				$this->session->set_flashdata('msg', 'Password has been successfully set.Try email and password to login.');
			}else{
				$this->session->set_flashdata('err_msg', 'Password cannot be set');
			}
			redirect('admin/login');
        }
    }
}

