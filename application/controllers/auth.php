<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller {
	function __construct(){
        parent::__construct();
		$this->load->model('auth_model');
        $this->load->library('form_validation');		
	}
	
	function index(){
		redirect(site_url());
	}
	
	function login(){		
		// Check Session Login
		if(isset($_SESSION['logged_in'])){
			redirect(site_url());
		}
		
		// Check Remember Me
		if(isset($_COOKIE['remember_me'])){			
			$this->auth_model->set_session($username);
			redirect(site_url());
		}
		$this->load->view('auth/login');
	}
	
	public function login_process($check_login = false){
		// Check Session Login
		if(isset($_SESSION['logged_in'])){
			redirect(site_url());
		}
		// Check Remember Me
		if(isset($_COOKIE['remember_me'])){			
			$this->auth_model->set_session($username);
			redirect(site_url());
		}
		$username = escape($this->input->post("username"));		
		$password = md5(escape($this->input->post("password")));
		$remember_me = escape($this->input->post("remember_me"));	
		if($username && $password){
			$check_login = $this->auth_model->check_login($username,$password);	
		}
		if($check_login){
			$id = $check_login[0]->id;
			$this->auth_model->set_session($id,$username);
			if($remember_me){
				$this->auth_model->set_cookie_remember($username);
			}
			redirect(site_url());
		}else{
			$this->session->set_flashdata('login_false', 'Username atau Password salah.');
			redirect(site_url('auth/login'));
		}
	}
	
	function logout(){
		$this->auth_model->unset_session();
		$this->auth_model->unset_cookie_remember();
		redirect(site_url());
	}
}
