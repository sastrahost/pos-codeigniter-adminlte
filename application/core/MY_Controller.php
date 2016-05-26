<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	public function __construct(){
        parent::__construct();
		
		// Check Session Login
		$this->is_login = false;
		if(isset($_SESSION['logged_in'])){
			$this->is_login = true;
			$this->user_photo = get_user('photo_profile');
			$this->username = get_user('username');
		}		
		
		$this->page_limit = 10;
	}
	public function index()
	{
		$this->load->view('latihan');
	}
}
