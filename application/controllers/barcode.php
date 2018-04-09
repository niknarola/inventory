<?php
require_once APPPATH . 'libraries/barcode/BCGFontFile.php';
require_once APPPATH . 'libraries/barcode/BCGColor.php';
require_once APPPATH . 'libraries/barcode/BCGDrawing.php';
require_once APPPATH . "libraries/barcode/BCGcode128.php";

class Barcode extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->uri->segment(1) == 'admin' && !$this->session->userdata('admin_validated')) {
            redirect('admin/login');
        } else if ($this->uri->segment(1) == 'barcode' && !$this->session->userdata('user_validated')) {
            redirect('login');
        }
        $this->load->model('Product_model', 'product');
        if ($this->uri->segment(1) == 'admin') {
            $this->layout = 'admin/admin_layout';
            $this->admin_prefix = 'admin/';
        } else {
            $this->layout = 'layout';
            $this->admin_prefix = '';
        }
    }

    public function index()
    {
        $text = rawurldecode($this->input->get('text'));
        $barcode = rawurldecode($this->input->get('barcode'));
        $scale = $this->input->get('scale') ? $this->input->get('scale') : 1;
        $thickness = $this->input->get('thickness') ? $this->input->get('thickness') : 30;
        $font = new BCGFontFile(APPPATH . 'libraries/barcode/font/ArialBold.ttf', 12);
        $color_black = new BCGColor(0, 0, 0);
        $color_white = new BCGColor(255, 255, 255);

        // Barcode Part
        $code = new BCGcode128();
        $code->setScale($scale);
        $code->setThickness($thickness);
        $code->setForegroundColor($color_black);
        $code->setBackgroundColor($color_white);
        $code->setFont($font);
        $code->setLabel($text);
        $code->setStart(null);
        $code->setTilde(true);
        $code->parse($barcode);

        // Drawing Part
        $drawing = new BCGDrawing('', $color_white);
        $drawing->setBarcode($code);
        $drawing->draw();
        header('Content-Type: image/png');
        //$drawing->setFilename('assets/images/barcode/'.$text.'.png');
        $drawing->finish(BCGDrawing::IMG_FORMAT_PNG);
    }

    public function dup_index($pallet_id)
    {
        //echo $pallet_id; die;
        $text = $barcode = rawurldecode($pallet_id);
        $scale = 2.4;
        $thickness = 30;
        $font = new BCGFontFile(APPPATH . 'libraries/barcode/font/ArialBold.ttf', 12);
        $color_black = new BCGColor(0, 0, 0);
        $color_white = new BCGColor(255, 255, 255);

        // Barcode Part
        $code = new BCGcode128();
        $code->setScale($scale);
        $code->setThickness($thickness);
        $code->setForegroundColor($color_black);
        $code->setBackgroundColor($color_white);
        $code->setFont($font);
        $code->setLabel($text);
        $code->setStart(null);
        $code->setTilde(true);
        $code->parse($barcode);

        // Drawing Part
        $drawing = new BCGDrawing('', $color_white);
        $drawing->setBarcode($code);
        $drawing->draw();
        //header('Content-Type: image/png');
        $drawing->setFilename('assets/images/barcode/' . $text . '.png');
        $drawing->finish(BCGDrawing::IMG_FORMAT_PNG);
    }

    public function generate_barcodes()
    {
        $data['ajax_url'] = ($this->uri->segment(1) == 'admin') ? 'admin/receiving/find_product' : 'receiving/find_product';
        $data['cat_url'] = ($this->uri->segment(1) == 'admin') ? 'admin/barcode/get_sub_category' : 'barcode/get_sub_category';
        $data['product_line'] = $this->product->get_key_value_pair('product_line');
        $category_names = $this->product->get_categories();
        $data['categories'] = $category_names;
        $data['title'] = 'Generate Barcode';
        $this->template->load($this->layout, 'barcode/generate_barcode', $data);
    }
    public function get_sub_category()
    {
        $cat_id = $this->input->post('category_id');
        $subcats = $this->product->get_sub_categories($cat_id);
        $html = '';
        $result = 0;
        if (!empty($subcats)) {
            $result = 1;
            $html = '<option value="">Select</option>';
            foreach ($subcats as $key => $value) {
                $html .= '<option value="' . $key . '">' . $value . '</option>';
            }
        }
        $res = [
            'html_text' => $html,
            'result' => $result,
        ];
        echo json_encode($res);
        exit;
    }
    public function generate()
    {
        if ($this->input->post()) {
            $data = $this->input->post();

            $this->load->model('Basic_model', 'basic');
            if (array_key_exists('add_item_to_inventory', $this->input->post())) {
                if ($this->input->post('product_id') != '') {
                    $stored_serials = $this->product->get_serials_by_product_id($this->input->post('product_id'));
                    foreach ($this->input->post('serial') as $serial) {
                        if (!in_array($serial, $stored_serials)) {
                            $insert_data = [
                                'serial' => $serial,
                                'product_id' => $this->input->post('product_id'),
                            ];
                            $this->basic->insert('product_serials', $insert_data);
                        }
                    }
                } else {
                    $category = [];
                    $category[] = $this->input->post('category1');
                    if ($this->input->post('category2')) {
                        $category[] = $this->input->post('category2');
                    }
                    if ($this->input->post('category3')) {
                        $category[] = $this->input->post('category3');
                    }
                    for ($i = 0; $i < sizeof($data['categories']); $i++) {
                        $data['categories'][$i] = get_category_name(json_encode($category));
                    }
                    $product_data = [
                        'part' => $this->input->post('part')[0],
                        'name' => $this->input->post('name')[0],
                        'description' => $this->input->post('description')[0],
                        // 'original_condition_id'=>$this->input->post('original_condition_id'),
                        'product_line_id' => $this->input->post('product_line')[0],
                        // 'release_date'=>$this->input->post('release_date'),
                        'status' => 0,
                        'category' => json_encode($category),
                        'added_as_temp' => 1,
                        'product_added_by' => $this->session->userdata('id'),
                    ];
                    if ($this->basic->insert('products', $product_data)) {
                        $id = $this->db->insert_id();
                        foreach ($this->input->post('serial') as $ser) {
                            $serial_data = [
                                'serial' => $ser,
                                'product_id' => $id,
                            ];
                            $this->basic->insert('product_serials', $serial_data);
                        }
                    }
                }
            }
            /*$description = [];
            foreach ($data['part'] as $part) {
            $description[] = $this->product->get_product_desc($part);
            }
            $data['description'] = $description;*/
            $data['product_line_names'] = $this->product->get_key_value_pair('product_line');
            $data['title'] = 'Generated Barcodes';
            // $this->load->view('barcode/generated_barcodes', $data);
            $this->template->load($this->layout, 'barcode/generated_barcodes', $data);
        }
    }
    public function location_print($location)
    {
        $data['title'] = "Location Barcode";
        $this->load->model('Locations_model', 'location');
        $data['location'] = $this->location->get_location_name($location);
        $this->template->load($this->layout, 'barcode/location_barcode', $data);
    }
    public function pallet_labels()
    {
        $print_labels = $this->session->userdata('pallet_print_data');
        $data['print_labels'] = $print_labels;
        $data['title'] = 'Pallet Labels';
        $data['admin_prefix'] = $this->admin_prefix;
        $this->template->load($this->layout, 'barcode/pallet_labels', $data);
    }
    public function print_labels_barcode()
    {
        $data['title'] = 'Print Labels';
        $print_labels = [];
        $data['admin_prefix'] = $this->admin_prefix;

        if ($this->input->post()) {
            $print_labels = $this->input->post();
        }
        $data['print_labels'] = $print_labels;

        $this->template->load($this->layout, 'barcode/print_labels_barcode', $data);
    }

    public function print_preview()
    {
        $print_labels = $this->session->userdata('pallet_print_data');
        foreach ($print_labels as $k => $v) {
            $this->dup_index(rawurlencode($v['pallet_id']));
        }
        $data['print_labels'] = $print_labels;
        $data['title'] = 'Pallet Labels';
        $data['admin_prefix'] = $this->admin_prefix;
        $pdf_print = $this->load->view('barcode/print_preview', $data, true);
        $file_path = 'assets/images/barcode/' . time() . '.pdf';
        $this->load->library('m_pdf');
        $this->m_pdf->pdf->WriteHTML($pdf_print);
        $this->m_pdf->pdf->Output($file_path, 'F');
        $data['file_path'] = $file_path;
        $this->template->load($this->layout, 'barcode/pallet_labels', $data);
	}

	public function print_pallet_labels_barcode()
	{
		$print_labels = $this->session->userdata('pallets_new');
        foreach ($print_labels as $k => $v) {
            $this->dup_index(rawurlencode($v));
        }
		$data['print_labels'] = $print_labels['pallet_id'];
		// pr($data['print_labels']);die;
        $data['title'] = 'Print Pallet Labels';
        $data['admin_prefix'] = $this->admin_prefix;
		$pdf_print = $this->load->view('barcode/create_pallet_barcode', $data, true);
		// echo $pdf_print;die;
        $file_path = 'assets/images/barcode/' . time() . '.pdf';
        $this->load->library('m_pdf');
        $this->m_pdf->pdf->WriteHTML($pdf_print);
        $this->m_pdf->pdf->Output($file_path, 'F');
        $data['file_path'] = $file_path;
		$this->template->load($this->layout, 'barcode/print_labels_barcode', $data);
	}
	// public function utility(){
	// 	$data['title'] = 'Print INK';
	// 	$print_labels = [];
	// 	$print_labels = $this->session->userdata('utility');
	// 	$data['print_labels'] = $print_labels;
	// 	// pr($print_labels);die;
	// 	$this->template->load($this->layout, 'barcode/print_utility', $data);
	// }

	public function utility(){
		$print_labels = $this->session->userdata('utility');
		pr($print_labels);die;
        foreach ($print_labels as $k => $v) {
            $this->dup_index(rawurlencode($v['pallet_id']));
        }
        $data['print_labels'] = $print_labels;
        $data['title'] = 'Print INK';
        $data['admin_prefix'] = $this->admin_prefix;
        $pdf_print = $this->load->view('barcode/print_ink_label', $data, true);
        $file_path = 'assets/images/barcode/' . time() . '.pdf';
        $this->load->library('m_pdf');
        $this->m_pdf->pdf->WriteHTML($pdf_print);
        $this->m_pdf->pdf->Output($file_path, 'F');
        $data['file_path'] = $file_path;
        $this->template->load($this->layout, 'barcode/print_utility', $data);
	}
}
