<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {
	function __construct(){
        parent::__construct();
		$this->load->model('auth_model');
        $this->load->library('form_validation');
		
		// Check Session Login
		if(!isset($_SESSION['logged_in'])){
			redirect(site_url('auth/login'));
		}
	}
	
	function index(){
		redirect(site_url('home/dashboard'));
	}
	
	function dashboard(){
		$this->load->view('home/dashboard');
	}
}
