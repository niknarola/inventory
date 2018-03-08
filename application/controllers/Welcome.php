<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$data = 'test';
		$this->template->load('layout', 'dashboard/index', $data);
	}
	public function import_excel_data(){
		$this->load->library('excel');
        $mtype = $this->input->post('mtype');
        $filepath = dirname(__FILE__) . '/docs';
		// for ($i=27; $i <= 31; $i++) { 
        // $filename = "splitfile".$i.".csv";
        $filename = "splitfile32.csv";
       		$objPHPExcel = PHPExcel_IOFactory::load($filepath. DIRECTORY_SEPARATOR .$filename);
            //get only the Cell Collection
            $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
            //extract to a PHP readable array format
            foreach ($cell_collection as $cell) {
                $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
                	$row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
                    $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
                    
                    //header will/should be in row 1 only. of course this can be modified to suit your need.
                    if ($row == 1) {
                            $header[$row][$column] = $data_value;
                    } else {
           //          	if($column=='F'){
					 	    // $data_value = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($data_value)); 
           //          	}
                        $arr_data[$row][$column] = $data_value;
                    }
            	}
            //send the data in an array format
            $data['header'] = $header;
            $data['values'] = $arr_data;
            // pr($data,1);
            $this->ins_excel_def_amt($data['header'], $data['values']);
        // }
      }
    public function ins_excel_def_amt($header,$values){
    	$this->load->model('basic_model');
        $finalres = [];
       foreach($values as $val){
            foreach($val as $key => $row){
            	$data[$header[1][$key]] = trim($row);
            	if($header[1][$key] == 'category'){
            		$categories = [];
            		if (strpos($row, '>') !== false) {
					    $a = explode('>', $row);
					    foreach ($a as $av) {
					    	if (strpos($av, ',') !== false) {
					    		$b = explode(',', $av);
					    		$e = '';
					    		foreach ($b as $v) {
					    			$e[] = $this->get_cat_id($v, 'categories');;
					    		}
								array_push($categories, $e);
					    	}else{
					    		$e = $this->get_cat_id($av, 'categories');
								array_push($categories, $e);
							}
					    }
					}else{
						$e = $this->get_cat_id($row, 'categories');
						array_push($categories, $e);
					}
					$data['category'] = json_encode($categories);	
				}
				if($header[1][$key] == 'product_line_id'){
					$p = $this->get_cat_id($row, 'product_line');
					$data['product_line_id'] = $p;	
				}
				if($header[1][$key] == 'original_condition_id'){
					$p = $this->get_cat_id($row, 'original_condition');
					$data['original_condition_id'] = $p;	
				}
				if($header[1][$key] == 'release_date'){
					$d = date('Y-m-d', strtotime($row));
					$data['release_date'] = $d;	
				}
			}
			array_push($finalres, $data);
        }
        // pr($finalres,1);
        // $this->basic_model->insert_batch('products', $finalres);
    }

    public function get_cat_id($name, $tbl){
    	$this->load->model('basic_model');
		$cond = ['name'=>trim($name)];
		$get_cat = $this->basic_model->get_single_data_by_criteria($tbl, $cond);
		return $get_cat['id'];
    }
} 