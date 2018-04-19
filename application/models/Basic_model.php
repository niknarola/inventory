<?php

class Basic_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    /*
     * Insert data into any table
     * @param String $table Table name
     * @param Array $data array of data
     * @return
     *      success : Newly added row id
     *      failure : 0
     */
    public function insert($table, $data)
    {
        if ($this->db->insert($table, $data)) {
            return $this->db->insert_id();
        }

        return 0;
    }
    /*
     * Insert multiple data into table
     * @param String $table table name
     * @param Array $data array data which will be inserted
     * @return
     *      success : true
     *      failure : false
     */
    public function insert_batch($table, $data)
    {
        $this->db->insert_batch($table, $data);
        if ($this->db->affected_rows() >= 1) {
            return true;
        }

        return false;
    }
    /*
     * Update table information
     * @param String $table Table name
     * @param Array $data array of data
     * @param Array $cond array of conditons
     * @return
     *      success : true
     *      failure : false
     */
    public function update($table, $data, $cond)
    {
        $this->db->where($cond);
        return $this->db->update($table, $data);
    }

    /**
     * [update_batch description]
     * @param  [String] $table   [Table Name]
     * @param  [Array] $data    [array of data]
     * @param  [String] $keyword [Key to update the record]
     * @return [boolean]          [success: true, failure: false]
     */
    public function update_batch($table, $data, $keyword)
    {
        $this->db->update_batch($table, $data, $keyword);
        if ($this->db->affected_rows() >= 1) {
            return true;
        }

        return false;
    }

    public function update_multiple($table, $data, $field)
    {
        if ($this->db->update_batch($table, $data, $field)) {
            return 1;
        } else {
            return 0;
        }
    }

    public function unique_part()
    {
        $this->db->select('id,internal_part');
        $this->db->where('is_delete', '0');
        $products = $this->db->get('ink_products')->result_array();
        return $products;
    }
    /*
     * Remove record from table based on condition
     * @param String $table table name
     * @param Array $cond array of condition
     * @return
     *      success : true
     *      failure : false
     */
    public function delete($table, $cond)
    {
        $this->db->where($cond);
        $this->db->delete($table);
        if ($this->db->affected_rows() == 1) {
            return true;
        }

        return false;
    }
    /*
     * Remove data into batch
     * @param String $table Table name
     * @param Array $data Array of condition
     * @return
     *      success : true
     *      failure : false
     */
    public function delete_batch($table, $cond)
    {
        $this->db->where($cond);
        $this->db->delete($table);
        if ($this->db->affected_rows() > 1) {
            return true;
        }

        return false;
    }

    /*
     * Get all data of given table
     * @param String $table Table name
     * @return
     *      success : Array of data
     */
    public function get_all_data($table)
    {
        return $this->db->get($table)->result_array();
    }
    /*
     * Get all data of given table by different criteria
     * @param String $table Table name
     * @param Array $cond Different criteria
     * @return
     *      success : Array of data
     */
    public function get_all_data_by_criteria($table, $cond, $limit = null)
    {
        $this->db->where($cond);
        if ($limit != null) {
            $this->db->limit($limit);
        }

        return $this->db->get($table)->result_array();
    }
    /*
     * Get table data by id
     * @param String $table table name
     * @param Integer $id
     * @return
     *      success : Object of data
     */
    public function get_data_by_id($table, $id)
    {
        $this->db->where('id', $id);
        $this->db->limit(1);
        return $this->db->get($table)->row_array();
    }
    public function get_single_data_by_criteria($table, $cond)
    {
        $this->db->where($cond);
        return $this->db->get($table)->row_array();
        // echo $this->db->last_query();die;
    }
    public function get_single_data_as_obj_by_criteria($table, $cond)
    {
        $this->db->where($cond);
        return $this->db->get($table)->row();
    }
    public function check_location_exists($loc_name)
    {
        // echo"loc name";pr($loc_name);
        $this->db->select('locations.id');
        $this->db->where('locations.name', $loc_name);
        $this->db->limit(1);
        $query = $this->db->get('locations')->row_array();
		// pr($query);
		
		// exit;
        // echo"query".$this->db->last_query();
        // echo"model name";pr($loc_name);die;
        if (isset($query['id'])) {
			$locid =  $query['id'];
            return $locid;
        } else {

            $loc = array(
                'name' => $loc_name,
            );
            $location_id = $this->db->insert('locations', $loc);
            $insert_id = $this->db->insert_id();
            // echo"location";pr($location_id);
            // echo"insert";pr($insert_id);
            // echo"query";$this->db->last_query();die;
            return $insert_id;
        }
    }

    public function check_pallet_exists($pallet_name)
    {
        // echo"in function<br/>";
        $this->db->select('pallets.id');
        $this->db->where('pallets.pallet_id', $pallet_name);
        $this->db->limit(1);
        $query = $this->db->get('pallets')->row_array();
        // echo"query".$this->db->last_query();
        // echo"model name";pr($pallet_name);echo"<br/>";
        if (isset($query['id'])) {
			$palletId = $query['id'];
            return $palletId;
        } else {
            $pallet = array(
                'pallet_id' => $pallet_name,
            );
            $pallet_id = $this->db->insert('pallets', $pallet);
            // echo"pallet";pr($pallet_id); echo"<br/>";
            $insert_id = $this->db->insert_id();
            // pr($insert_id);die;
            return $insert_id;
        }
	}
	
	public function check_serial_exists($serial_name)
    {
        $this->db->select('ps.id');
        $this->db->where('ps.new_serial', $serial_name);
        $this->db->limit(1);
		$query = $this->db->get('product_serials ps')->row_array();
        // echo"query".$this->db->last_query();
		return $query;
	}
	

    public function get_all_data_by_criteria1($table, $cond, $limit = null)
    {
        // pr($cond);die;
        $this->db->where_in($cond);
        if ($limit != null) {
            $this->db->limit($limit);
        }

        return $this->db->get($table)->result_array();
    }

    public function get_user_by_role_id()
    {
        $this->db->select('u.id as uid,u.name as user_name,u.email,u.role_id,r.id as rid, r.name as role_name');
        $this->db->where('role_id', '1');
        $this->db->or_where('role_id', '3');
        $this->db->where('u.is_delete', '0');
        $this->db->join('user_roles r', 'r.id = u.role_id');
        $query = $this->db->get('users u')->result_array();
        return $query;
    }
    public function get_result($table, $condition = null, $fields = null, $single = null, $total = null, $order_by = null)
    {
        if (!empty($fields)) {
            $this->db->select($fields);
        } else {
            $this->db->select('*');
        }

        if ($order_by != null) {
            $this->db->order_by($order_by);
        }
        if (!is_null($condition)) {
            $this->db->where($condition);
        }
        $query = $this->db->get($table);

        if (!is_null($single)) {
            return $query->row_array();
        } else if (!is_null($total)) {
            return $query->num_rows();
        } else {
            return $query->result_array();
        }
    }

}
