<?php
class Role_model extends CI_Model
{
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    function get_permissions_by_role_id($role_id){
    	$this->db->select('r.name as role_name, p.name as permission_name, r.id as role_id, p.id as permission_id, p.type as ptype');
    	$this->db->join('permissions p', 'p.id = rp.permission_id', 'left');
    	$this->db->join('user_roles r', 'r.id = rp.role_id', 'left');
        $this->db->where('rp.role_id', $role_id);
    	$this->db->where('p.is_delete', 0);
    	$data = $this->db->get('roles_permissions rp')->result_array();
    	return $data; 
    }
    function get_other_permissions($existing_permissions){
    	$this->db->select('id, name');
    	$this->db->where_not_in('id', $existing_permissions);
    	return $this->db->get('permissions')->result_array();
    }
    function remove_permissions($id,$role_id){
    	$this->db->where('permission_id', $id);
    	$this->db->where('role_id', $role_id);
    	return $this->db->delete('roles_permissions');
    }
    function assign_permission($permission_id, $role_id){
    	$data = [
    		'role_id'=>$role_id,
    		'permission_id'=>$permission_id,
		];
		return $this->db->insert('roles_permissions', $data);
    }
}