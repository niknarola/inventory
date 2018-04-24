<?php

class User_model extends CI_Model
{
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    function login($email, $password) {
        $this->db->select('u.*, ur.name as role_name');
        $this->db->where("u.email", $email);
        $this->db->where("u.is_delete", 0);
        $this->db->join('user_roles ur', 'ur.id = u.role_id', 'left');
        $query = $this->db->get("users u");
        if ($query->num_rows() > 0) {
			$data = $query->row_array();
			$pass = $this->encrypt->decode($data['password']);
			if($pass == $password){
				if($data['role_id']==1){
					$data['admin_validated'] = true;
					$return = 1;
				}else{
					$data['user_validated'] = true;
					$return = 2;
				}
	    	    $this->session->set_userdata($data);
	            return $return;
	        }
        }
        return 0;
    }
    public function get_roles(){
    	$this->db->select('id,name');
    	$this->db->where('is_delete', 0);
    	$this->db->where('name!=', 'Admin');
    	$query = $this->db->get('user_roles');
    	$data = $query->result_array();
    	$roles = [];
    	foreach ($data as $value) {
    		$roles[$value['id']] = $value['name'];
    	}
    	return $roles;
    }
    public function get_users(){
    	$this->db->select('u.id, u.name, u.email, u.role_id, ur.name as role_name');
    	$this->db->join('user_roles ur', 'ur.id = u.role_id', 'left');
    	$this->db->where('u.is_delete', 0);
    	$this->db->where('u.name!=', 'Admin');
    	$query = $this->db->get('users u');
    	return $query->result_array();
	}
	
	public function check_if_user_exist($data = array(), $is_total_rows = false, $is_single = false,$where_in = false) {
    
        $this->db->where($data);

        if(!empty($where_in)){ $this->db->where_in('role_id',$where_in); }
       
        if ($is_total_rows == true) {
            $res_data = $this->db->get('users')->num_rows();
        } else {
            if ($is_single == true) {
                $res_data = $this->db->get('users')->row_array();
            } else {
                $res_data = $this->db->get('users')->result_array();
            }
		}
        return $res_data;
	}
	
	public function get_data($data,$is_single = false){
        $this->db->where($data);        
        if($is_single == true){            
            return $this->db->get('users')->row_array();
        }else{
            return $this->db->get('users')->result_array();    
        }
	}
	
	public function update_user_data($id, $data) {
        if (is_array($id)) {
            $this->db->where($id);
        } else {
            $this->db->where(['id' => $id]);
        }
        return $this->db->update('users', $data);
    }
}
