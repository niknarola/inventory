<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Reports extends CI_Controller
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
        $this->load->model('Report_model', 'report');
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
        $data['title'] = 'Reports';
        $totalRec = count($this->report->get_hp_reports());

		$data['tech_name'] = $this->basic->get_user_by_role_id();
        $data['tech_reports'] = $this->report->get_tech_reports(['ps.is_delete' => '0']);
        $data['cat_url'] = ($this->uri->segment(1) == 'admin') ? 'admin/barcode/get_sub_category' : 'barcode/get_sub_category';
        $category_names = $this->products->get_categories();
        $data['categories'] = $category_names;

        $condtion = $this->products->get_key_value_pair('original_condition');
        $data['condition'] = $condtion;

        $data['locations'] = $this->products->get_key_value_pair('locations');

        //pagination configuration
        $data['ajax_url'] = ($this->session->userdata('admin_validated')) ? 'admin/inventory/reports' : 'reports';
        $url = ($this->session->userdata('admin_validated')) ? 'admin/inventory/reports/ajaxPaginationData' : 'reports/ajaxPaginationData';
        $data['url'] = $url;
        $config['target'] = '#postList';
        $config['base_url'] = base_url() . $url;
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $config['uri_segment'] = 4;
        $this->ajax_pagination->initialize($config);

        //get reports data
        $data['posts'] = $this->report->get_hp_reports(array('limit' => $this->perPage));
        //load the view
        $this->template->load($this->layout, 'reports/index', $data);
    }

    public function sortFunction($a, $b)
    {
        return strtotime($a[0]) - strtotime($b[0]);
    }

    public function ajaxPaginationData()
    {
        $conditions = array();
        //calc offset number
        $page = $this->input->post('page');
        if (!$page) {
            $offset = 0;
        } else {
            $offset = $page;
        }
        //set conditions for search
        $keywords = $this->input->post('keywords');
        $searchfor = $this->input->post('searchfor');
        $category1 = $this->input->post('category1');
        $category2 = $this->input->post('category2');
        $condition = $this->input->post('condition');
        $grade = $this->input->post('grade');
        $location = $this->input->post('location');
        $testing = $this->input->post('testing');
        $status = $this->input->post('status');
        if (!empty($keywords)) {
            $conditions['search']['keywords'] = $keywords;
        }
        if (!empty($searchfor) && $searchfor != 'none') {
            $conditions['search']['searchfor'] = $searchfor;
        }
        if (!empty($category1) && $category1 != 'none') {
            $conditions['search']['category1'] = $category1;
        }
        if (!empty($category2) && $category2 != 'none') {
            $conditions['search']['category2'] = $category2;
        }
        if (!empty($condition)) {
            $conditions['search']['condition'] = $condition;
        }
        if (!empty($grade)) {
            $conditions['search']['grade'] = $grade;
        }
        if (!empty($condition) && !empty($grade)) {
            $conditions['search']['condition'] = $condition;
            $conditions['search']['grade'] = $grade;
        }
        if (!empty($location)) {
            $conditions['search']['location'] = $location;
        }
        if (!empty($testing)) {
            $conditions['search']['testing'] = $testing;
        }
        if (!empty($status)) {
            $conditions['search']['status'] = $status;
        }
        //total rows count
        $totalRec = count($this->report->get_hp_reports($conditions));

        //pagination configuration
        $config['target'] = '#postList';
        $url = ($this->session->userdata('admin_validated')) ? 'admin/inventory/reports/ajaxPaginationData' : 'reports/ajaxPaginationData';
        $data['url'] = $url;
        $data['ajax_url'] = ($this->session->userdata('admin_validated')) ? 'admin/inventory/reports' : 'reports';
        $config['base_url'] = base_url() . $url;
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $config['uri_segment'] = 5;
        $this->ajax_pagination->initialize($config);

        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;

        //get reports data
        $data['posts'] = $this->report->get_hp_reports($conditions);
        //load the view
        $this->load->view('reports/ajax-pagination-data', $data, false);
    }

    public function ajax_list()
    {
        $list = $this->products->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $products) {
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
        );
        //output to json format
        echo json_encode($output);
        exit;
    }

    public function hp_report()
    {
        $this->load->library('excel');
        $conditions = array();
        //set conditions for search
        $keywords = $this->input->post('keywords');
        $searchfor = $this->input->post('searchfor');
        $category1 = $this->input->post('category1');
        $category2 = $this->input->post('category2');
        $condition = $this->input->post('condition');
        $grade = $this->input->post('grade');
        $loaction = $this->input->post('location');
        $testing = $this->input->post('testing');
        $status = $this->input->post('status');

        if (!empty($keywords)) {
            $conditions['search']['keywords'] = $keywords;
        }
        if (!empty($searchfor) && $searchfor != 'none') {
            $conditions['search']['searchfor'] = $searchfor;
        }
        if (!empty($category1) && $category1 != 'none') {
            $conditions['search']['category1'] = $category1;
        }
        if (!empty($category2) && $category2 != 'none') {
            $conditions['search']['category2'] = $category2;
        }
        if (!empty($condition)) {
            $conditions['search']['condition'] = $condition;
        }
        if (!empty($grade)) {
            $conditions['search']['grade'] = $grade;
        }
        if (!empty($condition) && !empty($grade)) {
            $conditions['search']['condition'] = $condition;
            $conditions['search']['grade'] = $grade;
        }
        if (!empty($location)) {
            $conditions['search']['location'] = $location;
        }
        if (!empty($testing)) {
            $conditions['search']['testing'] = $testing;
        }
        if (!empty($status)) {
            $conditions['search']['status'] = $status;
        }

        //All Data
        if ($this->input->post('select_data') == '0') {
            //============================================================HP Reports===============================================================
            $this->excel->createSheet();
            $this->excel->setActiveSheetIndex(0);
            $this->excel->getSheet(0)->setTitle("HP Reports");
            $this->data['hp'] = $this->report->get_hp_reports($conditions);
            $data = ["0" => ['part' => "Part Number",
                'serial' => "Serial Number",
                'date_received' => "Date Received",
                'condition' => 'Condition Received',
                'cosmetic_grade' => 'Cosmetic Grade',
                'test_result' => 'Testing Result',
                'fail_reason_notes' => 'Reason(if fail)',
                'location' => 'Current Location',
                'days_location' => 'Days in Location',
                'status' => 'Status',
            ]];
            foreach ($this->data['hp'] as $result) {
                $start_date = date_create($result['location_assigned_date']);
                $end_date = date_create($result['status_change_date']);
                $date = date_diff($start_date, $end_date);
                $days = $date->format("%d");
//                $new_date = $date->format('%R%a days');

                $data[] = ['part' => $result['part'],
                    'serial' => $result['serial'],
                    'date_received' => $result['received_date'],
                    'condition' => $result['original_condition'],
                    'cosmetic_grade' => $result['cosmetic_grade'],
                    'test_result' => ($result['pass'] == '1' && $result['fail'] == '1') ? 'Pass' : '',
                    'fail_reason_notes' => $result['fail_reason_notes'],
                    'location' => $result['pallet_location_name'],
                    'days_location' => $days,
                    'status' => $result['status'],
                ];
            }

            $this->excel->getActiveSheet()->fromArray($data, null, 'A3');
            $highestColumm = $this->excel->getActiveSheet()->getHighestColumn();
            $highestRow = $this->excel->getActiveSheet()->getHighestRow();
            $this->excel->getActiveSheet()->setCellValue('A1', 'HP Reports');
            $this->excel->getActiveSheet()->mergeCells('A1:' . $highestColumm . '2');
            $this->excel->getActiveSheet()->getStyle('A1:' . $highestColumm . '2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('A1:' . $highestColumm . '2')->getFont()->setSize(16);

            for ($column = 'A'; $column <= $highestColumm; $column++) {
                $this->excel->getActiveSheet()->getStyle('A3:' . $highestColumm . '3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('A3:' . $highestColumm . '3')->getFont()->setSize(15);
                $this->excel->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
            }

            for ($row = '4'; $row <= $highestRow; $row++) {
                for ($column = 'A'; $column <= $highestColumm; $column++) {
                    $this->excel->getActiveSheet()->getStyle('A' . $row . ':' . $highestColumm . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->excel->getActiveSheet()->getStyle('A' . $row . ':' . $highestColumm . $row)->getFont()->setSize(12);
                    $this->excel->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
                }
            }
            //============================================================HP Reports===============================================================
            //============================================================Refurbished Reports======================================================
            $this->excel->createSheet();
            $this->excel->setActiveSheetIndex(1);
            $this->excel->getSheet(1)->setTitle('Refurbished QC Reports');
            $this->data['refurbished'] = $this->report->get_hp_reports($conditions);
            $data = ["0" => ['part' => "Part Number",
                'serial' => "Serial Number",
                'date_tested' => "Date Tested",
                'condition' => 'Condition Received',
                'cosmetic_grade' => 'Cosmetic Grade',
                'test_result' => 'Testing Result',
                'fail_reason_notes' => 'Reason(if fail)',
                'harddirve' => 'Hard Drive Wiped',
                'factory_reset' => 'Factory Reset',
                'status' => 'Status',
            ]];
            foreach ($this->data['refurbished'] as $result) {
                $data[] = ['part' => $result['part'],
                    'serial' => $result['serial'],
                    'date_tested' => $result['testing_date'],
                    'condition' => $result['original_condition'],
                    'cosmetic_grade' => $result['cosmetic_grade'],
                    'test_result' => ($result['pass'] == '1' && $result['fail'] == '1') ? 'Pass' : '',
                    'fail_reason_notes' => $result['fail_reason_notes'],
                    'harddrive' => $result['hard_drive_wiped_date'],
                    'factory_reset' => $result['factory_reset_date'],
                    'status' => $result['status'],
                ];
            }
            $this->excel->getActiveSheet()->fromArray($data, null, 'A3');
            $highestColumm = $this->excel->getActiveSheet()->getHighestColumn();
            $highestRow = $this->excel->getActiveSheet()->getHighestRow();
            $this->excel->getActiveSheet()->setCellValue('A1', 'Refurbished QC Reports');
            $this->excel->getActiveSheet()->mergeCells('A1:' . $highestColumm . '2');
            $this->excel->getActiveSheet()->getStyle('A1:' . $highestColumm . '2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('A1:' . $highestColumm . '2')->getFont()->setSize(16);

            for ($column = 'A'; $column <= $highestColumm; $column++) {
                $this->excel->getActiveSheet()->getStyle('A3:' . $highestColumm . '3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('A3:' . $highestColumm . '3')->getFont()->setSize(15);
                $this->excel->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
            }

            for ($row = '4'; $row <= $highestRow; $row++) {
                for ($column = 'A'; $column <= $highestColumm; $column++) {
                    $this->excel->getActiveSheet()->getStyle('A' . $row . ':' . $highestColumm . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->excel->getActiveSheet()->getStyle('A' . $row . ':' . $highestColumm . $row)->getFont()->setSize(12);
                    $this->excel->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
                }
            }
            //============================================================Refurbished Reports======================================================
            //============================================================Aging Reports============================================================
            $this->excel->createSheet();
            $this->excel->setActiveSheetIndex(2);
            $this->excel->getSheet(2)->setTitle('Aging Inventory Reports');
            $this->data['aging'] = $this->report->get_hp_reports($conditions);
            $data = ["0" => ['part' => "Part Number",
                'serial' => "Serial Number",
                'date_scanned' => "Date of Last Scan",
                'date_received' => "Date Received",
                'date_inspection' => "Inspection Date",
                'date_tested' => "Testing Date",
                'date_inventory' => "Inventory Date",
                'location' => 'Current Location',
                'days_location' => 'Days in Location',
                'status' => 'Status',
            ]];
            foreach ($this->data['aging'] as $result) {
                $start_date = date_create($result['location_assigned_date']);
                $end_date = date_create($result['status_change_date']);
                $date = date_diff($start_date, $end_date);
                $days = $date->format("%d");

                $data[] = ['part' => $result['part'],
				'serial' => $result['serial'],
				'date_scanned' => $result['last_scan'],
				'date_received' => $result['received_date'],
				'date_inspection' => $result['inspection_date'],
				'date_tested' => $result['testing_date'],
				'date_inventory' => $result['inventory_date'],
				'location' => $result['pallet_location_name'],
				'days_location' => $days,
				'status' => $result['status'],
			];
            }
            $this->excel->getActiveSheet()->fromArray($data, null, 'A3');
            $highestColumm = $this->excel->getActiveSheet()->getHighestColumn();
            $highestRow = $this->excel->getActiveSheet()->getHighestRow();
//            $style['red_text'] = array(
            //                'name' => 'Arial',
            //                'color' => array(
            //                    'rgb' => 'FF0000'
            //                )
            //            );
            $this->excel->getActiveSheet()->setCellValue('A1', 'Aging Inventory Reports');
            $this->excel->getActiveSheet()->mergeCells('A1:' . $highestColumm . '2');
            $this->excel->getActiveSheet()->getStyle('A1:' . $highestColumm . '2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('A1:' . $highestColumm . '2')->getFont()->setSize(16);
            $this->excel->getActiveSheet()->setCellValue('A1', 'Aging Inventory Reports');
//            $this->excel->getActiveSheet()->getStyleByColumnAndRow('A', '1')->getFont()->applyFromArray($style['red_text']);
            //            $this->excel->getActiveSheet()->getStyleByColumnAndRow('A', '1')->getFont();

            for ($column = 'A'; $column <= $highestColumm; $column++) {
                $this->excel->getActiveSheet()->getStyle('A3:' . $highestColumm . '3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('A3:' . $highestColumm . '3')->getFont()->setSize(15);
                $this->excel->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
            }

            for ($row = '4'; $row <= $highestRow; $row++) {
                for ($column = 'A'; $column <= $highestColumm; $column++) {
                    $this->excel->getActiveSheet()->getStyle('A' . $row . ':' . $highestColumm . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->excel->getActiveSheet()->getStyle('A' . $row . ':' . $highestColumm . $row)->getFont()->setSize(12);
                    $this->excel->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
                }
            }
            //============================================================Aging Reports============================================================
            //============================================================Tech reports=============================================================
            $this->excel->createSheet();
            $this->excel->setActiveSheetIndex(3);
            $this->excel->getSheet(3)->setTitle('Tech Reports');
            $data = array();
            $date = $this->input->post('date');
            $category1 = $this->input->post('category1');
            $category2 = $this->input->post('category2');
            $date_array = array();
            $date_string = '';
            if ($date != '') {
                $dates = explode('-', $date);
                $start_date = $dates[0];
                $end_date = $dates[1];
                $date_array = array('ps.created >=' => date('Y-m-d', strtotime($start_date)), 'ps.created <=' => date('Y-m-d', strtotime($end_date)));
                $date_string = ' AND created >="' . date('Y-m-d', strtotime($start_date)) . '" AND created <="' . date('Y-m-d', strtotime($end_date)) . '"';
                $event_arr['from_date'] = date('Y-m-d', strtotime($start_date));
                $event_arr['to_date'] = date('Y-m-d', strtotime($end_date));
            }

            $this->data['json'] = json_encode("");

            //-- Json data for chart
            $condition = array(
                'tech_category1' => '"' . $category1 . '"',
                'tech_category2' => '"' . $category2 . '"',
            );
            if (count($condition) > 0) {
                $json_data = array(
                    'tech_reports' => $this->report->get_tech_reports(array_merge($date_array, array('ps.is_delete' => '0'))),
                );
            } else {
                $json_data = array(
                    'tech_reports' => $this->report->get_tech_reports(array_merge($date_array, array('ps.is_delete' => '0')), $condition),
                );
            }
            $new_json_data = array();
            $key_arrays = array();
            foreach ($json_data as $key => $val) {
                $new_array = array();
                foreach ($val as $val1) {
                    $new_array[$val1['date']] = $val1['count'];
                    $key_arrays[] = array($val1['date'], date('d. M \'y', strtotime($val1['date'])));
                }
                $new_json_data[$key] = $new_array;
            }

            $key_arrays = array_unique($key_arrays, SORT_REGULAR);
            usort($key_arrays, array($this, 'sortFunction'));

            $actions = [];
            foreach ($new_json_data as $k => $data_value) {
                $actions[$k] = array();
                foreach ($key_arrays as $key => $value) {
                    if (isset($data_value[$value[0]])) {
                        $actions[$k][$value[0]] = array(
                            $data_value[$value[0]], $value[1],
                        );
                    }
                }
            }

            $actions['key_array'] = $key_arrays;
            $this->data['json'] = json_encode($actions);
            $data['tech_name'] = $this->basic->get_all_data_by_criteria('users', ['role_id' => '3']);

            if (count($condition) > 0) {
                $data['tech_reports'] = $this->report->get_tech_reports(array_merge($date_array, array('ps.is_delete' => '0')));
            } else {
                $data['tech_reports'] = $this->report->get_tech_reports(array_merge($date_array, array('ps.is_delete' => '0')), $condition);
            }
//            $this->data['tech_reports'] = $this->report->get_tech_reports();
            $data1 = ["0" => ['rank' => "Rank",
                'tech' => "Tech",
                'completed' => "Completed",
                'inprogress' => "In Progress",
                'notebooks' => "Notebooks",
                'desktops' => "Desktops",
                'thin_clients' => "Thin Clients",
                'all_in_ones' => 'All-In-Ones',
                'tablets' => 'Tablets',
                'monitors' => 'Monitors',
                'printers' => 'Printers',
                'pass' => 'Pass%',
                'accessories' => 'Accessories',
                'other' => 'Other',
            ]];
            $count = 1;
            foreach ($data['tech_reports'] as $result) {
                $data1[] = ['rank' => $count++,
                    'tech' => $result['name'],
                    'completed' => $result['complete'],
                    'inprogress' => $result['inprogress'],
                    'notebooks' => $result['notebook_count'],
                    'desktops' => $result['desktop_count'],
                    'thin_clients' => $result['thinclient_count'],
                    'all_in_ones' => $result['allinone_count'],
                    'tablets' => $result['tablet_count'],
                    'monitors' => $result['monitor_count'],
                    'printers' => $result['printer_count'],
                    'pass' => ($result['count'] != 0) ? number_format(($result['complete'] / $result['count'] * 100), 2) . '%' : "N/A",
                    'accessories' => $result['accessory_count'],
                    'other' => $result['other_count'],
                ];
            }
            $this->excel->getActiveSheet()->fromArray($data1, null, 'A3');
            $highestColumm = $this->excel->getActiveSheet()->getHighestColumn();
            $highestRow = $this->excel->getActiveSheet()->getHighestRow();
            $this->excel->getActiveSheet()->setCellValue('A1', 'Tech Reports');
            $this->excel->getActiveSheet()->mergeCells('A1:' . $highestColumm . '2');
            $this->excel->getActiveSheet()->getStyle('A1:' . $highestColumm . '2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('A1:' . $highestColumm . '2')->getFont()->setSize(16);
            $this->excel->getActiveSheet()->setCellValue('A1', 'Tech Reports');

            for ($column = 'A'; $column <= $highestColumm; $column++) {
                $this->excel->getActiveSheet()->getStyle('A3:' . $highestColumm . '3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('A3:' . $highestColumm . '3')->getFont()->setSize(15);
                $this->excel->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
            }

            for ($row = '4'; $row <= $highestRow; $row++) {
                for ($column = 'A'; $column <= $highestColumm; $column++) {
                    $this->excel->getActiveSheet()->getStyle('A' . $row . ':' . $highestColumm . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->excel->getActiveSheet()->getStyle('A' . $row . ':' . $highestColumm . $row)->getFont()->setSize(12);
                    $this->excel->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
                }
            }
            //============================================================Tech reports=============================================================
            $filename = 'all_reports.xls';
        } else {
            $this->excel->setActiveSheetIndex(0);
            //HP Reports
            if ($this->input->post('select_data') == '1') {
                $this->data['hp'] = $this->report->get_hp_reports($conditions);

                $data = ["0" => ['part' => "Part Number",
                    'serial' => "Serial Number",
                    'date_received' => "Date Received",
                    'condition' => 'Condition Received',
                    'cosmetic_grade' => 'Cosmetic Grade',
                    'test_result' => 'Testing Result',
                    'fail_reason_notes' => 'Reason(if fail)',
                    'location' => 'Current Location',
                    'days_location' => 'Days in Location',
                    'status' => 'Status',
                ]];
                foreach ($this->data['hp'] as $result) {
                    $start_date = date_create($result['location_assigned_date']);
                    $end_date = date_create($result['status_change_date']);
                    $date = date_diff($start_date, $end_date);
                    $days = $date->format("%d");
//                    $new_date = $date->format('%R%a days');

                    $data[] = ['part' => $result['part'],
                        'serial' => $result['serial'],
                        'date_received' => $result['received_date'],
                        'condition' => $result['original_condition'],
                        'cosmetic_grade' => $result['cosmetic_grade'],
                        'test_result' => ($result['pass'] == '1' && $result['fail'] == '1') ? 'Pass' : '',
                        'fail_reason_notes' => $result['fail_reason_notes'],
                        'location' => $result['pallet_location_name'],
                        'days_location' => $days,
                        'status' => $result['status'],
                    ];
                }
                $this->excel->getActiveSheet()->fromArray($data, null, 'A3');
                $highestColumm = $this->excel->getActiveSheet()->getHighestColumn();
                $highestRow = $this->excel->getActiveSheet()->getHighestRow();
                $this->excel->getActiveSheet()->setCellValue('A1', 'HP Reports');
                $this->excel->getActiveSheet()->mergeCells('A1:' . $highestColumm . '2');
                $this->excel->getActiveSheet()->getStyle('A1:' . $highestColumm . '2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('A1:' . $highestColumm . '2')->getFont()->setSize(15);

                for ($column = 'A'; $column <= $highestColumm; $column++) {
                    $this->excel->getActiveSheet()->getStyle('A3:' . $highestColumm . '3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->excel->getActiveSheet()->getStyle('A3:' . $highestColumm . '3')->getFont()->setSize(14);
                    $this->excel->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
                }

                for ($row = '4'; $row <= $highestRow; $row++) {
                    for ($column = 'A'; $column <= $highestColumm; $column++) {
                        $this->excel->getActiveSheet()->getStyle('A' . $row . ':' . $highestColumm . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                        $this->excel->getActiveSheet()->getStyle('A' . $row . ':' . $highestColumm . $row)->getFont()->setSize(13);
                        $this->excel->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
                    }
                }
                $filename = 'hp_report.xls';
            }

            //Refurbished
            elseif ($this->input->post('select_data') == '2') {
                $this->data['refurbished'] = $this->report->get_hp_reports($conditions);

                $data = ["0" => ['part' => "Part Number",
                    'serial' => "Serial Number",
                    'date_tested' => "Date Tested",
                    'condition' => 'Condition Received',
                    'cosmetic_grade' => 'Cosmetic Grade',
                    'test_result' => 'Testing Result',
                    'fail_reason_notes' => 'Reason(if fail)',
                    'harddirve' => 'Hard Drive Wiped',
                    'factory_reset' => 'Factory Reset',
                    'status' => 'Status',
                ]];
                foreach ($this->data['refurbished'] as $result) {
                    $data[] = ['part' => $result['part'],
                        'serial' => $result['serial'],
                        'date_tested' => $result['testing_date'],
                        'condition' => $result['original_condition'],
                        'cosmetic_grade' => $result['cosmetic_grade'],
                        'test_result' => ($result['pass'] == '1' && $result['fail'] == '1') ? 'Pass' : '',
                        'fail_reason_notes' => $result['fail_reason_notes'],
                        'harddrive' => $result['hard_drive_wiped_date'],
                        'factory_reset' => $result['factory_reset_date'],
                        'status' => $result['status'],
                    ];
                }
                $this->excel->getActiveSheet()->fromArray($data, null, 'A3');
                $highestColumm = $this->excel->getActiveSheet()->getHighestColumn();
                $highestRow = $this->excel->getActiveSheet()->getHighestRow();
                $this->excel->getActiveSheet()->setCellValue('A1', 'Refurbished QC Reports');
                $this->excel->getActiveSheet()->mergeCells('A1:' . $highestColumm . '2');
                $this->excel->getActiveSheet()->getStyle('A1:' . $highestColumm . '2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('A1:' . $highestColumm . '2')->getFont()->setSize(15);

                for ($column = 'A'; $column <= $highestColumm; $column++) {
                    $this->excel->getActiveSheet()->getStyle('A3:' . $highestColumm . '3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->excel->getActiveSheet()->getStyle('A3:' . $highestColumm . '3')->getFont()->setSize(14);
                    $this->excel->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
                }

                for ($row = '4'; $row <= $highestRow; $row++) {
                    for ($column = 'A'; $column <= $highestColumm; $column++) {
                        $this->excel->getActiveSheet()->getStyle('A' . $row . ':' . $highestColumm . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                        $this->excel->getActiveSheet()->getStyle('A' . $row . ':' . $highestColumm . $row)->getFont()->setSize(13);
                        $this->excel->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
                    }
                }
                $filename = 'refurbished_report.xls';
            }

            //Aging Reports
            elseif ($this->input->post('select_data') == '3') {
                $this->data['aging'] = $this->report->get_hp_reports($conditions);
                $data = ["0" => ['part' => "Part Number",
                    'serial' => "Serial Number",
                    'date_scanned' => "Date of Last Scan",
                    'date_received' => "Date Received",
                    'date_inspection' => "Inspection Date",
                    'date_tested' => "Testing Date",
                    'date_inventory' => "Inventory Date",
                    'location' => 'Current Location',
//                    'days_location' => 'Days in Location',
                    'status' => 'Status',
                ]];
                foreach ($this->data['aging'] as $result) {
                    $data[] = ['part' => $result['part'],
                        'serial' => $result['serial'],
                        'date_scanned' => $result['last_scan'],
                        'date_received' => $result['received_date'],
                        'date_inspection' => $result['inspection_date'],
                        'date_tested' => $result['testing_date'],
                        'date_inventory' => $result['inventory_date'],
                        'location' => $result['pallet_location_name'],
//                    'days_location' => $result['location'],
                        'status' => $result['status'],
                    ];
                }
                $this->excel->getActiveSheet()->fromArray($data, null, 'A3');
                $highestColumm = $this->excel->getActiveSheet()->getHighestColumn();
                $highestRow = $this->excel->getActiveSheet()->getHighestRow();
                $this->excel->getActiveSheet()->setCellValue('A1', 'Aging Inventory Reports');
                $this->excel->getActiveSheet()->mergeCells('A1:' . $highestColumm . '2');
                $this->excel->getActiveSheet()->getStyle('A1:' . $highestColumm . '2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('A1:' . $highestColumm . '2')->getFont()->setSize(15);

                for ($column = 'A'; $column <= $highestColumm; $column++) {
                    $this->excel->getActiveSheet()->getStyle('A3:' . $highestColumm . '3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->excel->getActiveSheet()->getStyle('A3:' . $highestColumm . '3')->getFont()->setSize(14);
                    $this->excel->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
                }

                for ($row = '4'; $row <= $highestRow; $row++) {
                    for ($column = 'A'; $column <= $highestColumm; $column++) {
                        $this->excel->getActiveSheet()->getStyle('A' . $row . ':' . $highestColumm . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                        $this->excel->getActiveSheet()->getStyle('A' . $row . ':' . $highestColumm . $row)->getFont()->setSize(13);
                        $this->excel->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
                    }
                }
                $filename = 'aging_report.xls';
            }

            //Tech Reports
            elseif ($this->input->post('select_data') == '4') {
                $data = array();
                $date = $this->input->post('date');
                $category1 = $this->input->post('category1');
                $category2 = $this->input->post('category2');
                $date_array = array();
                $date_string = '';
                if ($date != '') {
                    $dates = explode('-', $date);
                    $start_date = $dates[0];
                    $end_date = $dates[1];
                    $date_array = array('ps.created >=' => date('Y-m-d', strtotime($start_date)), 'ps.created <=' => date('Y-m-d', strtotime($end_date)));
                    $date_string = ' AND created >="' . date('Y-m-d', strtotime($start_date)) . '" AND created <="' . date('Y-m-d', strtotime($end_date)) . '"';
                    $event_arr['from_date'] = date('Y-m-d', strtotime($start_date));
                    $event_arr['to_date'] = date('Y-m-d', strtotime($end_date));
                }

                $this->data['json'] = json_encode("");

                //-- Json data for chart
                $condition = array(
                    'tech_category1' => '"' . $category1 . '"',
                    'tech_category2' => '"' . $category2 . '"',
                );
                if (count($condition) > 0) {
                    $json_data = array(
                        'tech_reports' => $this->report->get_tech_reports(array_merge($date_array, array('ps.is_delete' => '0'))),
                    );
                } else {
                    $json_data = array(
                        'tech_reports' => $this->report->get_tech_reports(array_merge($date_array, array('ps.is_delete' => '0')), $condition),
                    );
                }
                $new_json_data = array();
                $key_arrays = array();
                foreach ($json_data as $key => $val) {
                    $new_array = array();
                    foreach ($val as $val1) {
                        $new_array[$val1['date']] = $val1['count'];
                        $key_arrays[] = array($val1['date'], date('d. M \'y', strtotime($val1['date'])));
                    }
                    $new_json_data[$key] = $new_array;
                }

                $key_arrays = array_unique($key_arrays, SORT_REGULAR);
                usort($key_arrays, array($this, 'sortFunction'));

                $actions = [];
                foreach ($new_json_data as $k => $data_value) {
                    $actions[$k] = array();
                    foreach ($key_arrays as $key => $value) {
                        if (isset($data_value[$value[0]])) {
                            $actions[$k][$value[0]] = array(
                                $data_value[$value[0]], $value[1],
                            );
                        }
                    }
                }

                $actions['key_array'] = $key_arrays;
                $this->data['json'] = json_encode($actions);
                $data['tech_name'] = $this->basic->get_all_data_by_criteria('users', ['role_id' => '3']);

                if (count($condition) > 0) {
                    $data['tech_reports'] = $this->report->get_tech_reports(array_merge($date_array, array('ps.is_delete' => '0')));
                } else {
                    $data['tech_reports'] = $this->report->get_tech_reports(array_merge($date_array, array('ps.is_delete' => '0')), $condition);
                }
                $data1 = ["0" => ['rank' => "Rank",
                    'tech' => "Tech",
                    'completed' => "Completed",
                    'inprogress' => "In Progress",
                    'notebooks' => "Notebooks",
                    'desktops' => "Desktops",
                    'thin_clients' => "Thin Clients",
                    'all_in_ones' => 'All-In-Ones',
                    'tablets' => 'Tablets',
                    'monitors' => 'Monitors',
                    'printers' => 'Printers',
                    'pass' => 'Pass%',
                    'accessories' => 'Accessories',
                    'other' => 'Other',
                ]];
                $count = 1;
                foreach ($data['tech_reports'] as $result) {
                    $data1[] = ['rank' => $count++,
                        'tech' => $result['name'],
                        'completed' => $result['complete'],
                        'inprogress' => $result['inprogress'],
                        'notebooks' => $result['notebook_count'],
                        'desktops' => $result['desktop_count'],
                        'thin_clients' => $result['thinclient_count'],
                        'all_in_ones' => $result['allinone_count'],
                        'tablets' => $result['tablet_count'],
                        'monitors' => $result['monitor_count'],
                        'printers' => $result['printer_count'],
                        'pass' => ($result['count'] != 0) ? number_format(($result['complete'] / $result['count'] * 100), 2) . '%' : "N/A",
                        'accessories' => $result['accessory_count'],
                        'other' => $result['other_count'],
                    ];
                }

                $this->excel->getActiveSheet()->fromArray($data1, null, 'A3');
                $highestColumm = $this->excel->getActiveSheet()->getHighestColumn();
                $highestRow = $this->excel->getActiveSheet()->getHighestRow();
                $this->excel->getActiveSheet()->setCellValue('A1', 'Tech Reports');
                $this->excel->getActiveSheet()->mergeCells('A1:' . $highestColumm . '2');
                $this->excel->getActiveSheet()->getStyle('A1:' . $highestColumm . '2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('A1:' . $highestColumm . '2')->getFont()->setSize(15);

                for ($column = 'A'; $column <= $highestColumm; $column++) {
                    $this->excel->getActiveSheet()->getStyle('A3:' . $highestColumm . '3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $this->excel->getActiveSheet()->getStyle('A3:' . $highestColumm . '3')->getFont()->setSize(14);
                    $this->excel->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
                }

                for ($row = '4'; $row <= $highestRow; $row++) {
                    for ($column = 'A'; $column <= $highestColumm; $column++) {
                        $this->excel->getActiveSheet()->getStyle('A' . $row . ':' . $highestColumm . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                        $this->excel->getActiveSheet()->getStyle('A' . $row . ':' . $highestColumm . $row)->getFont()->setSize(13);
                        $this->excel->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
                    }
                }
                $filename = 'tech_report.xls';
            }
        }
//        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream; charset=UTF-8LE");
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
        ob_end_clean();
        ob_start();
        $objWriter->save('php://output');
        exit;
    }

    public function tech_reports()
    {
        //==============================================date and category filters for tech reports====================================================
        $data = array();

        $date = $this->input->post('date');
        $category1 = $this->input->post('category1');
        $category2 = $this->input->post('category2');
        $date_array = array();
        $date_string = '';
        if ($date != '') {
            $dates = explode('-', $date);
            $start_date = $dates[0];
            $end_date = $dates[1];
            $date_array = array('ps.created >=' => date('Y-m-d', strtotime($start_date)), 'ps.created <=' => date('Y-m-d', strtotime($end_date)));
            $date_string = ' AND created >="' . date('Y-m-d', strtotime($start_date)) . '" AND created <="' . date('Y-m-d', strtotime($end_date)) . '"';
            $event_arr['from_date'] = date('Y-m-d', strtotime($start_date));
            $event_arr['to_date'] = date('Y-m-d', strtotime($end_date));
        }

        $this->data['json'] = json_encode("");

        //-- Json data for chart
        $condition = array(
            'tech_category1' => '"' . $category1 . '"',
            'tech_category2' => '"' . $category2 . '"',
        );
        if (count($condition) > 0) {
            $json_data = array(
                'tech_reports' => $this->report->get_tech_reports(array_merge($date_array, array('ps.is_delete' => '0'))),
            );
        } else {
            $json_data = array(
                'tech_reports' => $this->report->get_tech_reports(array_merge($date_array, array('ps.is_delete' => '0')), $condition),
            );
        }
        $new_json_data = array();
        $key_arrays = array();
        foreach ($json_data as $key => $val) {
            $new_array = array();
            foreach ($val as $val1) {
                $new_array[$val1['date']] = $val1['count'];
                $key_arrays[] = array($val1['date'], date('d. M \'y', strtotime($val1['date'])));
            }
            $new_json_data[$key] = $new_array;
        }

        $key_arrays = array_unique($key_arrays, SORT_REGULAR);
        usort($key_arrays, array($this, 'sortFunction'));

        $actions = [];
        foreach ($new_json_data as $k => $data_value) {
            $actions[$k] = array();
            foreach ($key_arrays as $key => $value) {
                if (isset($data_value[$value[0]])) {
                    $actions[$k][$value[0]] = array(
                        $data_value[$value[0]], $value[1],
                    );
                }
            }
        }

        $actions['key_array'] = $key_arrays;
        $this->data['json'] = json_encode($actions);
        $data['tech_name'] = $this->basic->get_all_data_by_criteria('users', ['role_id' => '3']);

        if (count($condition) > 0) {
            $data['tech_reports'] = $this->report->get_tech_reports(array_merge($date_array, array('ps.is_delete' => '0')));
        } else {
            $data['tech_reports'] = $this->report->get_tech_reports(array_merge($date_array, array('ps.is_delete' => '0')), $condition);
        }
        if ($data['tech_reports']) {
//            pr($data['tech_reports'],1);
            $resp['status'] = 1;
            $resp['data'] = $this->load->view('reports/tech_tbl', $data, true);
        } else {
            $resp['status'] = 0;
        }
        echo json_encode($resp);

        //==============================================date and category filters for tech reports====================================================
    }

    public function reports_results()
    {
        //date wise records
        $data = array();

        $date = $this->input->post('date');
        $id = $this->input->post('id');
        $category1 = $this->input->post('category1');
        $category2 = $this->input->post('category2');
        $date_array = array();
        $date_string = '';
        if ($date != '') {
            $dates = explode('-', $date);
            $start_date = $dates[0];
            $end_date = $dates[1];
            $date_array = array('ps.created >=' => date('Y-m-d', strtotime($start_date)), 'ps.created <=' => date('Y-m-d', strtotime($end_date)));
            $date_string = ' AND created >="' . date('Y-m-d', strtotime($start_date)) . '" AND created <="' . date('Y-m-d', strtotime($end_date)) . '"';
            $event_arr['from_date'] = date('Y-m-d', strtotime($start_date));
            $event_arr['to_date'] = date('Y-m-d', strtotime($end_date));
        }

        $this->data['json'] = json_encode("");

        //-- Json data for chart
        $whereArr = array(
            'ps.is_delete' => '0',
            'u.id' => $id,
        );
        $condition = array(
            'tech_category1' => '"' . $category1 . '"',
            'tech_category2' => '"' . $category2 . '"',
        );
        if (count($condition) > 0) {
            $json_data = array(
                'tech_reports_results' => $this->report->get_tech_reports_results(array_merge($date_array, $whereArr)),
            );
        } else {
            $json_data = array(
                'tech_reports_results' => $this->report->get_tech_reports_results(array_merge($date_array, $whereArr), $condition),
            );
        }
//        pr($json_data);
        //        var_dump(!empty($json_data));
        //        die;
        if (!empty($json_data)) {
            $new_json_data = array();
            $key_arrays = array();
            foreach ($json_data as $key => $val) {
                if (!empty($val)) {
                    $new_array = array();
                    foreach ($val as $val1) {
                        $new_array[$val1['date']] = $val1['count'];
                        $key_arrays[] = array($val1['date'], date('d. M \'y', strtotime($val1['date'])));
                    }
                    $new_json_data[$key] = $new_array;
                } else {
//                    echo "No data found";
                }
            }

            $key_arrays = array_unique($key_arrays, SORT_REGULAR);
            usort($key_arrays, array($this, 'sortFunction'));

            $actions = [];
            foreach ($new_json_data as $k => $data_value) {
                $actions[$k] = array();
                foreach ($key_arrays as $key => $value) {
                    if (isset($data_value[$value[0]])) {
                        $actions[$k][$value[0]] = array(
                            $data_value[$value[0]], $value[1],
                        );
                    }
                }
            }

            $actions['key_array'] = $key_arrays;
            $this->data['json'] = json_encode($actions);
        }

        if (count($condition) > 0) {
            $data['report_results'] = $this->report->get_tech_reports_results(array_merge($date_array, $whereArr));
        } else {
            $data['report_results'] = $this->report->get_tech_reports_results(array_merge($date_array, $whereArr), $condition);
        }
        if ($data['report_results']) {
            $data['tech_name'] = $data['report_results'][0]['tech_name'];
            $resp['status'] = 1;
            $resp['data'] = $this->load->view('reports/rept_tbl', $data, true);
        } else {
            $resp['status'] = 0;
//             $resp['msg'] = "No data found";
        }
        echo json_encode($resp);
    }

    public function download_part_numbers()
    {
		// echo"in function "; die;
        // ini_set('max_execution_time', 300); //300 seconds = 5 minutes
        set_time_limit(0);

        $this->load->library('excel');

        $this->excel->createSheet();
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getSheet(0)->setTitle("Part Numbers");
        $this->data['part_numbers'] = $this->products->get_part_numbers();
//         pr($this->data['part_numbers']);die;
        $data1 = ["0" => ['part' => "Part Number",
                    'name' => "Name",
                    
                ]];
        foreach ($this->data['part_numbers'] as $result) {
            $data1[] = ['part' => $result['part'],
                        'name' => $result['name']
                    ];
        }

        $this->excel->getActiveSheet()->fromArray($data1, null, 'A3');
        $highestColumm = $this->excel->getActiveSheet()->getHighestColumn();
        $highestRow = $this->excel->getActiveSheet()->getHighestRow();
        $this->excel->getActiveSheet()->setCellValue('A1', 'Part Numbers');
        $this->excel->getActiveSheet()->mergeCells('A1:' . $highestColumm . '2');
        $this->excel->getActiveSheet()->getStyle('A1:' . $highestColumm . '2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('A1:' . $highestColumm . '2')->getFont()->setSize(16);

        for ($column = 'A'; $column <= $highestColumm; $column++) {
            $this->excel->getActiveSheet()->getStyle('A3:' . $highestColumm . '3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('A3:' . $highestColumm . '3')->getFont()->setSize(15);
            $this->excel->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
        }

        for ($row = '4'; $row <= $highestRow; $row++) {
            for ($column = 'A'; $column <= $highestColumm; $column++) {
                $this->excel->getActiveSheet()->getStyle('A' . $row . ':' . $highestColumm . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('A' . $row . ':' . $highestColumm . $row)->getFont()->setSize(12);
                $this->excel->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
            }
        }
        $filename = 'part_name.xls';

//        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream; charset=UTF-8LE");
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
        ob_end_clean();
        ob_start();
        $objWriter->save('php://output');
        exit;
	}
	
	public function download_part_name_serial()
    {
        // ini_set('max_execution_time', 300); //300 seconds = 5 minutes
        set_time_limit(0);

        $this->load->library('excel');

        $this->excel->createSheet();
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getSheet(0)->setTitle("Part Numbers");
        $this->data['part_name_serial'] = $this->products->get_part_name_serial();
        // pr($this->data['part_numbers']);die;
		$data1 = ["0" => ['part' => "Part Number",
                'name' => "Name",
                'serial' => "Serial Number",
                'status' => "Status"
                ]];
        foreach ($this->data['part_name_serial'] as $result) {
			$data1[] = ['part' => $result['part'],
			'name' => $result['name'],
			'serial' => $result['serial'],
			'status' => $result['status']
		];
        }

        $this->excel->getActiveSheet()->fromArray($data1, null, 'A3');
        $highestColumm = $this->excel->getActiveSheet()->getHighestColumn();
        $highestRow = $this->excel->getActiveSheet()->getHighestRow();
        $this->excel->getActiveSheet()->setCellValue('A1', 'Part Numbers With Serial Numbers and Status');
        $this->excel->getActiveSheet()->mergeCells('A1:' . $highestColumm . '2');
        $this->excel->getActiveSheet()->getStyle('A1:' . $highestColumm . '2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $this->excel->getActiveSheet()->getStyle('A1:' . $highestColumm . '2')->getFont()->setSize(16);

        for ($column = 'A'; $column <= $highestColumm; $column++) {
            $this->excel->getActiveSheet()->getStyle('A3:' . $highestColumm . '3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('A3:' . $highestColumm . '3')->getFont()->setSize(15);
            $this->excel->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
        }

        for ($row = '4'; $row <= $highestRow; $row++) {
            for ($column = 'A'; $column <= $highestColumm; $column++) {
                $this->excel->getActiveSheet()->getStyle('A' . $row . ':' . $highestColumm . $row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('A' . $row . ':' . $highestColumm . $row)->getFont()->setSize(12);
                $this->excel->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
            }
        }
        $filename = 'part_name_serial.xls';

//        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream; charset=UTF-8LE");
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
        ob_end_clean();
        ob_start();
        $objWriter->save('php://output');
        exit;
    }

}
