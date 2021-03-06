<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
  | -------------------------------------------------------------------------
  | URI ROUTING
  | -------------------------------------------------------------------------
  | This file lets you re-map URI requests to specific controller functions.
  |
  | Typically there is a one-to-one relationship between a URL string
  | and its corresponding controller class/method. The segments in a
  | URL normally follow this pattern:
  |
  |	example.com/class/method/id/
  |
  | In some instances, however, you may want to remap this relationship
  | so that a different class/function is called than the one
  | corresponding to the URL.
  |
  | Please see the user guide for complete details:
  |
  |	https://codeigniter.com/user_guide/general/routing.html
  |
  | -------------------------------------------------------------------------
  | RESERVED ROUTES
  | -------------------------------------------------------------------------
  |
  | There are three reserved routes:
  |
  |	$route['default_controller'] = 'welcome';
  |
  | This route indicates which controller class should be loaded if the
  | URI contains no data. In the above example, the "welcome" class
  | would be loaded.
  |
  |	$route['404_override'] = 'errors/page_missing';
  |
  | This route will tell the Router which controller/method to use if those
  | provided in the URL cannot be matched to a valid route.
  |
  |	$route['translate_uri_dashes'] = FALSE;
  |
  | This is not exactly a route, but allows you to automatically route
  | controller and method names that contain dashes. '-' isn't a valid
  | class or method name character, so it requires translation.
  | When you set this option to TRUE, it will replace ALL dashes in the
  | controller and method URI segments.
  |
  | Examples:	my-controller/index	-> my_controller/index
  |		my-controller/my-method	-> my_controller/my_method
 */
$route['default_controller'] = 'dashboard';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['admin'] = 'admin/user';

$route['admin/login'] = 'login';
$route['admin/logout'] = 'login/logout';
$route['logout'] = 'login/logout';
$route['dashboard/edit_profile'] = 'dashboard/edit_profile';
$route['dashboard/change_password'] = 'dashboard/change_password';

$route['admin/receiving/temporary_product'] = 'receiving/temporary_product';
$route['admin/receiving/find_product'] = 'receiving/find_product';
$route['admin/receiving/ajax_list'] = 'receiving/ajax_list';
$route['admin/receiving/search'] = 'receiving/search';
$route['admin/receiving/dock_receive'] = 'receiving/dock_receive';
$route['admin/receiving/dockPagination/(:any)'] = 'receiving/dockPagination/$1';
$route['admin/receiving/add_inspection_notes'] = 'receiving/add_inspection_notes';
$route['admin/receiving/quick_receive'] = 'receiving/quick_receive';
$route['admin/receiving/quick_receive_barcodes'] = 'receiving/quick_receive_barcodes';
$route['admin/receiving/print_labels'] = 'receiving/print_labels';
$route['admin/receiving/clear_session_data'] = 'receiving/clear_session_data';
$route['admin/receiving/detail_receipt'] = 'receiving/detail_receipt';
$route['admin/receiving/find_serial_details'] = 'receiving/find_serial_details';

$route['testing/add_notes'] = 'receiving/add_notes';
$route['repair/notebook'] = 'testing/notebook';
$route['cleaning/notebook'] = 'testing/notebook';
$route['admin/cleaning/packout'] = 'cleaning/packout';
$route['packing/notebook'] = 'testing/notebook';

$route['admin/temporary_product_review'] = 'receiving/temporary_product_flagged';
$route['admin/temporary_product_review/ajaxPaginationData/(:any)'] = 'receiving/ajaxPaginationData/$1';
$route['admin/temporary_product/approve/(:any)'] = 'receiving/approve/$1';
$route['admin/temporary_product/request_clarification/(:any)'] = 'receiving/request_clarification/$1';
$route['admin/temporary_products/view/(:any)'] = 'products/view/$1';
$route['admin/temporary_products/edit/(:any)'] = 'receiving/temporary_product_edit/$1';
$route['temporary_products/edit/(:any)'] = 'receiving/temporary_product_edit/$1';

$route['admin/products'] = 'products';
$route['admin/products/edit/(:any)'] = 'receiving/temporary_product_edit/$1';
$route['products/edit/(:any)'] = 'receiving/temporary_product_edit/$1';
$route['admin/products/view/(:any)'] = 'products/view/$1';
$route['admin/products/product_serial/(:any)'] = 'products/product_serial/$1';
$route['admin/products/ajax_list'] = 'products/ajax_list';
$route['admin/products/upload_products'] = 'products/upload_products';
$route['admin/products/find_product'] = 'products/find_product';
$route['admin/products/ajaxPaginationData/(:any)'] = 'products/ajaxPaginationData/$1';
$route['admin/receiving/product_actions'] = 'receiving/product_actions';
$route['admin/products/view/(:any)'] = 'products/view/$1';

$route['admin/barcode/generate_barcodes'] = 'barcode/generate_barcodes';
$route['admin/barcode/generate'] = 'barcode/generate';
$route['admin/barcode/mtest'] = 'barcode/mtest';
$route['admin/barcode'] = 'barcode';
$route['admin/barcode/pallet_labels'] = 'barcode/pallet_labels';
$route['admin/barcode/get_sub_category'] = 'barcode/get_sub_category';
$route['admin/barcode/location_print/(:any)'] = 'barcode/location_print/$1';
$route['admin/barcode/print_labels_barcode'] = 'barcode/print_labels_barcode';
$route['admin/barcode/print_preview'] = 'barcode/print_preview';
$route['admin/barcode/dup_index'] = 'barcode/dup_index';
$route['admin/barcode/print_pallet_labels_barcode'] = 'barcode/print_pallet_labels_barcode';
$route['admin/barcode/utility'] = 'barcode/utility';
$route['admin/barcode/print_utility'] = 'barcode/print_utility';
$route['admin/barcode/print_serial'] = 'barcode/print_serial';

$route['admin/roles/edit/(:any)'] = 'admin/roles/add/$1';
$route['admin/user/edit/(:any)'] = 'admin/user/add/$1';
$route['admin/user/edit_profile'] = 'admin/user/edit_profile';
$route['admin/user/change_password'] = 'admin/user/change_password';
$route['admin/products/delete/(:any)'] = 'products/delete/$1';
$route['admin/inventory/locations'] = 'locations';
$route['admin/inventory/locations/ajaxPaginationData/(:any)'] = 'locations/ajaxPaginationData/$1';
$route['admin/inventory/locations/create_location'] = 'locations/create_location';
$route['admin/inventory/locations/assign_location'] = 'locations/assign_location';
$route['admin/inventory/locations/move_location'] = 'locations/move_location';
$route['admin/inventory/location_master'] = 'locations/master';
$route['inventory/location_master'] = 'locations/master';
$route['admin/locations/get_serial_part_by_pallet'] = 'locations/get_serial_part_by_pallet';

$route['admin/testing/get_accessories'] = 'testing/get_accessories';
$route['admin/testing/notebook'] = 'testing/notebook';
$route['admin/testing/desktop'] = 'testing/desktop';
$route['admin/testing/thin_client'] = 'testing/thin_client';
$route['admin/testing/all_in_one'] = 'testing/all_in_one';
$route['admin/testing/tablet'] = 'testing/tablet';
$route['admin/testing/monitor'] = 'testing/monitor';
$route['admin/testing/accessory'] = 'testing/accessory';
$route['admin/testing/printer'] = 'testing/printer';
$route['admin/testing/other_item'] = 'testing/other_item';
$route['admin/testing/audit'] = 'testing/audit';
$route['admin/testing/quality'] = 'testing/quality';
$route['admin/testing/repair'] = 'testing/repair';
$route['admin/testing/view_notes/(:any)'] = 'testing/view_notes/$1';
$route['admin/testing/check_location'] = 'testing/check_location';
$route['admin/testing/check_serial'] = 'testing/check_serial';
$route['admin/testing/check_part'] = 'testing/check_part';
$route['admin/testing/serial_exists'] = 'testing/serial_exists';
$route['admin/testing/find_product'] = 'testing/find_product';
$route['admin/testing/edit_audit_record/(:any)'] = 'testing/edit_audit_record/$1';
$route['admin/testing/delete/(:any)'] = 'testing/delete/$1';

$route['admin/inventory/picking'] = 'picking';
$route['admin/inventory/picking/order_list'] = 'picking/order_list';
$route['admin/inventory/picking/part/(:any)'] = 'picking/get_details_by_part/$1';
$route['admin/inventory/picking/scan_serial'] = 'picking/scan_serial';
$route['admin/inventory/picking/manage_order'] = 'picking/manage_order';
$route['admin/inventory/picking/complete-order/(:any)'] = 'picking/complete_order/$1';
$route['admin/inventory/picking/delete-order'] = 'picking/delete_order';

$route['admin/shipping/picking'] = 'picking';
$route['admin/shipping/picking/order_list'] = 'picking/order_list';
$route['admin/shipping/picking/part/(:any)'] = 'picking/get_details_by_part/$1';
$route['admin/shipping/picking/scan_serial'] = 'picking/scan_serial';
$route['admin/shipping/picking/manage_order'] = 'picking/manage_order';
$route['admin/shipping/picking/complete-order/(:any)'] = 'picking/complete_order/$1';
$route['admin/shipping/picking/delete-order'] = 'picking/delete_order';

$route['admin/shipping'] = 'shipping';
$route['admin/shipping/order_list'] = 'shipping/order_list';
$route['admin/shipping/part/(:any)'] = 'shipping/get_details_by_part/$1';
$route['admin/shipping/scan_serial'] = 'shipping/scan_serial';
$route['admin/shipping/manage_order'] = 'shipping/manage_order';
$route['admin/shipping/complete-order/(:any)'] = 'shipping/complete_order/$1';
$route['admin/shipping/delete-order'] = 'shipping/delete_order';
$route['admin/shipping/view_order_notes/(:any)'] = 'shipping/view_order_notes/$1';
$route['admin/shipping/view_pick_notes/(:any)'] = 'shipping/view_pick_notes/$1';
$route['admin/shipping/add_notes/(:any)'] = 'shipping/add_notes/$1';
$route['admin/shipping/shipments'] = 'shipping/shipments';
$route['admin/shipping/mark-as-shipped'] = 'shipping/mark_orders_shipped';
$route['admin/shipping/view-order/(:any)'] = 'shipping/view_order/$1';
$route['admin/shipping/manage_serial_scan'] = 'shipping/manage_serial_scan';
$route['admin/shipping/remove_serial'] = 'shipping/remove_serial';

$route['admin/inventory/master_sheet'] = 'master_sheet';
$route['admin/inventory/master_sheet/ajaxPaginationData/(:any)'] = 'master_sheet/ajaxPaginationData/$1';
$route['admin/inventory/master_sheet/view_notes/(:any)'] = 'master_sheet/view_notes/$1';
$route['admin/inventory/master_sheet/view_specs/(:any)'] = 'master_sheet/view_specs/$1';
$route['admin/inventory/reports'] = 'reports';
$route['admin/inventory/reports/hp_report'] = 'reports/hp_report';
$route['admin/inventory/reports/ajaxPaginationData/(:any)'] = 'reports/ajaxPaginationData/$1';
$route['admin/inventory/reports/hp_report/(:any)'] = 'reports/hp_report/$1';
$route['admin/inventory/reports/reports_results'] = 'reports/reports_results';
$route['admin/inventory/reports/tech_reports'] = 'reports/tech_reports';
$route['admin/inventory/reports/download_part_numbers'] = 'reports/download_part_numbers';
$route['admin/inventory/reports/download_part_name_serial'] = 'reports/download_part_name_serial';
$route['admin/inventory/create_pallet'] = 'create_pallet';
$route['admin/inventory/create_pallet/print_contents'] = 'create_pallet/print_contents';
$route['admin/inventory/create_pallet/print_labels'] = 'create_pallet/print_labels';
$route['admin/inventory/utility'] = 'utility';
$route['admin/inventory/utility/find_product'] = 'utility/find_product';
$route['admin/inventory/utility/generate_serial'] = 'utility/generate_serial';
$route['admin/inventory/utility/scan_location'] = 'utility/scan_location';

$route['admin/sales/dashboard'] = 'sales';
$route['admin/sales/ajaxPaginationData/(:any)'] = 'sales/ajaxPaginationData/$1';
$route['admin/sales/flag_item'] = 'sales/flag_item';
$route['admin/sales/remove_flag_item'] = 'sales/remove_flag_item';