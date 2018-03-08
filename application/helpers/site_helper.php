<?php 
/**
 * 	Print array/string.
 * 	@data  = data that you want to print
 * 	@is_die = if true. Excecution will stop after print. 
 * 	Author = Nv
 */
function pr($data, $is_die = false) {
    if (is_object($data)) {
        $data = (array) $data;
    }
    if (is_array($data)) {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    } else {
        echo $data;
    }
    if ($is_die)
        die;
}
function mail_config1() {
    $configs = array(
        'protocol' => 'smtp',
        'smtp_host' => 'ssl://smtp.gmail.com',
        'smtp_user' => 'demo.narola@gmail.com',
        'smtp_pass' => 'Narola21#',
        'smtp_port' => '465',
        'mailtype' => 'html',
        'charset' => 'iso-8859-1',
        //'crlf' => '\r\n',   //should be "\r\n"
        'newline' => "\r\n",   //should be "\r\n"
        'wordwrap' => TRUE,
    );
    return $configs;
}

function mail_config() {
    $configs = array(
        'protocol' => 'smtp',
        'smtp_host' => 'smtp.gmail.com',
        'smtp_port' => 465,
        'smtp_user' => 'hpa.narola1111@gmail.com',
        'smtp_pass' => 'narola21',
        'transport' => 'Smtp',
        'charset' => 'utf-8',
        'newline' => "\r\n",
        'headerCharset' => 'iso-8859-1',
        'smtp_crypto' => 'ssl',
        'mailtype' => 'html'
    );
    return $configs;
}
function get_permissions(){
    $CI =& get_instance();
    $role_id = $CI->session->userdata('role_id');
    $CI->load->model('Role_model');
    $permissions = $CI->Role_model->get_permissions_by_role_id($role_id);
    return $permissions;
}
function get_category_name($cat_json){
    $CI =& get_instance();
    $CI->load->model('Product_model','products');
    $cat_arr = json_decode($cat_json);
    $cat_string = '';
    foreach ($cat_arr as $cat) {
        if(is_array($cat)){
            $subcat = [];
            foreach ($cat as $c) {
                $subcat[] = $CI->products->get_category_name($c);
            }
            $cat_string .= ':'.implode(',', $subcat);
        }else{
            $cat_name = $CI->products->get_category_name($cat);
            $cat_string .= ($cat_string!='') ? ':'.$cat_name : $cat_name; 
        }
    }
    return $cat_string;
}

function get_item_count($location_id){
    $CI =& get_instance();
    $CI->load->model('Locations_model','location');
    $item_count = $CI->location->get_item_count($location_id);
    return $item_count;
}
?>