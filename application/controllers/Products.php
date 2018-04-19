<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller
{

    public $layout = '';

    public function __construct()
    {
        parent::__construct();
        $this->load->library('Ajax_pagination');
        $this->perPage = 10;
        $this->load->model('Product_model', 'products');
        $this->load->model('Basic_model', 'basic');
        if ($this->uri->segment(1) == 'admin' && !$this->session->userdata('admin_validated'))
        {
            redirect('admin/login');
        }
        else if ($this->uri->segment(1) == 'products' && !$this->session->userdata('user_validated'))
        {
            redirect('login');
        }
        if ($this->uri->segment(1) == 'admin')
        {
            $this->layout = 'admin/admin_layout';
        }
        else
        {
            $this->layout = 'layout';
        }
    }

    public function index()
    {
        $data = array();
        $data['title'] = 'Products';
        //total rows count
        $totalRec = count($this->products->getRows());
        //$totalRec = $this->products->count_all('products');
        $data['cat_url'] = ($this->uri->segment(1) == 'admin') ? 'admin/barcode/get_sub_category' : 'barcode/get_sub_category';
        $category_names = $this->products->get_categories();
        $data['categories'] = $category_names;

        //pagination configuration
        $data['ajax_url'] = ($this->session->userdata('admin_validated')) ? 'admin/products' : 'products';
        $url = ($this->session->userdata('admin_validated')) ? 'admin/products/ajaxPaginationData' : 'products/ajaxPaginationData';
        $data['url'] = $url;
        $config['target'] = '#productList';
        $config['base_url'] = base_url() . $url;
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $config['uri_segment'] = 3;
        $this->ajax_pagination->initialize($config);

        //get the posts data
        $data['products'] = $this->products->getRows(array('limit' => $this->perPage));
        //load the view
        $this->template->load($this->layout, 'products/index', $data);
    }

    function ajaxPaginationData()
    {
                
        $conditions = array();
        //calc offset number
        $page = $this->input->post('page');
        if (!$page)
        {
            $offset = 0;
        }
        else
        {
            $offset = $page;
        }
        //set conditions for search
        $keywords = $this->input->post('keywords');
        
        $searchfor = $this->input->post('searchfor');
        $category1 = $this->input->post('category1');
        $category2 = $this->input->post('category2');
        // $sortBy = $this->input->post('sortBy');
        if (!empty($keywords))
        {
            $conditions['search']['keywords'] = $keywords;
        }
        if (!empty($searchfor))
        {
            $conditions['search']['searchfor'] = $searchfor;
        }
        if (!empty($category1) && $category1 != 'none')
        {
            $conditions['search']['category1'] = $category1;
        }
        if (!empty($category2) && $category2 != 'none')
        {
            $conditions['search']['category2'] = $category2;
        }
        
        //total rows count
        $totalRec = count($this->products->getRows($conditions));
        //$totalRec = $this->products->count_all('products');
        //pagination configuration
        $config['target']      = '#productList';
        $url = ($this->session->userdata('admin_validated')) ? 'admin/products/ajaxPaginationData' : 'products/ajaxPaginationData';
        $data['url'] = $url;
        $data['ajax_url'] = ($this->session->userdata('admin_validated')) ? 'admin/products' : 'products';
        $config['base_url']    = base_url().$url;
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $config['uri_segment']   = 4;
        $this->ajax_pagination->initialize($config);
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        $cat = array(
            'category1' => '"' . $category1 . '"',
            'category2' => '"' . $category2 . '"'
        );
        //get posts data
        $data['products'] = $this->products->getRows($conditions,$cat);
        //echo $this->db->last_query();
        //pr($data['products'],1);
        //load the view
        $this->load->view('products/ajax-pagination-data', $data, FALSE);
    }

    public function index1()
    {
        $data['title'] = 'Products';
        $data['cat_url'] = ($this->uri->segment(1) == 'admin') ? 'admin/barcode/get_sub_category' : 'barcode/get_sub_category';
        $category_names = $this->products->get_categories();
        $data['categories'] = $category_names;
        $data['ajax_url'] = ($this->uri->segment(1) == 'admin') ? 'admin/products/ajax_list' : 'products/ajax_list';
        $this->template->load($this->layout, 'products/index1', $data);
    }

    public function ajax_list()
    {
        $list = $this->products->get_datatables();
        $data = array();

        $no = $_POST['start'];
        foreach ($list as $products)
        {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $products->part;
            $row[] = $products->name;
            $row[] = $products->description;
            $row[] = ($products->category != null || $products->category != '') ? get_category_name($products->category) : '';
            $row[] = ($products->is_cto == 0) ? 'No' : 'Yes';
            $row[] = '<a title="View Product" href="' . (($this->session->userdata('admin_validated')) ? 'admin/' : '') . 'products/view/' . $products->id . '" class="btn-xs btn-default product_action_btn"><i class="icon-eye"></i></a><a title="Edit Product" href="' . (($this->session->userdata('admin_validated')) ? 'admin/' : '') . 'products/edit/' . $products->id . '" class="btn-xs btn-default product_action_btn"><i class="icon-pencil"></i></a><a title="Delete Product" href="' . (($this->session->userdata('admin_validated')) ? 'admin/' : '') . 'products/delete/' . $products->id . '" class="btn-xs btn-default product_action_btn"><i class="icon-cross2"></i></a>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->products->count_all(),
            "recordsFiltered" => $this->products->count_filtered(),
            "data" => $data,
            "query" => $this->db->last_query()
        );
        //output to json format
        echo json_encode($output);
        exit;
    }

    public function view($id)
    {
        $data['title'] = 'View Product';
        $data['product'] = $this->products->get_product_by_id($id);
        $data['product_images'] = $this->products->get_product_image_by_id($id);
        if (!empty($data['product']))
        {
            $serial_products = $this->products->get_serials_by_product_id($id);
            $category = ($data['product']['category'] != '') ? get_category_name($data['product']['category']) : '';
            $data['product']['category_names'] = $category;
            $data['product']['serial_products'] = (!empty($serial_products)) ? $serial_products : '';
        }
        $this->template->load($this->layout, 'products/view', $data);
    }

    public function find_product()
    {
        $conditions = $this->input->post();
        $product_details = $this->products->get_product_serial_details($conditions);
		// echo $this->db->last_query();
		// pr($product_details,1);
        $view['status'] = 0;
        if (!empty($product_details))
        {
            $view['product'] = $product_details;
            $view['status'] = 1;
        }
        echo json_encode($view);
        exit;
    }

    public function product_serial($id)
    {
        $data['title'] = 'Product Serial';
        $conditions = ['ps.id' => $id];
        $data['product_serial'] = $this->products->get_product_serial_details($conditions);
        // pr($data['product_serial'],1);
        $this->template->load($this->layout, 'products/product_serial_view', $data);
    }

    public function delete($id)
    {
        if ($this->products->delete('id', $id, 'products'))
        {
            $this->products->delete('product_id', $id, 'product_serials');
            $this->session->set_flashdata('msg', 'Product deleted successfully');
            $url = ($this->session->userdata('admin_validated')) ? 'admin/' : '';
            redirect($url . 'products');
        }
    }

    public function serial_delete($product_id, $serial_id)
    {
        if ($this->products->delete('id', $serial_id, 'product_serials'))
        {
            $this->session->set_flashdata('msg', 'Product Serial deleted successfully');
            $url = ($this->session->userdata('admin_validated')) ? 'admin/' : '';
            redirect($url . 'products/view/' . $product_id);
        }
    }

    public function upload_products()
    {
        $data['title'] = 'Upload Products';
        if ($this->input->post())
        {
            $data['upload'] = $this->input->post('upload');
            $this->load->library('excel');
            if (!empty($_FILES['excel']['tmp_name']))
            {
                $objPHPExcel = PHPExcel_IOFactory::load($_FILES['excel']['tmp_name']);
                $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
                foreach ($cell_collection as $cell)
                {
					// echo"collection";	pr($cell_collection); echo"<br/>";
                    $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
                    $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                    $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
                    if ($row == 1)
                    {
                        $header[$row][$column] = trim($data_value);
                    }
                    else
                    {
                        $arr_data[$row][$column] = trim($data_value);
                    }
                }
                //send the data in an array format
                $data['header'] = $header;
                $data['values'] = $arr_data;
                // pr($data);
                $this->format_data($data['header'], $data['values'], $data['upload']);
            }
        }
        $this->template->load($this->layout, 'products/upload_products', $data);
    }

    public function format_data($header, $values, $type)
    {
		$finalres = [];
        $i = 0;
        $key_array = array();
        $data = [];
        if ($type == 'inventory')
        {
			// echo"inventory";pr($values);
            foreach ($values as $val)
            {
				// pr($val);die;
                if (reset($val) != '')
                {
					// echo"val1";pr($val);
					$x = array_combine($header[1], $val);
					// echo"header";pr($header);
					// echo"val2";pr($val);
					// pr($x);die;
                    if (!in_array(reset($val), $key_array))
                    {
                        if (!empty($data))
                        {
                            $i++;
                        }
                        $key_array[] = reset($val);
                        $data[$i] = $x;
                        $data[$i]['serial'][] = [
                            'serial' => $data[$i]['Serial Number'],
                            'condition' => $data[$i]['Condition']
                        ];
                    }
                    else
                    {
                        $data[$i]['serial'][] = [
                            'serial' => $x['Serial Number'],
                            'condition' => $x['Condition']
                        ];
                    }
                }
            }
            if ($this->insert_products($data, $type))
            {
                $this->session->set_flashdata('msg', 'The data has been uploaded successfully');
            }
            else
            {
                $this->session->set_flashdata('msg', 'Something went wrong, Please try again');
            }
        }
        else
        {
            $insert_data = [];
            $insert_data['cpu'] = '';
            $insert_data['memory'] = '';
            $root_path = $this->input->server('DOCUMENT_ROOT');

            foreach ($values as $val)
            {
				// pr($header);
				// pr($val);die;
                if (reset($val) != '')
                {
                    $arr = array_combine(reset($header), $val);

                    $image_data = [];
                    foreach ($arr as $key => $value)
                    {
                        if ($key == 'MPN' || $key == 'Part Number')
                            $insert_data['part'] = $value;

                        if ($key == 'Product Name' || $key == 'Name')
                            $insert_data['name'] = $value;

                        if ($key == 'Description')
                            $insert_data['description'] = $value;
                        if ($key == 'Condition')
                        {
                            $condition = $this->basic->get_single_data_by_criteria('original_condition', array('name' => trim($value)));
                            $insert_data['original_condition_id'] = (!empty($condition)) ? $condition['id'] : null;
                        }
                        if ($key == 'Product line')
                        {
                            $product_line = $this->basic->get_single_data_by_criteria('product_line', array('name' => trim($value)));
                            $insert_data['product_line_id'] = (!empty($product_line)) ? $product_line['id'] : null;
                        }
                        if ($key == 'CPU Brand')
                            $insert_data['cpu'] .= $value . ' ';
                        if ($key == 'CPU Class')
                            $insert_data['cpu'] .= $value . ' ';
                        if ($key == 'CPU Speed')
                            $insert_data['cpu'] .= $value . ' ';
                        if ($key == 'Processor Number')
                            $insert_data['cpu'] .= $value . ' ';
                        if ($key == 'OS')
                            $insert_data['os'] = $value;
                        if ($key == 'Screen Size')
                            $insert_data['size'] = $value;
                        if ($key == 'Resolution')
                            $insert_data['screen'] = $value;
                        if ($key == 'Graphics')
                            $insert_data['graphics'] = $value;
                        if ($key == 'Storage')
                            $insert_data['storage'] = $value;
                        if ($key == 'Storage Type')
                        {
                            $insert_data['ssd'] = ($value == 'SSD') ? 1 : 0;
                        }
                        /* if($key == 'Category'){
                          $category = [];
                          $condition = $this->basic->get_single_data_by_criteria('original_condition', array('name' => trim($value)));
                          } */
                        if ($key == 'RAM Capacity')
                            $insert_data['memory'] .= $value . ' ';
                        if ($key == 'RAM Type')
                            $insert_data['memory'] .= $value;
                        if ($key == 'Product Images')
                            $image_data['image'] = $value;
                    }
                    $id_exists = $this->products->product_exists($insert_data['part']);
                    if ($id_exists != 0)
                    {
                        $insert_data['added_as_temp'] = 1;
                        $insert_data['product_added_by'] = $this->session->userdata('id');
                        $insert_data['status'] = 0;
                    }
                    $id = $this->basic->insert('products', $insert_data);
                    if ($image_data['image'] != '')
                    {
                        $folderPath = '/assets/uploads/' . $id;
                        $filename = time() . '.jpg';
                        $uploadPath = $root_path . $folderPath;
                        if (!file_exists($uploadPath))
                        {
                            mkdir($uploadPath, 0777, true);
                        }
                        $uploadPath = $root_path . $folderPath . '/' . $filename;
                        $ch = curl_init($image_data['image']);
                        $fp = fopen($uploadPath, 'wb');
                        curl_setopt($ch, CURLOPT_FILE, $fp);
                        curl_setopt($ch, CURLOPT_HEADER, 0);
                        curl_exec($ch);
                        curl_close($ch);
                        fclose($fp);
                        $image_data = [
                            'product_id' => $id,
                            'image' => $filename
                        ];
                        $this->basic->insert('product_images', $image_data);
                    }
                }
            }
        }
        // $this->basic_model->insert_batch('products', $finalres);
    }

    public function insert_products($data, $type)
    {
        if ($type == 'inventory')
        {
            foreach ($data as $product)
            {
                $id_exists = $this->products->product_exists($product['Part Number']);
                if ($id_exists == 0)
                {
                    $product_line = $this->basic->get_single_data_by_criteria('product_line', array('name' => $product['Product Line']));
                    $insert_data = [
                        'part' => $product['Part Number'],
                        'description' => $product['Description'],
                        'product_line_id' => $product_line['id']
                    ];
                    $id = $this->basic_model->insert('products', $insert_data);
                }
                else
                {
                    $id = $id_exists;
                }
                foreach ($product['serial'] as $serial)
                {
                    $serial_exists = $this->products->get_serial($serial['serial'], $id);
                    if (empty($serial_exists))
                    {
                        $condition = $this->basic->get_single_data_by_criteria('original_condition', array('name' => $serial['condition']));
                        $serial_data = [
                            'serial' => $serial['serial'],
							'condition' => $condition['id'],
							'comments'=>$serial['comments'],
                            'product_id' => $id
                        ];
                        $this->basic->insert('product_serials', $serial_data);
                    }
                }
            }
        }
    }

}
