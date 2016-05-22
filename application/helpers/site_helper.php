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