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
        $data['ajax_url'] = ($this->session->userdata('admin_validated')) ? 'admin/shipping/picking/order_list' : 'picking/order_list';
        $orders = array();
        $items = array();
        $items1 = array();
        $items1[] = array(
            "orderItemId" => 235472045,
            "lineItemKey" => 222737261203,
            "sku" => "F9D31AA-B",
            "name" => "HP laptop",
            "imageUrl" => "https://i.ebayimg.com/00/s/MTUwMFgxNTAw/z/,rPAAAOSwl9RaHtWo/$57.JPG?set_id=8800005007",
            "weight" => Array(
                "value" => 0,
                "units" => "ounces",
                "WeightUnits" => 1,
            ),
            "quantity" => 2,
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
        $items[] = array(
            "orderItemId" => 235472086,
            "lineItemKey" => 222737261203,
            "sku" => "M9B55A-NEW",
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
        $items[] = array(
            "orderItemId" => 235472087,
            "lineItemKey" => 222737276803,
            "sku" => "P3L85A-B",
            "name" => "HP OfficeJet Pro 8721",
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
        $orders[1] = Array(
            "orderId" => 175009865,
            "orderNumber" => 65145,
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
            "items" => $items1,
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
//        $shipstation_authorization_key = 'Basic YmI3MTc5OTE0ZmYyNDYyNzk4OTg2YWJmZWJhMmY0NjM6MWM0MzM1ZmU5NWRmNDQxNjllYmNlOWQyNmJjYjgxMTY=';
//        $ch = curl_init();
//
//        curl_setopt($ch, CURLOPT_URL, "https://ssapi.shipstation.com/orders?orderStatus=awaiting_shipment");
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
//        curl_setopt($ch, CURLOPT_HEADER, FALSE);
//
//        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//            "Authorization: " . $shipstation_authorization_key
//        ));
//
//        $response = curl_exec($ch);
//        curl_close($ch);
//        $result = json_decode($response, true);
//        
//        $orders = $result['orders'];
//        pr($orders);
//        exit;
        foreach ($orders as $key => $val) {
            $order_details = $this->picking->get_order_details($val['orderNumber']);
            if (!empty($order_details)) {
                $order_status = $order_details['order_status'];
            } else {
                $order_status = 0;
            }
            if ($order_status == 0) {
                $order[$key] = $val;
                $storeId = $val['advancedOptions']['storeId'];
                if ($storeId == AMAZON) {
                    $store = "Amazon";
                } elseif ($storeId == ExcessBuy) {
                    $store = 'ExcessBuy';
                }
                $order[$key]['order_details'] = '';

                $order[$key]['store'] = $store;
                $order[$key]['order_id'] = $val['orderId'];
                $order[$key]['order_number'] = $val['orderNumber'];
                $order[$key]['qty_cnt'] = 0;
                foreach ($val['items'] as $it) {
                    $order[$key]['qty_cnt'] = $order[$key]['qty_cnt'] + $it['quantity'];
                }
                $order[$key]['items'] = $val['items'];
            }
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
        $url = ($this->session->userdata('admin_validated')) ? 'admin/shipping/locations/ajaxPaginationData' : 'locations/ajaxPaginationData';
        $data['url'] = $url;
        $data['ajax_url'] = ($this->session->userdata('admin_validated')) ? 'admin/shipping/locations' : 'locations';
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

    public function get_details_by_part($part_number) {
        $data['title'] = 'Part Locations';
        $data['details'] = $this->picking->get_details_by_part($part_number);
        $data['part'] = $part_number;
        $data['part_details'] = $this->basic->get_single_data_by_criteria('products', ['part' => $part_number]);
        $this->template->load($this->layout, 'picking/part_locations', $data);
    }

    public function get_all_data_by_criteria($order_number) {
        $order_items = $this->basic->get_all_data_by_criteria('order_items', ['order_number' => $order_number]);
        return $order_items;
    }

    public function scan_serial() {
        $postdata = $this->input->post();
        $serial = $postdata['serial'];
        $part = $postdata['part'];
        $order_number = $postdata['order_number'];
        $order_id = $postdata['orderid'];
        $response['partmatch'] = 0;
        $isserialexist = $this->basic->is_serial_exists($serial);
        if (empty($isserialexist)) {
            $data['serial'] = $serial;
            $data['isserialexist'] = 0;
        } elseif ($isserialexist['status'] == "Sold" || $isserialexist['status'] == "sold") {
            $data['serial'] = $serial;
            $data['isserialexist'] = 1;
            $data['serial_status'] = "sold";
        } else {
            $findpart = $this->picking->get_part_by_serial($serial);
            $actual_part = $findpart['part'];
//            $actual_part = "F9D31AA#ABA";
            $n = 1;
            $pieces = explode('#', $actual_part);
            if (count($pieces) > 1) {
                $part1 = implode('#', array_slice($pieces, 0, $n));
                $part2 = $pieces[$n];
            } else {
                $part1 = $actual_part;
                $part2 = '';
            }
            
            $actual_serial_part = $part1;
            if (rtrim($part) == rtrim($actual_serial_part)) {
                $data['partmatch'] = 1;
                $data['part'] = $actual_serial_part;
                $data['order_number'] = $order_number;
                $data['orderId'] = $order_id;
                $data['serial'] = $serial;
                $data['isserialexist'] = 1;
            } else {
                $data['partmatch'] = 0;
                $data['part'] = $part;
                $data['order_number'] = $order_number;
                $data['orderId'] = $order_id;
                $data['serial'] = $serial;
                $data['isserialexist'] = 1;
            }
        }
        echo json_encode($data);
        exit;
    }

    public function get_order_item_detail($order_item_id) {
        $order_item_detail = $this->picking->get_order_item_detail($order_item_id);
        return $order_item_detail;
    }

    public function manage_order() {
        $postdata = $this->input->post();
        $no_need_to_scan = $postdata['no_need_scan'];
        if ($no_need_to_scan == 1) {
            $order_data = array(
                'site' => $postdata['scanned_store'],
                'order_number' => $postdata['scanned_order'],
                'name' => $postdata['scanned_product_name'],
                'order_item_id' => $postdata['scanned_order_item_id'],
                'part' => $postdata['scanned_part'],
                'additional_part_info' => $postdata['scanned_additional_part_info'],
                'quantity' => 1, // need to check for values.
                'order_item_status' => 1,
                'no_need_to_scan' => 1,
//                'order_notes' => '',
//                'pick_notes' => '',
            );
        } else {
            $order_data = array(
                'site' => $postdata['scanned_store'],
                'order_number' => $postdata['scanned_order'],
                'name' => $postdata['scanned_product_name'],
                'order_item_id' => $postdata['scanned_order_item_id'],
                'serial' => $postdata['scanned_serial'],
                'part' => $postdata['scanned_part'],
                'additional_part_info' => $postdata['scanned_additional_part_info'],
                'quantity' => 1, // need to check for values.
                'order_item_status' => 1,
//                'order_notes' => '',
//                'pick_notes' => '',
            );

            $update_serial_arr = array(
                'status' => "Sold",
            );
        }
        $insert = $this->basic->insert("order_items", $order_data);
        if ($insert > 0) {
            if ($no_need_to_scan == 1) {
                $this->session->set_flashdata('success', 'Changes made successfully.');
            } else {
                $update_serial = $this->picking->serial_update($update_serial_arr, $postdata['scanned_serial']);
                $this->session->set_flashdata('success', 'You have successfully accepted this item.');
            }
        } else {
            $this->session->set_flashdata('error', 'Something went wrong! Please try again.');
        }
        redirect(site_url('admin/shipping/picking'), 'refresh');
    }

    public function complete_order($order_number) {
        $order_number = base64_decode($order_number);
        $postdata = $this->input->post();
        $order_data = array(
            'site' => $postdata['scanned_store'],
            'order_number' => $postdata['scanned_order'],
            'order_id' => $postdata['scanned_order_id'],
            'quantity' => $postdata['scanned_order_total_qty'],
            'order_status' => 1,
        );
        $insert = $this->basic->insert("orders", $order_data);
        if ($insert > 0) {
            $this->session->set_flashdata('success', 'You have successfully completed the order.');
            $data['success'] = 1;
        } else {
            $this->session->set_flashdata('error', 'Something went wrong! Please try again.');
            $data['success'] = 0;
        }
        echo json_encode($data);
        exit;
    }

    public function delete_order() {
        $postdata = $this->input->post();
        $orders = $postdata;
        foreach ($orders['orders'] as $order) {
            if (!empty($order) && $order > 0) {
//                $shipstation_authorization_key = 'Basic YmI3MTc5OTE0ZmYyNDYyNzk4OTg2YWJmZWJhMmY0NjM6MWM0MzM1ZmU5NWRmNDQxNjllYmNlOWQyNmJjYjgxMTY=';
//                $ch = curl_init();
//
//                curl_setopt($ch, CURLOPT_URL, "https://ssapi.shipstation.com/orders/".$order);
//                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
//                curl_setopt($ch, CURLOPT_HEADER, FALSE);
//
//                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//                    "Authorization: " . $shipstation_authorization_key
//                ));
//
//                $response = curl_exec($ch);
//                curl_close($ch);
//                $result = json_decode($response, true);
//
//                $orders = $result['orders'];
                $order_data = array(
                    'is_delete' => 1,
                );
                $isorderexist = $this->basic->get_single_data_by_criteria("orders", ['order_id' => $order]);
                if ($isorderexist) {
                    $update = $this->basic->update("orders", $order_data, ['order_id' => $order]);
                }
                if ($update) {
                    $this->session->set_flashdata('success', 'You have successfully deleted selected orders.');
                    $data['success'] = 1;
                } else {
                    $this->session->set_flashdata('error', 'Something went wrong! Please try again.');
                    $data['success'] = 0;
                }
            }
        }
        echo json_encode($data);
        exit;
    }

}
