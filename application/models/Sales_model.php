<?php

class Sales_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function getRows($params = array(), $searchBy = 'part') {
        // pr($params);die;
        if ($searchBy == "part" || $searchBy == "name") {
            if (!empty($params['search']['topsellers'])) {
                $this->db->select('p.id as pid,p.part as part, p.name as product_name, p.description as product_desc,p.release_date as release_date, p.category as category,p.added_as_temp,p.is_flagged as is_flagged', FALSE);
                $this->db->select('(select count(*) from product_serials ps where ps.product_id = p.id AND ps.status LIKE "sold" AND ps.is_delete = 0) as soldserialcnt', FALSE);
                $this->db->from('products p');
                $this->db->order_by("soldserialcnt", "DESC");
            } else {
                $this->db->select('p.id as pid,p.part as part, p.name as product_name, p.description as product_desc,p.release_date as release_date, p.category as category,p.added_as_temp,p.is_flagged as is_flagged');
                $this->db->from('products p');
            }
            //filter data by searched keywords
            if (!empty($params['search']['keywords'])) {
                if (!empty($params['search']['searchfor'])) {
                    if ($params['search']['searchfor'] == 'serial') {
                        $this->db->or_like('ps.' . $params['search']['searchfor'], $params['search']['keywords']);
                    } else if ($params['search']['searchfor'] == 'new_serial') {
                        $this->db->or_like('ps.' . $params['search']['searchfor'], $params['search']['keywords']);
                    } else if ($params['search']['searchfor'] == 'part') {
                        $this->db->or_like('p.' . $params['search']['searchfor'], $params['search']['keywords']);
                    } else if ($params['search']['searchfor'] == 'name') {
                        $this->db->or_like('p.' . $params['search']['searchfor'], $params['search']['keywords']);
                    }
                } else {
                    $this->db->group_start();
                    $this->db->like('p.part', $params['search']['keywords']);
                    $this->db->or_like('p.name', $params['search']['keywords']);
                    $this->db->group_end();
                }
            }
            #nik------------
            if (!empty($params['search']['category1']) && !empty($params['search']['category2'])) {
                $this->db->like('category', $params['search']['category1']);
                $this->db->like('category', $params['search']['category2']);
            }
            if (!empty($params['search']['condition'])) {
                $this->db->like('p.original_condition_id', $params['search']['condition']);
            }
            if (!empty($params['search']['ready'])) {
                $this->db->like('ps.status', 'Ready for Sale');
            }
            if (!empty($params['search']['ready']) && !empty($params['search']['keywords'])) {
                $this->db->like('ps.status', 'Ready for Sale');
                $this->db->group_start()
                        ->like('ps.serial', $params['search']['keywords'])
                        ->or_like('ps.new_serial', $params['search']['keywords'])
                        ->or_like('p.name', $params['search']['keywords'])
                        ->or_like('p.part', $params['search']['keywords'])
                        ->group_end();
            }
            if (!empty($params['search']['recent'])) {
                $this->db->order_by('p.created', 'desc');
            }
            if (!empty($params['search']['recent']) && !empty($params['search']['keywords'])) {
                $this->db->order_by('p.created', 'desc');
                $this->db->group_start()
                        ->like('ps.serial', $params['search']['keywords'])
                        ->or_like('ps.new_serial', $params['search']['keywords'])
                        ->or_like('p.name', $params['search']['keywords'])
                        ->or_like('p.part', $params['search']['keywords'])
                        ->group_end();
            }
            if (!empty($params['search']['sold'])) {
                $this->db->like('ps.status', 'Sold');
            }
            if (!empty($params['search']['sold']) && !empty($params['search']['keywords'])) {
                $this->db->like('ps.status', 'Sold');
                $this->db->group_start()
                        ->like('ps.serial', $params['search']['keywords'])
                        ->or_like('ps.new_serial', $params['search']['keywords'])
                        ->or_like('p.name', $params['search']['keywords'])
                        ->or_like('p.part', $params['search']['keywords'])
                        ->group_end();
            }
            $this->db->where('p.is_delete', 0);
            //set start and limit
            if (!empty($params['search']['topsellers'])) {
                $this->db->limit('10');
            } elseif (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
                $this->db->limit($params['limit'], $params['start']);
            } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
                $this->db->limit($params['limit']);
            }
        } else {
            $this->db->select('ps.*, p.id as pid, pal.pallet_id as pallet,
							p.part as part, p.name as product_name, p.description as product_desc, 
							p.release_date as release_date, p.category as category,p.is_flagged as is_flagged,
							pl.name as product_line, oc.name as original_condition, 
							p.added_as_temp,
							ci.id as cosmetic_issue_id, ci.name as cosmetic_issue_name,
							fo.id as fail_option_id, fo.name as fail_option_name, 
							loc.name as location_name,
							pl_loc.id as plid, pl_loc.name as pallet_location_name');
            $this->db->from('product_serials ps');
            $this->db->join('products p', 'p.id = ps.product_id', 'left');
            $this->db->join('cosmetic_issues ci', 'ci.id = ps.cosmetic_issue', 'left');
            $this->db->join('fail_options fo', 'fo.id = ps.fail_option', 'left');
            $this->db->join('product_line pl', 'pl.id = p.product_line_id', 'left');
            $this->db->join('original_condition oc', 'oc.id = ps.condition', 'left');
            $this->db->join('locations loc', 'loc.id = ps.location_id', 'left');
            $this->db->join('pallets pal', 'pal.id = ps.pallet_id', 'left');
            $this->db->join('locations pl_loc', 'pal.location_id = pl_loc.id', 'left');
            //filter data by searched keywords
            if (!empty($params['search']['keywords'])) {
                if (!empty($params['search']['searchfor'])) {
                    if ($params['search']['searchfor'] == 'serial') {
                        $this->db->or_like('ps.' . $params['search']['searchfor'], $params['search']['keywords']);
                    } else if ($params['search']['searchfor'] == 'new_serial') {
                        $this->db->or_like('ps.' . $params['search']['searchfor'], $params['search']['keywords']);
                    } else if ($params['search']['searchfor'] == 'part') {
                        $this->db->or_like('p.' . $params['search']['searchfor'], $params['search']['keywords']);
                    } else if ($params['search']['searchfor'] == 'name') {
                        $this->db->or_like('p.' . $params['search']['searchfor'], $params['search']['keywords']);
                    }
                } else {
                    $this->db->group_start();
                    $this->db->like('ps.serial', $params['search']['keywords']);
                    $this->db->or_like('ps.new_serial', $params['search']['keywords']);
                    $this->db->or_like('p.part', $params['search']['keywords']);
                    $this->db->or_like('p.name', $params['search']['keywords']);
                    $this->db->group_end();
                }
            }
            #nik------------
            if (!empty($params['search']['category1']) && !empty($params['search']['category2'])) {
                $this->db->like('category', $params['search']['category1']);
                $this->db->like('category', $params['search']['category2']);
            }
            if (!empty($params['search']['grade'])) {
                $this->db->like('ps.cosmetic_grade', $params['search']['grade']);
            } else if (!empty($params['search']['condition'])) {
                $this->db->like('ps.condition', $params['search']['condition']);
            } else if (!empty($params['search']['grade']) && !empty($params['search']['condition'])) {
                // echo"in if grade";
                $this->db->like('ps.cosmetic_grade', $params['search']['grade']);
                $this->db->like('ps.condition', $params['search']['condition']);
            }
            if (!empty($params['search']['ready'])) {
                $this->db->like('ps.status', 'Ready for Sale');
            }
            if (!empty($params['search']['ready']) && !empty($params['search']['keywords'])) {
                $this->db->like('ps.status', 'Ready for Sale');
                $this->db->group_start()
                        ->like('ps.serial', $params['search']['keywords'])
                        ->or_like('ps.new_serial', $params['search']['keywords'])
                        ->or_like('p.name', $params['search']['keywords'])
                        ->or_like('p.part', $params['search']['keywords'])
                        ->group_end();
            }
            if (!empty($params['search']['recent'])) {
                $this->db->order_by('ps.created', 'desc');
            }
            if (!empty($params['search']['recent']) && !empty($params['search']['keywords'])) {
                $this->db->order_by('ps.created', 'desc');
                $this->db->group_start()
                        ->like('ps.serial', $params['search']['keywords'])
                        ->or_like('ps.new_serial', $params['search']['keywords'])
                        ->or_like('p.name', $params['search']['keywords'])
                        ->or_like('p.part', $params['search']['keywords'])
                        ->group_end();
            }
            if (!empty($params['search']['sold'])) {
                $this->db->like('ps.status', 'Sold');
            }
            if (!empty($params['search']['sold']) && !empty($params['search']['keywords'])) {
                $this->db->like('ps.status', 'Sold');
                $this->db->group_start()
                        ->like('ps.serial', $params['search']['keywords'])
                        ->or_like('ps.new_serial', $params['search']['keywords'])
                        ->or_like('p.name', $params['search']['keywords'])
                        ->or_like('p.part', $params['search']['keywords'])
                        ->group_end();
            }
            $this->db->where('ps.is_delete', 0);
            $this->db->where('p.is_delete', 0);
            //set start and limit
            if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
                $this->db->limit($params['limit'], $params['start']);
            } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
                $this->db->limit($params['limit']);
            }
        }
        //get records
        $query = $this->db->get();
//        echo $this->db->last_query();
        //return fetched data
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }

    public function get_notes_by_id($id) {
        $this->db->select('ps.cosmetic_issues_text,ps.fail_text,ps.recv_notes,ps.tech_notes,ps.packaging_notes,ps.inspection_notes,ps.repair_notes');
        $this->db->where('ps.id', $id);
        $this->db->where('ps.is_delete', '0');
        $query = $this->db->get('product_serials ps')->row_array();
        return $query;
    }

    public function get_specs_by_id($id) {
        $this->db->select('ps.cpu,ps.storage,ps.ssd,ps.memory,ps.graphics,ps.dedicated,ps.screen,ps.os,ps.resolution,ps.size');
        $this->db->where('ps.id', $id);
        $this->db->where('ps.is_delete', '0');
        $query = $this->db->get('product_serials ps')->row_array();
        return $query;
    }

    //create pallet code
    public function get_data($params = array()) {
        // echo"params";pr($params);die;
        $this->db->select('ps.id as sid, ps.serial, p.id as pid, p.part, p.name, 
            loc.name as location_name, pl.pallet_id as pallet');
        $this->db->join('products p', 'p.id = ps.product_id', 'left');
        $this->db->join('locations loc', 'loc.id = ps.location_id', 'left');
        $this->db->join('pallets pl', 'pl.id = ps.pallet_id', 'left');
        $this->db->where_in('ps.serial', $params);
        $this->db->where('p.is_delete', 0);
        $this->db->where('ps.is_delete', 0);
        $query = $this->db->get('product_serials ps')->result_array();
        // echo"query in model".$this->db->last_query();
        return $query;
    }

}
