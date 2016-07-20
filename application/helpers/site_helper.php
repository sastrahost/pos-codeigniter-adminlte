<?php
function escape($string) { 
    if(!empty($string) && is_string($string)) { 
		$string = trim($string);
        $string = str_replace(array('\\', "\0", "\n", "\r", "'", '"', "\x1a"), array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'), $string);

        return strip_tags($string);
    }else{
      return $string;
    }
} 

function get_user($arg = false){
	$ci = &get_instance();
	$ci->load->model('auth_model');
	$user_data = false;
	if(isset($_SESSION['id'])){
		$user_data = $ci->auth_model->get_profile($_SESSION['id']);
	}
	if($user_data && $arg){
		$user_data = $user_data[0]->{$arg};
	}
	return $user_data;
}

function is_menu($slug_1 = '',$slug_2 = '',$slug_3 = ''){
	$ci = &get_instance();
	$ci->load->helper('url');
	$active = false;
	if($slug_1 == $ci->uri->segment(1)){
		$active = true;
	}
	if($active && $slug_2 && $slug_2 == $ci->uri->segment(2)){
		$active = true;
	}
	if($active && $slug_3 && $slug_3 == $ci->uri->segment(3)){
		$active = true;
	}
	if($active){
		$active = "active";
	}
	return $active;
}
function generate_code($prefix,$num,$length = 3){
	$add_code = (int)filter_var($num, FILTER_SANITIZE_NUMBER_INT) + 1;
	$num_code = str_pad($add_code,$length,"0",STR_PAD_LEFT);
	return $prefix.$num_code;
}

function get_paggination($total_row,$search = array()){
	$ci = &get_instance();
	$ci->load->library('pagination');


	$current_url = reconstruct_url("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
	if(!empty($search)){
		$config['base_url'] = $current_url.'?'.http_build_query($search);
	}else{
		$config['base_url'] = $current_url;
	}
	$config['page_query_string'] = true;
	$config['query_string_segment'] = 'page';
	$config['total_rows'] = $total_row;
	$config['per_page'] = $ci->page_limit;

	$config['full_tag_open'] = '<ul class="pagination">';
	$config['full_tag_close'] = '</ul>';
	$config['first_link'] = false;
	$config['last_link'] = false;
	$config['first_tag_open'] = '<li>';
	$config['first_tag_close'] = '</li>';
	$config['prev_link'] = '&laquo';
	$config['prev_tag_open'] = '<li class="prev">';
	$config['prev_tag_close'] = '</li>';
	$config['next_link'] = '&raquo';
	$config['next_tag_open'] = '<li>';
	$config['next_tag_close'] = '</li>';
	$config['last_tag_open'] = '<li>';
	$config['last_tag_close'] = '</li>';
	$config['cur_tag_open'] = '<li class="active"><a href="#">';
	$config['cur_tag_close'] = '</a></li>';
	$config['num_tag_open'] = '<li>';
	$config['num_tag_close'] = '</li>';

	$ci->pagination->initialize($config);

	return $ci->pagination->create_links();
}

function url_param(){
	// get limit offset
	$ci = &get_instance();
	$page = 0;
	if(!empty($_GET['page'])){
		$page = $_GET['page'];
	}
	$result = array("limit" => $ci->page_limit , "offset" => $page);
	return $result;
}
function get_search(){
	$search = $_GET;
	if(isset($search['page'])){
		unset($search['page']);
	}
	return $search;
}
function reconstruct_url($url){
	$url_parts = parse_url($url);
	$constructed_url = $url_parts['scheme'] . '://' . $url_parts['host'] . (isset($url_parts['path'])?$url_parts['path']:'');

	return $constructed_url;
}
function search_form($module){
	$search = !empty($_GET["search_by"]) && $_GET["search_by"] == "id" ? "selected" : "";
	$by = !empty($_GET['search_by']) && $_GET['search_by'] == $module.'_name' ? 'selected' : '';
	$value = !empty($_GET['value']) ? $_GET['value'] : '';

	$s = '<div class="col-md-3">';
	$s .=    '<div class="form-group">';
	$s .=       '<label for="id">Search by</label>';
	$s .=			'<select name="search_by" class="form-control">';
    $s .= 		        '<option value="id" '.$search.'>ID</option>';
	$s .= 				'<option value="'.$module.'_name" '.$by.'>Nama '.ucfirst($module).'</option>';
	$s .= 			'</select>';
	$s .=		'</div>';
	$s .= 	'</div>';
	$s .=	'<div class="col-md-3">';
	$s .=		'<div class="form-group">';
	$s .=			'<label for="customer_name">Value</label>';
	$s .=			'<input type="text" class="form-control" name="value" value="'.$value.'"/>';
	$s .=		'</div>';
	$s .=	'</div>';

	return $s;
}

function get_uri(){
	return "?".$_SERVER['QUERY_STRING'];
}