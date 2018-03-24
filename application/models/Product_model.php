<?php

class Product_model extends CI_Model
{

    var $table = 'products';
    var $column_order = array(null, 'part', 'name', 'description', 'category', 'is_cto'); //set column field database for datatable orderable
    var $column_search = array('part', 'name', 'description', 'category'); //set column field database for datatable searchable 
    var $order = array('id' => 'asc'); // default order 

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query($mod = null)
    {
        // $cat_id = $this->get_category_id($_POST['search']['value']);
        $cat_id = $_POST['columns']['4']['search']['value'];
        $_POST['search']['value'] = $cat_id;
        $this->db->from($this->table);
        $i = 0;
        foreach ($this->column_search as $item) // loop column 
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {
                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    if ($item == 'category')
                    {
                        if ($cat_id != '')
                        {
                            $this->db->like($item, $cat_id);
                        }
                    }
                    else
                    {
                        $this->db->like($item, $_POST['search']['value']);
                    }
                }
                else
                {
                    if ($item == 'category')
                    {
                        if ($cat_id != '')
                        {
                            $this->db->or_like($item, $cat_id);
                        }
                    }
                    else
                    {
                        $this->db->or_like($item, $_POST['search']['value']);
                    }
                }
                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        $this->db->where('status', 1);
        $this->db->where('is_delete', 0);
        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else if (isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
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

    public function get_key_value_pair($table)
    {
        $this->db->select('id,name');
        $this->db->where('is_delete', 0);
        $query = $this->db->get($table);
        $data = $query->result_array();
        $final_data = [];
        foreach ($data as $value)
        {
            $final_data[$value['id']] = $value['name'];
        }
        return $final_data;
    }

    public function get_product_by_id($id)
    {
        $this->db->select('products.*, pl.name as product_line, oc.name as original_condition');
        $this->db->join('product_line pl', 'pl.id = products.product_line_id', 'left');
        $this->db->join('original_condition oc', 'oc.id = products.original_condition_id', 'left');
        $this->db->where('products.id', $id);
        $this->db->where('products.is_delete', 0);
        $this->db->limit(1);
        $data = $this->db->get('products')->row_array();
        return $data;
    }

    public function get_category_name($id)
    {
        $this->db->select('name');
        $this->db->where('id', $id);
        $this->db->limit(1);
        $this->db->where('is_delete', 0);
        $data = $this->db->get('categories')->row_array();
        return $data['name'];
    }

    public function get_category_id($name)
    {
        $this->db->select('id');
        $this->db->like('name', $name);
        $this->db->limit(1);
        $this->db->where('is_delete', 0);
        $data = $this->db->get('categories')->row_array();
        return $data['id'];
    }


    public function get_condition_by_product($product_id){
        $this->db->select('oc.id,oc.name as original_condition, p.id as pid , p.name');
        $this->db->join('original_condition oc','oc.id = p.original_condition_id','left');
        $this->db->where('p.id',$product_id);
        $query = $this->db->get('products p')->row_array();
        return $query;

    }

    public function get_ready_for_sale($part){
        $this->db->select('ps.id as sid, ps.status, ps.serial, p.id as pid,p.part');
        $this->db->join('product_serials ps','p.id = ps.product_id');
        $this->db->group_start()
                ->where('ps.status', 'ready for sale')
                ->group_end();
        $this->db->where('p.is_delete','0');
        $this->db->where('p.part',$part);
        $query = $this->db->get('products p')->num_rows();
        return $query;
    }
    public function get_sold($part){
        $this->db->select('ps.id as sid, ps.status, ps.serial, p.id as pid,p.part');
        $this->db->join('product_serials ps','p.id = ps.product_id');
        $this->db->group_start()
                ->where('ps.status', 'sold')
                ->group_end();
        $this->db->where('p.is_delete','0');
        $this->db->where('p.part',$part);
        $query = $this->db->get('products p')->num_rows();
        return $query;
    }

    public function get_units_in_house($part){
        $this->db->select('ps.id as sid, ps.status, ps.serial, p.id as pid,p.part');
        $this->db->join('product_serials ps','p.id = ps.product_id');
        $this->db->group_start()
                ->where('ps.status', 'ready for sale')
                ->or_where('ps.status', 'received')
                ->or_where('ps.status', 'testing')
                ->group_end();
        $this->db->where('p.is_delete','0');
        $this->db->where('p.part',$part);
        $query = $this->db->get('products p')->num_rows();
        return $query;
    }
    public function get_units_in_production($part){
        $this->db->select('ps.id as sid, ps.status, ps.serial, p.id as pid,p.part');
        $this->db->join('product_serials ps','p.id = ps.product_id');
        $this->db->group_start()
                ->where('ps.status', 'inprogresse')
                ->or_where('ps.status', 'received')
                ->or_where('ps.status', 'testing')
                ->or_where('ps.status', 'packout')
                ->or_where('ps.status', 'FGI HOLD')
                ->or_where('ps.status', 'Awaiting Repair')
                ->or_where('ps.status', 'Shipped')
                ->group_end();
        $this->db->where('p.is_delete','0');
        $this->db->where('p.part',$part);
        $query = $this->db->get('products p')->num_rows();
        return $query;
    }

    public function product_search($data)
    {
        $this->db->select('products.*,ps.id as sid, ps.status as serial_status, ps.serial');
        $i = 0;
        $this->db->group_start();
        foreach ($data as $key => $value) // loop column 
        {
            if ($value) // if datatable send POST for search
            {
                if ($i === 0) // first loop
                { 
                     // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($key, $value);
                    $this->db->where($key, $value);
                }
                else
                {
                    $this->db->or_like($key, $value);
                    $this->db->or_where($key, $value);
                }
            }
            $i++;
        }
        $this->db->group_end();
        // $this->db->where('products.status', 1);
        $this->db->where('products.is_delete', 0);
        $this->db->join('product_serials ps','ps.product_id = products.id');
        // $this->db->group_by('serial_status');
        $query = $this->db->get('products');
        // echo"in model". $this->db->last_query();
        return $query->result_array();
    }

    public function get_product_with_serials_by_part($part)
    {
        $this->db->select('ps.serial, p.id, p.part as part, p.name as product_name, p.description as product_desc, p.release_date as release_date, p.category as category, pl.name as product_line, oc.name as original_condition, p.status, p.added_as_temp');
        $this->db->from('products p');
        $this->db->join('product_serials ps', 'ps.product_id = p.id', 'left');
        $this->db->join('product_line pl', 'pl.id = p.product_line_id', 'left');
        $this->db->join('original_condition oc', 'oc.id = p.original_condition_id', 'left');
        $this->db->where('p.part', $part);
        $this->db->where('p.is_delete', 0);
        $data = $this->db->get()->result_array();
        return $data;
    }

    public function get_product_by_part($part)
    {
        $this->db->where('part', $part);
        $this->db->where('is_delete', 0);
        $this->db->limit(1);
        $data = $this->db->get('products')->row_array();
        return $data;
    }

    public function get_serials_by_product_id($product_id)
    {
        $this->db->select('ps.*, oc.name as original_condition');
        $this->db->where('ps.product_id', $product_id);
        $this->db->where('ps.is_delete', 0);
        $this->db->join('products p','p.id = ps.product_id','left');
        $this->db->join('original_condition oc','oc.id = p.original_condition_id','left');
        $data = $this->db->get('product_serials ps')->result_array();
        return $data;
    }

    public function get_temp_products()
    {
        $this->db->select('p.*, pl.name as product_line, oc.name as original_condition');
        $this->db->from('products p');
        $this->db->join('product_line pl', 'pl.id = p.product_line_id', 'left');
        $this->db->join('original_condition oc', 'oc.id = p.original_condition_id', 'left');
        $this->db->where('p.added_as_temp', 1);
        $this->db->where('p.is_delete', 0);
        $data = $this->db->get()->result_array();
        return $data;
    }

    public function get_product_desc($part)
    {
        $this->db->select('description');
        $this->db->where('part', $part);
        $this->db->where('is_delete', 0);
        $this->db->limit(1);
        $data = $this->db->get('products')->row_array();
        return $data['description'];
    }

    public function get_product($id)
    {
        $this->db->select('p.*, u.name as username, u.email as user_email, u.role_id, ur.name as user_role');
        $this->db->from('products p');
        $this->db->join('users u', 'u.id = p.product_added_by', 'left');
        $this->db->join('user_roles ur', 'ur.id = u.role_id', 'left');
        $this->db->where('p.id', $id);
        $this->db->where('p.is_delete', 0);
        $this->db->limit(1);
        $data = $this->db->get()->row_array();
        return $data;
    }

    public function get_categories()
    {
        $this->db->select('id, name');
        $this->db->where('parent', 0);
        $this->db->where('is_delete', 0);
        $data = $this->db->get('categories')->result_array();
        $categories = [];
        if (!empty($data))
        {
            foreach ($data as $value)
            {
                $categories[$value['id']] = $value['name'];
            }
        }
        return $categories;
    }

    public function get_sub_categories($parent)
    {
        $this->db->select('id, name');
        $this->db->where('is_delete', 0);
        $this->db->where('parent', $parent);
        $data = $this->db->get('categories')->result_array();
        $categories = [];
        if (!empty($data))
        {
            foreach ($data as $value)
            {
                $categories[$value['id']] = $value['name'];
            }
        }
        return $categories;
    }

    public function add_product_images($uploadData)
    {
        $this->db->insert_batch('product_images', $uploadData);
    }

    function get_serial($serial, $product_id)
    {
        $this->db->where('serial', $serial);
        $this->db->where('product_id', $product_id);
        $this->db->where('is_delete', 0);
        $this->db->limit(1);
        return $this->db->get('product_serials')->row_array();
    }

    function get_product_serial_details($conditions)
    {
        $this->db->select('ps.*, p.id as pid, p.part as part, p.name as product_name, p.description as product_desc, p.release_date as release_date, p.category as category, pl.name as product_line,p.original_condition_id, oc.name as original_condition, p.status as product_status, p.added_as_temp, ci.id as cosmetic_issue_id, ci.name as cosmetic_issue_name,fo.id as fail_option_id, fo.name as fail_option_name, loc.name as location_name');
        $this->db->from('products p');
        $this->db->join('product_serials ps', 'ps.product_id = p.id', 'left');
        $this->db->join('cosmetic_issues ci', 'ci.id = ps.cosmetic_issue', 'left');
        $this->db->join('fail_options fo', 'fo.id = ps.fail_option', 'left');
        $this->db->join('product_line pl', 'pl.id = p.product_line_id', 'left');
        $this->db->join('original_condition oc', 'oc.id = ps.condition', 'left');
        $this->db->join('locations loc', 'loc.id = ps.location_id', 'left');
        foreach ($conditions as $key => $value)
        {
            $this->db->where($key, $value);
        }
        $this->db->where('p.is_delete', 0);
        $this->db->limit(1);
        $data = $this->db->get()->row_array();
        // echo $this->db->last_query();
        // pr($data);
        return $data;
    }

    function delete($field, $id, $table)
    {
        $this->db->where($field, $id);
        $data = [
            'is_delete' => 1
        ];
        return $this->db->update($table, $data);
    }

    function product_exists($part)
    {
        $this->db->select('id');
        $this->db->where('part', $part);
        $this->db->where('is_delete', 0);
        $this->db->limit(1);
        $data = $this->db->get('products')->row_array();
        if (!empty($data))
        {
            return $data['id'];
        }
        else
        {
            return 0;
        }
    }

    public function get_product_images_count($id)
    {
        $this->db->where('product_id', $id);
        $data = $this->db->get('product_images');
        return $data->num_rows();
    }

    public function get_catetory_by_id($id)
    {
        $this->db->select('c.id as cid, c.name, c.parent');
        $this->db->where('c.id',$id);
        $this->db->get('categories c');
        $query = $this->db->get('categories c')->row_array();
        // echo $this->db->last_query();
        // pr($query);die;
        return $query;
    }

    function getRows($params = array(), $actArr = array())
    {
        $this->db->select('p.id as pid,p.part,p.name,p.description,p.is_cto,p.category, pl.name as product_line, oc.name as condition');
        $this->db->from('products p');
        $this->db->join('product_line pl', 'pl.id = p.product_line_id', 'left');
        $this->db->join('original_condition oc', 'oc.id = p.original_condition_id', 'left');
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
        $this->db->where('p.status', 1);
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

    public function get_part_numbers()
    {
        $this->db->select('p.part');
        // $this->db->where('p.is_delete',0);
        $query = $this->db->get('products p')->result_array();
        // echo $this->db->last_query();
        // pr($query);die;
        return $query;
    }

    public function get_current_pallet()
    {
        $this->db->select('p.id,p.pallet_id');
        $this->db->where('current_pallet',1);
        $query = $this->db->get('pallets p')->row_array();
        return $query;
    }
    
}
