<?php

class Master_sheet_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    function getRows($params = array()){
        $this->db->select('ps.*, p.id as pid, p.part as part, p.name as product_name, p.description as product_desc, p.release_date as release_date, p.category as category, pl.name as product_line, oc.name as original_condition, p.added_as_temp, ci.id as cosmetic_issue_id, ci.name as cosmetic_issue_name,fo.id as fail_option_id, fo.name as fail_option_name, loc.name as location_name');
        $this->db->from('product_serials ps');
        $this->db->join('products p', 'p.id = ps.product_id', 'left');
        $this->db->join('cosmetic_issues ci', 'ci.id = ps.cosmetic_issue', 'left');
        $this->db->join('fail_options fo', 'fo.id = ps.fail_option', 'left');
        $this->db->join('product_line pl', 'pl.id = p.product_line_id', 'left');
        $this->db->join('original_condition oc', 'oc.id = ps.condition', 'left');
        $this->db->join('locations loc', 'loc.id = ps.location_id', 'left');
        //filter data by searched keywords
        if(!empty($params['search']['keywords'])){
            if(!empty($params['search']['searchfor'])){
                if($params['search']['searchfor']=='location'){
                    $this->db->like('loc.name',$params['search']['keywords']);
                }else if($params['search']['searchfor']=='serial'){
                    $this->db->like('ps.'.$params['search']['searchfor'],$params['search']['keywords']);
                }else{
                    $this->db->like('p.'.$params['search']['searchfor'],$params['search']['keywords']);
                }
            }else{
                $this->db->like('ps.serial',$params['search']['keywords']);
            }
        }
   #nik------------
        if(!empty($params['search']['category1']) && !empty($params['search']['category2'])){
           $this->db->like($params['search']['category1']);
           $this->db->like($params['search']['category2']);
        }
        if(!empty($params['search']['grade']))
        {
            $this->db->like('ps.cosmetic_grade',$params['search']['grade']);
        }
        else if (!empty($params['search']['condition']))
        {
            $this->db->like('ps.condition',$params['search']['condition']);
        }
        else if(!empty($params['search']['grade']) && !empty($params['search']['condition'])){
            $this->db->like('ps.cosmetic_grade',$params['search']['grade']);
            $this->db->like('ps.condition',$params['search']['condition']);
        }
        else if(!empty($params['search']['ready'])){
            $this->db->like('ps.status','Ready for sale');
        }
        else if(!empty($params['search']['recent'])){
            $this->db->order_by('ps.created','desc');
        }
        else if(!empty($params['search']['sold'])){
            $this->db->like('ps.status','Sold');
        }
//        }else{
//            //sort data by ascending or desceding order
//            $this->db->order_by('ps.created','desc');
//        }
        $this->db->where('ps.is_delete', 0);
        //set start and limit
        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit'],$params['start']);
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit']);
        }
        //get records
        $query = $this->db->get();
        //return fetched data
        return ($query->num_rows() > 0)?$query->result_array():FALSE;
    }
}