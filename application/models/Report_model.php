<?php

class Report_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function get_hp_reports($params = array())
    {
		$this->db->select('ps.*, p.id as pid, p.part as part, p.name as product_name, 
							p.description as product_desc, p.release_date as release_date, 
							p.category as category,p.is_flagged as is_flagged, pl.name as product_line, 
							oc.name as original_condition, p.added_as_temp, 
							ci.id as cosmetic_issue_id, ci.name as cosmetic_issue_name,
							fo.id as fail_option_id, fo.name as fail_option_name, 
							loc.name as location_name,
							pal.pallet_id as pallet,
							pl_loc.id as plid, pl_loc.name as pallet_location_name, 
							st.last_scan, st.received_date, inspection_date, 
							st.testing_date, st.hard_drive_wiped_date, 
							st.factory_reset_date, st.inventory_date, 
							st.location_assigned_date, st.status_change_date');
        $this->db->from('product_serials ps');
        $this->db->join('products p', 'p.id = ps.product_id', 'left');
        $this->db->join('cosmetic_issues ci', 'ci.id = ps.cosmetic_issue', 'left');
        $this->db->join('fail_options fo', 'fo.id = ps.fail_option', 'left');
        $this->db->join('product_line pl', 'pl.id = p.product_line_id', 'left');
        $this->db->join('original_condition oc', 'oc.id = ps.condition', 'left');
		$this->db->join('locations loc', 'loc.id = ps.location_id', 'left');
		$this->db->join('pallets pal', 'pal.id = ps.pallet_id', 'left');
		$this->db->join('locations pl_loc','pal.location_id = pl_loc.id','left');
        $this->db->join('serial_timestamps st', 'st.serial_id = ps.id', 'left');
        //filter data by searched keywords
        if (!empty($params['search']['keywords']))
        {
            if (!empty($params['search']['searchfor']))
            {
                if ($params['search']['searchfor'] == 'location')
                {
                    $this->db->like('pl_loc.name', $params['search']['keywords']);
                }if($params['search']['searchfor']=='serial'){
                    $this->db->or_like('ps.'.$params['search']['searchfor'],$params['search']['keywords']);
                }else if($params['search']['searchfor']=='new_serial'){
                    $this->db->or_like('ps.'.$params['search']['searchfor'],$params['search']['keywords']);
                }else if($params['search']['searchfor']=='part'){
                    $this->db->or_like('p.'.$params['search']['searchfor'],$params['search']['keywords']);
                }else if($params['search']['searchfor']=='name'){
                    $this->db->or_like('p.'.$params['search']['searchfor'],$params['search']['keywords']);
                }
            }
            else
            {
				$this->db->group_start();
                $this->db->like('ps.serial', $params['search']['keywords']);
                $this->db->or_like('ps.new_serial', $params['search']['keywords']);
                $this->db->or_like('p.part',$params['search']['keywords']);
				$this->db->or_like('p.name',$params['search']['keywords']);
				$this->db->group_end();
            }
        }
        if (!empty($params['search']['category1']) && !empty($params['search']['category2']))
        {
            $this->db->like('category',$params['search']['category1']);
            $this->db->like('category',$params['search']['category2']);
        }
        if (!empty($params['search']['grade']))
        {
            $this->db->like('ps.cosmetic_grade', $params['search']['grade']);
        }
        if (!empty($params['search']['condition']))
        {
            $this->db->like('ps.condition', $params['search']['condition']);
        }
        if (!empty($params['search']['grade']) && !empty($params['search']['condition']))
        {
            $this->db->like('ps.cosmetic_grade', $params['search']['grade']);
            $this->db->like('ps.condition', $params['search']['condition']);
        }
        if (!empty($params['search']['location']))
        {
            $this->db->like('pl_loc.id', $params['search']['location']);
        }
        if (!empty($params['search']['status']))
        {
            $this->db->like('ps.status', $params['search']['status']);
        }
        if (isset($params['search']['testing']) && $params['search']['testing'] == 'pass')
        {
            $this->db->where('ps.pass', '1');
            // $this->db->where('ps.fail', '1');
        }
        else if (isset($params['search']['testing']) && $params['search']['testing'] == 'fail')
        {
            // $this->db->where('ps.pass', '0');
            // $this->db->where('ps.fail', '0');
            $this->db->where('ps.fail', '1');
        }
        $this->db->where('ps.is_delete', 0);

        //set start and limit
        if (array_key_exists("start", $params) && array_key_exists("limit", $params))
        {
            $this->db->limit($params['limit'], $params['start']);
        }
        elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params))
        {
            $this->db->limit($params['limit']);
        }

        //get records
		$query = $this->db->get();
		// echo $this->db->last_query();
        //return fetched data
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }

    public function num_of_records_by_date($table, $where = NULL)
    {
        $this->db->select("count(id) as count,DATE_FORMAT(created,'%Y-%m-%d') as date");
        if ($where != '')
        {
            $this->db->where($where);
        }
        $this->db->group_by("DATE_FORMAT(created,'%Y-%m-%d')");
        $query = $this->db->get($table);
        return $query->result_array();
    }

    function get_tech_reports($params = array(), $catArr = array())
    {
        $this->db->select('u.id as user_id,u.name,u.*, count(ps.id) as count, ps.id,ps.created as date,ps.status,p.category as category,'
                . 'SUM( CASE WHEN ps.status = "ready for sale" THEN 1 ELSE 0 END ) complete, '
                . 'SUM( CASE WHEN (ps.status = "inprogress" or ps.status = "awaiting repair") THEN 1 ELSE 0 END ) inprogress');
        $this->db->from('product_serials ps');
        $this->db->join('users u', 'u.id = ps.tested_by');
        $this->db->join('products p', 'p.id = ps.product_id', 'left');
        if (!empty($catArr['tech_category1']) && !empty($catArr['tech_category2']))
        {
            $this->db->like('category', $catArr['tech_category1']);
            $this->db->like('category', $catArr['tech_category2']);
        }
        $this->db->where('u.id is NOT NULL');
        $this->db->where('u.role_id','3');
        $this->db->or_where('u.role_id','1');
        $this->db->group_by('u.id');

        $this->db->order_by('complete', 'desc');

        if (count($params) > 0)
        {
            $this->db->where($params);
        }
        //get records
		$query = $this->db->get();
        //return fetched data
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }

    function get_tech_reports_results($params = array(), $catArr = array())
    {

        $this->db->select('ps.id as count, ps.created as date,ps.serial,ps.cosmetic_grade,ps.pass,ps.fail,ps.fail_reason_notes,ps.status,ps.modified,ps.other_status,'
                . 'u.id,u.name as tech_name, '
                . 'p.part as part, '
                . 'p.category as category, '
                . 'oc.name as original_condition, '
                . 'loc.name as location_name,'
                . 'st.last_scan, st.received_date, inspection_date, st.testing_date, st.hard_drive_wiped_date, st.factory_reset_date, st.inventory_date');
        $this->db->from('product_serials ps');
        $this->db->join('users u', 'u.id = ps.tested_by', 'left');
        $this->db->join('products p', 'p.id = ps.product_id', 'left');
        $this->db->join('original_condition oc', 'oc.id = ps.condition', 'left');
        $this->db->join('locations loc', 'loc.id = ps.location_id', 'left');
        $this->db->join('serial_timestamps st', 'st.serial_id = ps.id', 'left');
        //$this->db->where('ps.is_delete','0');
        if (!empty($catArr['tech_category1']) && !empty($catArr['tech_category2']))
        {
            $this->db->like('category', $catArr['tech_category1']);
            $this->db->like('category', $catArr['tech_category2']);
        }
        if (count($params) > 0)
        {
            $this->db->where($params);
        }
        //get records
        $query = $this->db->get();
        //return fetched data
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }

}
