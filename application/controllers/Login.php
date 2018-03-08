<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends CI_Controller {
	 function __construct() {
        parent::__construct();
    }
	public function index(){
		$data['title'] = 'Login';
		$this->load->view('login/login', $data);
	}
	public function process() {
        $this->load->model('User_model');
		$email = $this->input->post('email');
        $password = $this->input->post('password');
        $result = $this->User_model->login($email, $password);
        if ($result!=0) {
            if($result==1)
           		redirect('admin/user');
           	else
           		redirect('dashboard');
        } else {
            $this->session->set_flashdata('error_msg', 'Invalid Email Id or Password.');
            redirect('login');
        }
    }
    public function logout(){
    	if($this->uri->segment(1)=='admin'){
    		$this->session->unset_userdata('admin_validated');
    		redirect('admin/login');
    	}else{
    		$this->session->unset_userdata('user_validated');
    		redirect('login');
    	}
    }
    //function created to insert permissions per role
    public function modules(){
        $this->load->model('Basic_model');
        $filepath = dirname(__FILE__).'/modules.txt';
        $myfile = fopen($filepath, "r") or die("Unable to open file!");
        $modules = fread($myfile,filesize($filepath));
        $arr = explode(',', $modules);
        foreach ($arr as $value) {
            $data = [
                'role_id'=>10,
                'module_id'=>$this->get_cat_id($value, 'modules')
            ];
            // $this->Basic_model->insert('roles_modules', $data);
        }
        fclose($myfile);
    }
    public function get_cat_id($name, $tbl){
        $this->load->model('Basic_model');
        $cond = ['name'=>trim($name)];
        $get_cat = $this->Basic_model->get_single_data_by_criteria($tbl, $cond);
        return $get_cat['id'];
    }
}