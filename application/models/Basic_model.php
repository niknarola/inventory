<?php

class Basic_model extends CI_Model
{
    function __construct() {
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
       if($this->db->insert($table, $data))
            return $this->db->insert_id();
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
        if($this->db->affected_rows() >= 1)
            return true;
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
    public function update_batch($table, $data, $keyword){
        $this->db->update_batch($table, $data, $keyword);
        if($this->db->affected_rows() >= 1)
            return true;
        return false;
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
        if($this->db->affected_rows() == 1)
            return true;
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
        if($this->db->affected_rows() > 1)
            return  true;
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
    public function get_all_data_by_criteria($table, $cond, $limit=null)
    {
        $this->db->where($cond);
        if($limit!=null)
            $this->db->limit($limit);
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
    }
    public function get_single_data_as_obj_by_criteria($table, $cond)
    {
        $this->db->where($cond);
        return $this->db->get($table)->row();
    }
}