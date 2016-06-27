<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {
	function __construct(){
        parent::__construct();
		$this->load->model('auth_model');
		$this->load->model('supplier_model');
		$this->load->model('pelanggan_model');
		$this->load->model('produk_model');
		$this->load->model('kategori_model');
        $this->load->model('penjualan_model');
        $this->load->model('retur_penjualan_model');
		
		// Check Session Login
		if(!isset($_SESSION['logged_in'])){
			redirect(site_url('auth/login'));
		}
	}
	
	function index(){
		redirect(site_url('home/dashboard'));
	}
	
	function dashboard(){
		$date = date('Y-m-d', strtotime("+30 days"));
		$filter['DATE(sales_transaction.pay_deadline_date) <='] = $date;
		$limit_offset['limit'] = 10;
		$limit_offset['offset'] = 0;
        $data['tunggakans'] = $this->penjualan_model->get_filter_tunggakan($filter,$limit_offset);
		
		$data['suppliers'] = $this->supplier_model->count_total();
		$data['customers'] = $this->pelanggan_model->count_total();
		$data['products'] = $this->produk_model->count_total();
		$data['categories'] = $this->kategori_model->count_total();
		$data['penjualan_harian'] = $this->penjualan_daily();
		$data['penjualan_bulanan'] = $this->penjualan_daily(true);
		$data['sales_retur'] = $this->retur_penjualan_model->get_all_not_returned();
		$this->load->view('home/dashboard',$data);
	}
	
	private function penjualan_daily($bulanan = false){
		$today = date("Y-m-d",strtotime("today"));
		$yesterday = date("Y-m-d",strtotime("-1 day"));	
		if($bulanan){
			$yesterday = date("Y-m-d",strtotime("-30 day"));	
		}	

		$filter['DATE(sales_transaction.date) >='] = $yesterday;
		$filter['DATE(sales_transaction.date) <='] = $today;

		$penjualans = $this->penjualan_model->get_filter($filter,url_param());
		return $penjualans;
	}
}
