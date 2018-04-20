<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Picking extends CI_Controller {

    public $layout = '';

    public function __construct() {
        parent::__construct();
        $this->load->library('Ajax_pagination');
        $this->perPage = 10;
        $this->load->model('Product_model', 'products');
        $this->load->model('Basic_model', 'basic');
        $this->load->model('Picking_model', 'picking');
        $this->load->model('Locations_model', 'location');
        if ($this->uri->segment(1) == 'admin' && !$this->session->userdata('admin_validated')) {
            redirect('admin/login');
        } else if ($this->uri->segment(1) != 'admin' && !$this->session->userdata('user_validated')) {
            redirect('login');
        }
        if ($this->uri->segment(1) == 'admin') {
            $this->layout = 'admin/admin_layout';
            $this->admin_prefix = 'admin/';
        } else {
            $this->layout = 'layout';
            $this->admin_prefix = '';
        }
    }

    public function index() {
        $data = array();
        $data['title'] = 'Picking';
        $data['admin_prefix'] = $this->admin_prefix;
        $data['ajax_url'] = ($this->session->userdata('admin_validated')) ? 'admin/inventory/picking/order_list' : 'picking/order_list';
        $orders = array();
        $items = array();
        $items[] = array(
            "orderItemId" => 235472086,
            "lineItemKey" => 222737261203,
            "sku" => "M9L75A-B",
            "name" => "HP OfficeJet Pro 8720 All-in-One Printer (M9L75A) + Ink Bonus",
            "imageUrl" => "https://i.ebayimg.com/00/s/MTUwMFgxNTAw/z/,rPAAAOSwl9RaHtWo/$57.JPG?set_id=8800005007",
            "weight" => Array(
                "value" => 0,
                "units" => "ounces",
                "WeightUnits" => 1,
            ),
            "quantity" => 1,
            "unitPrice" => 134.99,
            "taxAmount" => 0,
            "shippingAmount" => "",
            "warehouseLocation" => "",
            "options" => Array(),
            "productId" => 19833959,
            "fulfillmentSku" => "",
            "adjustment" => "",
            "upc" => "",
            "createDate" => "2017-12-06T10:22:18.487",
            "modifyDate" => "2017-12-06T10:22:18.487",
        );
        $orders[0] = Array(
            "orderId" => 175009899,
            "orderNumber" => 65114,
            "orderKey" => "222737261203-2004950678012",
            "orderDate" => "2017-12-05T11:26:39.0000000",
            "createDate" => "2017-12-06T10:22:17.8430000",
            "modifyDate" => "2017-12-11T04:29:50.2430000",
            "paymentDate" => "2017-12-05T11:26:39.0000000",
            "shipByDate" => "",
            "orderStatus" => "shipped",
            "customerId" => 122735736,
            "customerUsername" => "darren8262",
            "customerEmail" => "dbrown@dbaprime.com",
            "billTo" => Array(
                "name" => "Darren Brown",
                "company" => "",
                "street1" => "",
                "street2" => "",
                "street3" => "",
                "city" => "",
                "state" => "",
                "postalCode" => "",
                "country" => "",
                "phone" => "",
                "residential" => "",
                "addressVerified" => "",
            ),
            "shipTo" => Array(
                "name" => "Darren Brown",
                "company" => "",
                "street1" => "15787 MENTON BAY CT",
                "street2" => "",
                "street3" => "",
                "city" => "DELRAY BEACH",
                "state" => "FL",
                "postalCode" => "33446-9740",
                "country" => "US",
                "phone" => 4073359965,
                "residential" => 1,
                "addressVerified" => "Address validated successfully",
            ),
            "items" => $items,
            "orderTotal" => 134.99,
            "amountPaid" => 134.99,
            "taxAmount" => 0,
            "shippingAmount" => 0,
            "customerNotes" => "",
            "internalNotes" => "",
            "gift" => "",
            "giftMessage" => "",
            "paymentMethod" => "PayPal",
            "requestedShippingService" => "FedExHomeDelivery",
            "carrierCode" => "fedex",
            "serviceCode" => "fedex_home_delivery",
            "packageCode" => "package",
            "confirmation" => "none",
            "shipDate" => "2017-12-05",
            "holdUntilDate" => "",
            "weight" => Array(
                "value" => 0,
                "units" => "ounces",
                "WeightUnits" => 1,
            ),
            "dimensions" => "",
            "insuranceOptions" => Array(
                "provider" => "",
                "insureShipment" => "",
                "insuredValue" => 0,
            ),
            "internationalOptions" => Array(
                "contents" => "",
                "customsItems" => "",
                "nonDelivery" => "",
            ),
            "advancedOptions" => Array(
                "warehouseId" => "",
                "nonMachinable" => "",
                "saturdayDelivery" => "",
                "containsAlcohol" => "",
                "mergedOrSplit" => "",
                "mergedIds" => Array(),
                "parentId" => "",
                "storeId" => 140519,
                "customField1" => "",
                "customField2" => "",
                "customField3" => "",
                "source" => "",
                "billToParty" => "",
                "billToAccount" => "",
                "billToPostalCode" => "",
                "billToCountryCode" => "",
                "billToMyOtherAccount" => "",
            ),
            "tagIds" => "",
            "userId" => "",
            "externallyFulfilled" => "",
            "externallyFulfilledBy" => "",
            "labelMessages" => "",
        );
        $shipstation_authorization_key = 'Basic YmI3MTc5OTE0ZmYyNDYyNzk4OTg2YWJmZWJhMmY0NjM6MWM0MzM1ZmU5NWRmNDQxNjllYmNlOWQyNmJjYjgxMTY=';
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://ssapi.shipstation.com/orders?orderStatus=awaiting_shipment");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Authorization: " . $shipstation_authorization_key
        ));

        $response = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($response, true);

        $orders = $result['orders'];
        foreach ($orders as $key => $val) {
            $order[$key] = $val;
            $storeId = $val['advancedOptions']['storeId'];
            if ($storeId == AMAZON) {
                $store = "Amazon";
            } elseif ($storeId == ExcessBuy) {
                $store = 'ExcessBuy';
            }
            $order[$key]['store'] = $store;
            $order[$key]['order_number'] = $val['orderNumber'];
            $order[$key]['items'] = $val['items'];
        }
//        pr($order);
//        exit;
        $data['orders'] = $order;
        //load the view
        $this->template->load($this->layout, 'picking/index', $data);
    }

    public function order_list() {
//        pr($orders);
//        exit;
        $final = array();
        if (!empty($orders)) {
            $final['recordsTotal'] = count($orders);
            $final['redraw'] = 1;
            $final['recordsFiltered'] = $final['recordsTotal'];
            $start = $this->input->get('start') + 1;

            foreach ($orders as $key => $val) {
                $order[$key] = $val;
                $order[$key]['sr_no'] = $start++;
                $order[$key]['store'] = $val['advancedOptions']['storeId'];
                $order[$key]['order_number'] = $val['orderId'];
            }
            $final['data'] = $order;
        }
        echo json_encode($final);
        exit;
    }

    function ajaxPaginationData() {
        $conditions = array();

        //calc offset number
        $page = $this->input->post('page');
        if (!$page) {
            $offset = 0;
        } else {
            $offset = $page;
        }
        $data['print_url'] = ($this->uri->segment(1) == 'admin') ? 'admin/barcode/location_print' : 'barcode/location_print';
        //set conditions for search
        $keywords = $this->input->post('keywords');
        $searchfor = $this->input->post('searchfor');
        // $sortBy = $this->input->post('sortBy');
        if (!empty($keywords)) {
            $conditions['search']['keywords'] = $keywords;
        }
        if (!empty($searchfor) && $searchfor != 'none') {
            $conditions['search']['searchfor'] = $searchfor;
        }

        //total rows count
        $totalRec = count($this->location->getRows($conditions));

        //pagination configuration
        $config['target'] = '#postList';
        $url = ($this->session->userdata('admin_validated')) ? 'admin/inventory/locations/ajaxPaginationData' : 'locations/ajaxPaginationData';
        $data['url'] = $url;
        $data['ajax_url'] = ($this->session->userdata('admin_validated')) ? 'admin/inventory/locations' : 'locations';
        $config['base_url'] = base_url() . $url;
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['link_func'] = 'searchFilter';
        $config['uri_segment'] = 5;
        $this->ajax_pagination->initialize($config);

        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;

        //get posts data
        $data['posts'] = $this->location->getRows($conditions);
//        pr($data['posts']);
        //load the view
        $this->load->view('locations/ajax-pagination-data', $data, FALSE);
    }

    public function master() {
        $data['title'] = 'Locations Master';
        $this->load->model('Receiving_model', 'receiving');
        $data['pallets'] = $this->receiving->get_key_value_pallets();
        $data['locations'] = $this->basic->get_all_data('locations');
        $data['admin_prefix'] = $this->admin_prefix;
        $data['print_url'] = ($this->uri->segment(1) == 'admin') ? 'admin/barcode/location_print' : 'barcode/location_print';
        if ($this->input->post()) {
            if ($this->input->post('complete')) {
                $pallet_id = $this->input->post('pallet_id');
                $location = $this->basic->get_single_data_by_criteria('locations', array('name' => trim($this->input->post('location'))));
                if (!empty($location)) {
                    // echo"in if";die;
                    $location_id = $location['id'];
                } else {
                    // echo"in else";die;
                    $insert_data = [
                        'name' => trim($this->input->post('location'))
                    ];
                    // pr($insert_data);die;
                    $location_id = $this->basic->insert('locations', $insert_data);
                }
                $ldata = [
                    'location_id' => $location_id
                ];
                if ($this->basic->update('product_serials', $ldata, ['pallet_id' => $pallet_id])) {
                    $product_serial_data = $this->basic->get_all_data_by_criteria('product_serials', ['pallet_id' => $pallet_id]);
                    $timestamp = [
                        'location_assigned_date' => date('Y-m-d H:i:s'),
                        'last_scan' => date('Y-m-d H:i:s')
                    ];
                    foreach ($product_serial_data as $key => $serial_data) {
                        $this->basic->update('serial_timestamps', $timestamp, ['serial_id' => $serial_data['id']]);
                    }
                    $this->session->set_flashdata('msg', 'Locations assigned successfully');
                }
            }
        }
        $this->template->load($this->layout, 'locations/locations_master', $data);
    }

    public function create_location() {
        $location = trim($this->input->post('location'));
        $response = [];
        if ($this->location->check_location_exists($location) > 0) {
            $response['status'] = 0;
            $response['msg'] = 'Location Name already exists';
        } else {
            $data = [
                'name' => $location
            ];
            if ($this->basic->insert('locations', $data)) {
                $response['sql'] = $this->db->last_query();
                $response['status'] = 1;
                $response['msg'] = 'Location added successfully';
            }
        }
        echo json_encode($response);
        exit;
    }

    public function assign_location() {
        $location = trim($this->input->post('location'));
        $serial = trim($this->input->post('serial'));
        $location_id = $this->location->get_location_id($location);
        $response = [];
        if ($location_id != '') {
            $data = [
                'location_id' => $location_id
            ];
            if ($this->basic->update('product_serials', $data, ['serial' => $serial])) {
                $response['status'] = 1;
                $response['msg'] = 'Location assigned successfully';
                $product_serial_data = $this->basic->get_single_data_by_criteria('product_serials', ['serial' => $serial]);
                $timestamp = [
                    'location_assigned_date' => date('Y-m-d H:i:s'),
                    'last_scan' => date('Y-m-d H:i:s')
                ];
                $this->basic->update('serial_timestamps', $timestamp, ['serial_id' => $product_serial_data['id']]);
            }
        } else {
            $response['status'] = 0;
            $response['msg'] = 'Location does not exists';
        }
        echo json_encode($response);
        exit;
    }

    public function move_location() {
        $location = trim($this->input->post('location'));
        $serial = trim($this->input->post('serial'));
        $location_id = $this->location->get_location_id($location);
        $response = [];
        if ($location_id != '') {
            $data = [
                'location_id' => $location_id
            ];
            if ($this->basic->update('product_serials', $data, ['serial' => $serial])) {
                $response['status'] = 1;
                $response['msg'] = 'Location moved successfully';
                $product_serial_data = $this->basic->get_single_data_by_criteria('product_serials', ['serial' => $serial]);
                $timestamp = [
                    'location_assigned_date' => date('Y-m-d H:i:s'),
                    'last_scan' => date('Y-m-d H:i:s')
                ];
                $this->basic->update('serial_timestamps', $timestamp, ['serial_id' => $product_serial_data['id']]);
            }
        } else {
            $response['status'] = 0;
            $response['msg'] = 'Location does not exists';
        }
        echo json_encode($response);
        exit;
    }

    public function get_serial_part_by_pallet() {
        $pallet_id = $this->input->post('pallet');
        $html = '';
        $status = 0;
        $cnt = 0;
        $products = $this->location->get_serial_part_by_pallet($pallet_id);
        if (!empty($products)) {
            $cnt = sizeof($products);
            $status = 1;
            $html = '<table class="table">';
            $html .= '<thead><tr><th>Serial Number</th><th>Part Number</th></tr></thead>';
            $html .= '<tbody>';
            foreach ($products as $key => $value) {
                $html .= '<tr><td>' . $value['serial'] . '</td><td>' . $value['part'] . '</td></tr>';
                // $html .= '<tr><td><input class="form-control" name="serial[]" value="'.$value['serial'].'"></td><td><input class="form-control" name="part[]" value="'.$value['part'].'"></td></tr>';
            }
            $html .= '</tbody>';
            $html .= '</table>';
        }
        $response['products'] = $products;
        $response['status'] = $status;
        $response['html'] = $html;
        $response['cnt'] = $cnt;

        echo json_encode($response);
        exit;
    }

    public function get_details_by_part() {
        $data['title'] = 'Part Locations';
        $data['details'] = $this->picking->get_details_by_part('F9D31AA');
        // pr($data['details']);
        $this->template->load($this->layout, 'picking/part_locations', $data);
    }

}
