<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Utility extends CI_Controller {
    public $layout = '';
    public function __construct(){
        parent::__construct();
        $this->load->library('Ajax_pagination');
        $this->perPage = 10;
        $this->load->model('Product_model','products');
        $this->load->model('Basic_model','basic');
        $this->load->model('Locations_model','location');
        $this->load->model('Master_sheet_model','master');
        if($this->uri->segment(1)=='admin' && !$this->session->userdata('admin_validated')){
            redirect('admin/login');
        }else if($this->uri->segment(1)!='admin' && !$this->session->userdata('user_validated')) {
            redirect('login');
        }
        if($this->uri->segment(1)=='admin')
            $this->layout = 'admin/admin_layout';
        else
            $this->layout = 'layout'; 
    }
     public function index(){
        $data = array();
        $data['title'] = 'Utility Module';
        if ($this->input->post())
		{
			if($this->input->post('upload_sheet')){
				$data['upload'] = $this->input->post('upload_sheet');
				$this->load->library('excel');
				if (!empty($_FILES['excel']['tmp_name']))
				{
					$objPHPExcel = PHPExcel_IOFactory::load($_FILES['excel']['tmp_name']);
					$cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
					foreach ($cell_collection as $cell)
					{
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
					// pr($data,1);
					$this->format_data($data['header'], $data['values'], $data['upload']);
				}
			}
		}
        //load the view
        $this->template->load($this->layout, 'utility/index', $data);
    }
    
	public function format_data($header, $values, $type)
    {
        $finalres = [];
        $i = 0;
        $key_array = array();
        $data = [];
        if ($type == 'inventory')
        {
            foreach ($values as $val)
            {
                if (reset($val) != '')
                {
                    $x = array_combine($header[1], $val);
                    if (!in_array(reset($val), $key_array))
                    {
                        if (!empty($data))
                        {
                            $i++;
                        }
                        $key_array[] = reset($val);
                        $data[$i] = $x;
                        $data[$i]['internal_part'][] = [
                            'internal_part' => $data[$i]['Internal P/N'],
                            'conditions' => $data[$i]['Condition']
                        ];
                    }
                    else
                    {
                        $data[$i]['internal_part'][] = [
                            'internal_part' => $x['Internal P/N'],
                            'conditions' => $x['Condition']
                        ];
                    }
                }
            }
            if ($this->insert_ink($data, $type))
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
            $insert_data['name'] = '';
            $insert_data['ink'] = '';
            $root_path = $this->input->server('DOCUMENT_ROOT');

            foreach ($values as $val)
            {
                if (reset($val) != '')
                {
                    $arr = array_combine(reset($header), $val);

                    $image_data = [];
                    foreach ($arr as $key => $value)
                    {
                        if ($key == 'Internal P/N')
							$insert_data['internal_part'] = $value;
						
						if ($key == 'HP P/N')
						$insert_data['hp_part'] = $value;

                        if ($key == 'Name')
                            $insert_data['name'] = $value;
                        if ($key == 'Ink#')
                            $insert_data['ink'] .= $value . ' ';
                        if ($key == 'Type')
							$insert_data['type'] .= $value . ' ';
						if ($key == 'Type Code')
							$insert_data['type_code'] .= $value . ' ';
						if ($key == 'Color')
							$insert_data['color'] .= $value . ' ';
						if ($key == 'Color Code')
							$insert_data['color_code'] .= $value . ' ';
						if ($key == 'Condition')
							$insert_data['conditions'] .= $value . ' ';
						if ($key == 'Condition Code')
                            $insert_data['condition_code'] .= $value . ' ';
                        
                    }
                    $id_exists = $this->products->product_exists($insert_data['internal_part']);
                    if ($id_exists != 0)
                    {
                        $insert_data['added_as_temp'] = 1;
                        $insert_data['product_added_by'] = $this->session->userdata('id');
                        $insert_data['status'] = 0;
                    }
                    $id = $this->basic->insert('ink_products', $insert_data);
                    // if ($image_data['image'] != '')
                    // {
                    //     $folderPath = '/assets/uploads/' . $id;
                    //     $filename = time() . '.jpg';
                    //     $uploadPath = $root_path . $folderPath;
                    //     if (!file_exists($uploadPath))
                    //     {
                    //         mkdir($uploadPath, 0777, true);
                    //     }
                    //     $uploadPath = $root_path . $folderPath . '/' . $filename;
                    //     $ch = curl_init($image_data['image']);
                    //     $fp = fopen($uploadPath, 'wb');
                    //     curl_setopt($ch, CURLOPT_FILE, $fp);
                    //     curl_setopt($ch, CURLOPT_HEADER, 0);
                    //     curl_exec($ch);
                    //     curl_close($ch);
                    //     fclose($fp);
                    //     $image_data = [
                    //         'product_id' => $id,
                    //         'image' => $filename
                    //     ];
                    //     $this->basic->insert('product_images', $image_data);
                    // }
                }
            }
        }
        // $this->basic_model->insert_batch('products', $finalres);
	}
	
	public function insert_ink_products($data, $type)
    {
        if ($type == 'inventory')
        {
            foreach ($data as $ink_product)
            {
                $id_exists = $this->products->ink_product_exists($product['Internal P/N']);
                if ($id_exists == 0)
                {
                    $product_line = $this->basic->get_single_data_by_criteria('product_line', array('name' => $product['Product Line']));
                    $insert_data = [
                        'part' => $product['Part Number'],
                        'description' => $product['Description'],
                        'product_line_id' => $product_line['id']
                    ];
                    $id = $this->basic_model->insert('ink_products', $insert_data);
                }
                else
                {
                    $id = $id_exists;
                }
                // foreach ($product['serial'] as $serial)
                // {
                //     $serial_exists = $this->products->get_serial($serial['serial'], $id);
                //     if (empty($serial_exists))
                //     {
                //         $condition = $this->basic->get_single_data_by_criteria('original_condition', array('name' => $serial['condition']));
                //         $serial_data = [
                //             'serial' => $serial['serial'],
                //             'condition' => $condition['id'],
                //             'product_id' => $id
                //         ];
                //         $this->basic->insert('product_serials', $serial_data);
                //     }
                // }
            }
        }
    }
}
