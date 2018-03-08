<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Roles extends CI_Controller {
	public function __construct(){
		parent::__construct();
		if (!$this->session->userdata('admin_validated')) {
            redirect('admin/login');
        }
        $this->load->model('User_model');
        $this->load->model('Basic_model');
        $this->load->model('Role_model');
	}
	public function index(){ 
		$cond = ['name!='=>'Admin'];
		$roles = $this->Basic_model->get_all_data_by_criteria('user_roles', $cond);
		$data['title'] = 'User Roles';
		$data['roles'] = $roles;
		$this->template->load('admin/admin_layout', 'roles/index', $data);
	}
	public function add($id=null){
		$data = [];
		$table = 'user_roles';
		if($this->input->post()){
			$data['name'] = $this->input->post('name');
		}
		if($id!=null){
			$cond = ['id'=>$id];
			$this->session->set_flashdata('msg', 'Role updated successfully');
			$this->Basic_model->update($table, $data, $cond);
		}else{
			$this->session->set_flashdata('msg', 'Role added successfully');
			$this->Basic_model->insert($table, $data);
		}
		redirect('admin/roles');
	}
	public function permissions($role_id){
		$permissions = $this->Role_model->get_permissions_by_role_id($role_id);
		$data['permissions'] = $permissions;
		$data['title'] = 'User Roles';
		$data['role_name'] = reset($permissions)['role_name'];
		$data['role_id'] = reset($permissions)['role_id'];
		$existing_permissions = array_column($permissions, 'permission_id');
		$data['get_other_permissions'] = $this->Role_model->get_other_permissions($existing_permissions);
		$this->template->load('admin/admin_layout', 'permissions/index', $data);
	}
	public function remove_permission($id,$role_id){
		if($this->Role_model->remove_permissions($id,$role_id)){
			$this->session->set_flashdata('msg', 'Permission removed successfully');
			redirect('admin/roles/permissions/'.$role_id);
		}
	}
	function assign_permissions(){
    	$permission_id = $this->input->post('permission_id');
    	$role_id = $this->input->post('role_id');
    	if($this->Role_model->assign_permission($permission_id, $role_id)){
    		redirect('admin/roles/permissions/'.$role_id);
    	}
	}
	public function add_new_permission(){
		if($this->input->post()){
			$name = $this->input->post('name');
			$data = ['name' => $name];
			$permission_id = $this->Basic_model->insert('permissions', $data);
			if($this->input->post('assign_to_role')){
				$data = [
					'role_id' => $this->input->post('role_id'),
					'permission_id' => $permission_id
				];
				$this->Basic_model->insert('roles_permissions', $data);
			}
			$this->session->set_flashdata('msg', 'Permission added successfully');
			redirect('admin/roles/permissions/'.$this->input->post('role_id'));
		}
	}
}