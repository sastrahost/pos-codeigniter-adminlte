<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi extends MY_Controller {
	function __construct(){
        parent::__construct();
		$this->load->model('auth_model');
        $this->load->library('form_validation');
		$this->load->model('transaksi_model');
		$this->load->model('supplier_model');
		$this->load->model('kategori_model');
		$this->load->model('produk_model');
		
		// Check Session Login
		if(!isset($_SESSION['logged_in'])){
			redirect(site_url('auth/login'));
		}
	}
	
	function index(){
		$this->load->view('transaksi/index');
	}
	
	function create(){
		$data['suppliers'] = $this->supplier_model->get_all();
		$data['kategoris'] = $this->kategori_model->get_all();
		$this->load->view('transaksi/form',$data);
	}
	
	public function check_id(){
		$id = $this->input->post('id');
		$check_id = $this->transaksi_model->get_by_id($id);
		if(!$check_id){
			echo "available";
		}else{
			echo "unavailable";
		}
	}
	
	public function check_category_id($category_id){
		$products = $this->produk_model->get_by_category($category_id);
		echo json_encode($products);
	}
	public function check_product_id($product_id){
		$products = $this->produk_model->get_by_id($product_id);
		echo json_encode($products);
	}
	public function add_item(){
		$category_id = $this->input->post('category_id');
		$product_id = $this->input->post('product_id');
		$quantity = $this->input->post('quantity');
		$sale_price = $this->input->post('sale_price');
		
		echo $product_id;
	}
}
