<?php
class Receiving_model extends CI_Model
{
    var $table = 'orders';
    var $column_order = array(null, 'site','part','product_name','created'); //set column field database for datatable orderable
    var $column_search = array('part','name','description','category'); //set column field database for datatable searchable 
    var $order = array('id' => 'asc'); // default order 
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    function getProducts($params = array(), $catArr = array())
    {
        $this->db->select('p.*');
        $this->db->from('products p');
        // $this->db->join('product_line pl', 'pl.id = p.product_line_id', 'left');
        // $this->db->join('original_condition oc', 'oc.id = p.original_condition_id', 'left');
        // $this->db->join('product_serials ps', 'p.id = ps.product_id', 'left');
        //filter data by searched keywords
        if (!empty($params['search']['keywords']))
        {
            if (!empty($params['search']['searchfor']))
            {
                // if($params['search']['searchfor']=='location'){
                //     $this->db->like('p.name',$params['search']['keywords']);
                // }else{
                $this->db->like('p.' . $params['search']['searchfor'], $params['search']['keywords']);
                // }
            }
            else
            {
                $this->db->like('p.description', $params['search']['keywords']);
            }
            if (!empty($catArr['category1']) && !empty($catArr['category2']))
            {
                $this->db->like('category', $catArr['category1']);
                $this->db->like('category', $catArr['category2']);
            }
        }
        //sort data by ascending or desceding order
        /* if(!empty($params['search']['sortBy'])){
          $this->db->order_by('p.id',$params['search']['sortBy']);
          }else{
          $this->db->order_by('p.id','desc');
          } */
        //sort data by ascending or desceding order
        $this->db->where('added_as_temp', 1);
        // $this->db->where('p.status', 1);
        $this->db->where('p.is_delete', 0);
        //set start and limit
        if (array_key_exists("start", $params) && array_key_exists("limit", $params))
        {
            $this->db->limit($params['limit'], $params['start']);
        }
        elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params))
        {
            $this->db->limit($params['limit']);
        }
        $query = $this->db->get();
//        echo$this->db->last_query();
        //return fetched data
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }
    private function _get_datatables_query($mod = null)
    {
        $this->db->from($this->table);
        $i = 0;
        foreach ($this->column_search as $item) // loop column 
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {    
                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        $this->db->where('added_as_temp', 1);
        // $this->db->where('status', 0);
        $this->db->where('is_delete', 0);
        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
    public function get_pallets($conditions=null)
    {
        $this->db->select('p.*, loc.name as location_name');
        $this->db->join('locations loc', 'loc.id = p.location_id', 'left');
        /*if($conditions!=null){
            foreach ($conditions as $key => $value) {
                $this->db->where($key, $value);
            }
        }*/
        $this->db->order_by('p.created', 'asc');
        $data = $this->db->get('pallets p')->result_array();

        return $data;
    }
    function get_key_value_pallets(){
        $this->db->select('id, pallet_id');
        $data = $this->db->get('pallets')->result_array();
        $return = [];
        foreach ($data as $value) {
            $return[$value['id']] = $value['pallet_id'];
        }
        return $return;
    }
    function getRows($params = array()){
        $this->db->select('p.*, loc.name as location_name');
        $this->db->join('locations loc', 'loc.id = p.location_id', 'left');
        //filter data by searched keywords
        /*if(!empty($params['search']['keywords'])){
            if(!empty($params['search']['searchfor'])){
                if($params['search']['searchfor']=='location'){
                    $this->db->like('loc.name',$params['search']['keywords']);
                }else{
                    $this->db->like('p.'.$params['search']['searchfor'],$params['search']['keywords']);
                }
            }else{
                $this->db->like('ps.serial',$params['search']['keywords']);
            }
        }*/
        if(!empty($params['bol_or_tracking'])){
            $this->db->where('p.bol_or_tracking', $params['bol_or_tracking']);
        }
        if(!empty($params['location'])){
            $this->db->where('p.location_id', $params['location']);
        }

        //sort data by ascending or desceding order
        $this->db->order_by('p.created', 'desc');
        
        //set start and limit
        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit'],$params['start']);
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit']);
        }
        //get records
        $query = $this->db->get('pallets p');
        //return fetched data
        return ($query->num_rows() > 0)?$query->result_array():FALSE;
    }
    public function get_total_pallets_by_bol_or_tracking($bol_or_tracking)
    {
        $this->db->where('bol_or_tracking', $bol_or_tracking);
        $query = $this->db->get('pallets');
        return $query->num_rows();
    }
    public function get_total_pallets_by_pallet_id($pallet_id)
    {
        $this->db->where('bol_or_tracking', $bol_or_tracking);
        $query = $this->db->get('pallets');
        return $query->num_rows();
    }
    public function delete_pallets($checked_ids){
        $this->db->where_in('id', $checked_ids);
        return $this->db->delete('pallets');
    }
    public function get_todays_total_pallets(){
        $this->db->where('DATE(created)', date('Y-m-d'));
        $query = $this->db->get('pallets');
        return $query->num_rows();
    }

}