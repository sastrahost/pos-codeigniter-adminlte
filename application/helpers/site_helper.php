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