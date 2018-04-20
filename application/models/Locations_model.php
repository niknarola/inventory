<?php

class Locations_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
   
    public function check_location_exists($location){
        $this->db->where('name', $location);
        $query = $this->db->get('locations');
        return $query->num_rows();
    }
    public function get_location_id($location){
        $this->db->where('name', $location);
        $query = $this->db->get('locations')->row_array();
        if(!empty($query)){
            return $query['id'];
        }else{
            return '';
        }
    }
    public function get_location_name($location){
        $this->db->where('id', $location);
        $query = $this->db->get('locations')->row_array();
        if(!empty($query)){
            return $query['name'];
        }else{
            return '';
        }
    }
    function getRows($params = array()){
         $this->db->select('ps.*, p.id as pid, p.part as part, p.name as product_name, p.description as product_desc, p.release_date as release_date, p.category as category, pl.name as product_line, oc.name as original_condition, p.added_as_temp, ci.id as cosmetic_issue_id, ci.name as cosmetic_issue_name,fo.id as fail_option_id, fo.name as fail_option_name, loc.name as location_name, pallet.pallet_id as palletid');
        $this->db->from('product_serials ps');
        $this->db->join('products p', 'p.id = ps.product_id', 'left');
        $this->db->join('cosmetic_issues ci', 'ci.id = ps.cosmetic_issue', 'left');
        $this->db->join('fail_options fo', 'fo.id = ps.fail_option', 'left');
        $this->db->join('product_line pl', 'pl.id = p.product_line_id', 'left');
        $this->db->join('original_condition oc', 'oc.id = ps.condition', 'left');
        $this->db->join('pallets pallet', 'pallet.id = ps.pallet_id', 'left');
        $this->db->join('locations loc', 'loc.id = pallet.location_id', 'left');
        //filter data by searched keywords
        if(!empty($params['search']['keywords'])){
            if(!empty($params['search']['searchfor'])){
                if($params['search']['searchfor']=='location'){
                    $this->db->like('loc.name',$params['search']['keywords']);
                }else{
                    $this->db->like('p.'.$params['search']['searchfor'],$params['search']['keywords']);
                }
            }else{
                $this->db->like('ps.serial',$params['search']['keywords']);
            }
        }
        //sort data by ascending or desceding order
        $this->db->order_by('ps.id','desc');
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
    public function get_serial_part_by_pallet($pallet){
         $this->db->select('ps.id as sid, ps.serial as serial, p.id as pid, p.part as part');
        $this->db->from('product_serials ps');
        $this->db->join('products p', 'p.id = ps.product_id', 'left');
        //filter data by searched keywords
        
        //sort data by ascending or desceding order
        $this->db->order_by('ps.id','asc');
        $this->db->where('ps.is_delete', 0);
        $this->db->where('ps.pallet_id', $pallet);
        //set start and limit
        
        //get records
        $query = $this->db->get();
        //return fetched data
        return ($query->num_rows() > 0)?$query->result_array():FALSE;
    }
    public function get_item_count($location_id){
        $this->db->where('location_id', $location_id);
        $query = $this->db->get('product_serials');
        return $query->num_rows();
	}
	
	public function get_pallet_by_serial($serial){
		$this->db->select('ps.id as psid,ps.serial as serial,ps.pallet_id as serial_pallet,
						   pal.id as palid, pal.pallet_id as pallet, loc.id as locid, loc.name as location');
		$this->db->join('product_serials ps','ps.pallet_id = pal.id', 'LEFT');
		$this->db->join('locations loc','pal.location_id = loc.id AND loc.is_delete = 0', 'LEFT');
		$this->db->where('ps.is_delete',0);
		$this->db->where('serial',$serial);
		$query = $this->db->get('pallets pal')->row_array();
		return $query;
	}
}
