<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Utility extends CI_Controller
{
    public $layout = '';
    public function __construct()
    {
        parent::__construct();
        $this->load->library('Ajax_pagination');
        $this->perPage = 10;
        $this->load->model('Product_model', 'products');
        $this->load->model('Basic_model', 'basic');
        $this->load->model('Locations_model', 'location');
        $this->load->model('Master_sheet_model', 'master');
        if ($this->uri->segment(1) == 'admin' && !$this->session->userdata('admin_validated')) {
            redirect('admin/login');
        } else if ($this->uri->segment(1) != 'admin' && !$this->session->userdata('user_validated')) {
            redirect('login');
        }
        if ($this->uri->segment(1) == 'admin') {
            $this->layout = 'admin/admin_layout';
        } else {
            $this->layout = 'layout';
        }

    }

    public function index()
    {
        $data = array();
        $data['title'] = 'Utility Module';
        $data['ajax_url'] = $data['ajax_url'] = ($this->uri->segment(1) == 'admin') ? 'admin/inventory/utility/find_product' : 'inventory/utility/find_product';
        $data['ink_products'] = $this->products->get_key_value_ink_products('ink_products');
        if ($this->input->post()) {
            ini_set('max_execution_time', 0);
            if ($this->input->post('upload_sheet')) {
                $data['upload'] = $this->input->post('upload_sheet');
                $this->load->library('excel');
                if (!empty($_FILES['excel']['tmp_name'])) {
                    $objPHPExcel = PHPExcel_IOFactory::load($_FILES['excel']['tmp_name']);
                    $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
                    foreach ($cell_collection as $cell) {
                        $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
                        $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                        $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
                        if ($row == 1) {
                            $header[$row][$column] = trim($data_value);
                        } else {
                            $arr_data[$row][$column] = trim($data_value);
                        }
                    }
                    //send the data in an array format
                    $data['header'] = $header;
                    $data['values'] = $arr_data;
                    $this->format_data($data['header'], $data['values'], $data['upload']);
                }
            }
        }
        //load the view
        $this->template->load($this->layout, 'utility/index', $data);
    }

    public function find_product()
    {
        $data['internal_part'] = $this->input->post('internal_part');
        // echo "in function ";pr($data['internal_part']);die;
        $product = $this->products->get_ink($data['internal_part']);
        $view['status'] = 0;
        if (!empty($product)) {
            // echo"in if";pr($product);die;
            $data['product'] = $product;
            $view['product'] = $product;
            //     $view['html_data'] = $this->load->view('testing/serial_product', $data, true);
            $view['status'] = 1;
            $this->session->set_userdata(array('utility' => $product));
        }
        echo json_encode($view);
        exit;
    }
    public function format_data($header, $values, $type)
    {
        $insert_all = [];
        foreach ($values as $val) {
            $insert_data = [];
            if (reset($val) != '') {
                $arr = array_combine(reset($header), $val);
                $internal = [];
                foreach ($arr as $key => $value) {

                    if ($key == 'HP P/N') {
                        $insert_data['hp_part'] = $value;
                        array_push($internal, $value);
                    }

                    if ($key == 'Name') {
                        $insert_data['name'] = $value;
                    }

                    if ($key == 'Ink #') {
                        $insert_data['ink'] = $value;
                        array_push($internal, $value);
                    }

                    if ($key == 'Type') {
                        $insert_data['type'] = $value;
                    }

                    if ($key == 'Type Code') {
                        $insert_data['type_code'] = $value;
                        array_push($internal, $value);
                    }

                    if ($key == 'Color') {
                        $insert_data['color'] = $value;
                    }

                    if ($key == 'Color Code') {
                        $insert_data['color_code'] = $value;
                        array_push($internal, $value);
                    }

                    if ($key == 'Condition') {
                        $insert_data['conditions'] = $value;
                    }

                    if ($key == 'Conditon Code') {
                        $insert_data['condition_code'] = $value;
                        array_push($internal, $value);
                    }

                }

                $insert_data['internal_part'] = implode("-", $internal);
                $insert_data['added_as_temp'] = 1;
                $insert_data['product_added_by'] = $this->session->userdata('id');
                $insert_data['status'] = 0;
                $insert_all[] = $insert_data;
            }
        }
        $id = $this->basic->insert_batch('ink_products', $insert_all);
        if ($id) {
            $this->session->set_flashdata('msg', 'The data has been uploaded successfully');
        } else {
            $this->session->set_flashdata('msg', 'Something went wrong, Please try again');
        }
    }
}
