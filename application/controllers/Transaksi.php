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
		if(isset($_GET['search'])){
			$filter = '';
			if(!empty($_GET['id']) && $_GET['id'] != ''){
				$filter['purchase_transaction.id LIKE'] = "%".$_GET['id']."%";
			}

			if(!empty($_GET['date_from']) && $_GET['date_from'] != ''){
				$filter['DATE(purchase_transaction.date) >='] = $_GET['date_from'];
			}

			if(!empty($_GET['date_end']) && $_GET['date_end'] != ''){
				$filter['DATE(purchase_transaction.date) <='] = $_GET['date_end'];
			}

			$total_row = $this->transaksi_model->count_total_filter($filter);
			$data['transaksis'] = $this->transaksi_model->get_filter($filter,url_param());
		}else{
			$total_row = $this->transaksi_model->count_total();
			$data['transaksis'] = $this->transaksi_model->get_all(url_param());
		}
		$data['paggination'] = get_paggination($total_row,get_search());
		$this->load->view('transaksi/index',$data);
	}
	
	function create(){
		// destry cart
		$this->cart->destroy();
		$data['suppliers'] = $this->supplier_model->get_all();
		$data['kategoris'] = $this->kategori_model->get_all();
		$this->load->view('transaksi/form',$data);
	}
	
	public function detail($id){
		$details = $this->transaksi_model->get_detail($id);
		if($details){
			$data['details'] = $details;
			$this->load->view('transaksi/detail',$data);
		}else{
			redirect(site_url('transaksi'));
		}
	}
	public function edit($id){
		// destry cart
		$this->cart->destroy();
		$data['suppliers'] = $this->supplier_model->get_all();
		$data['kategoris'] = $this->kategori_model->get_all();

		$transaksi = $this->transaksi_model->get_detail($id);
		if($transaksi){
			//print_r($transaksi); exit;
			$data['carts'] = $this->_process_cart($transaksi);
			$data['transaksi'] = $transaksi;
			$this->load->view('transaksi/form',$data);
		}else{
			redirect(site_url('transaksi'));
		}
	}

	private function _process_cart($transaksi = ''){
		if($transaksi & is_array($transaksi)){
			foreach($transaksi as $key => $item){
				$data = array(
					'id'      => $item->product_id,
					'qty'     => $item->quantity,
					'price'   => $item->price_item,
					'category_id' => $item->category_id,
					'category_name' => $item->category_name,
					'name'    => $item->product_name
				);
				$this->cart->insert($data);
			}
		}
		$response = array(
				'data' => $this->cart->contents() ,
				'total_item' => $this->cart->total_items(),
				'total_price' => $this->cart->total()
			);
		return $response;
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
		$product_id = $this->input->post('product_id');
		$quantity = $this->input->post('quantity');
		$sale_price = $this->input->post('sale_price');

		$get_product_detail =  $this->produk_model->detail_by_id($product_id);
		if($get_product_detail){
			$data = array(
				'id'      => $product_id,
				'qty'     => $quantity,
				'price'   => $sale_price,
				'category_id' => $get_product_detail[0]['category_id'],
				'category_name' => $get_product_detail[0]['category_name'],
				'name'    => $get_product_detail[0]['product_name']
			);
			$this->cart->insert($data);
			echo json_encode(array('status' => 'ok',
							'data' => $this->cart->contents() ,
							'total_item' => $this->cart->total_items(),
							'total_price' => $this->cart->total()
						)
				);
		}else{
			echo json_encode(array('status' => 'error'));
		}

	}
	public function delete_item($rowid){
		if($this->cart->remove($rowid)) {
			echo number_format($this->cart->total());
		}else{
			echo "false";
		}
	}
	public function add_process(){
		$this->form_validation->set_rules('transaction_id', 'transaction_id', 'required');
		$this->form_validation->set_rules('supplier_id', 'supplier_id', 'required');

		$carts =  $this->cart->contents();
		if($this->form_validation->run() != FALSE && !empty($carts) && is_array($carts)){
			$data['id'] = escape($this->input->post('transaction_id'));
			$data['supplier_id'] = escape($this->input->post('supplier_id'));
			$data['total_price'] = $this->cart->total();
			$data['total_item'] = $this->cart->total_items();

			$this->transaksi_model->insert($data);
			if($data['id']){
				$this->_insert_purchase_data($data['id'],$carts);
			}
			echo json_encode(array('status' => 'ok'));
		}else{
			echo json_encode(array('status' => 'error'));
		}
	}
	private function _insert_purchase_data($transaction_id,$carts){
		foreach($carts as $key => $cart){
			$purchase_data = array(
				'transaction_id' => $transaction_id,
				'product_id' => $cart['id'],
				'category_id' => $cart['category_id'],
				'quantity' => $cart['qty'],
				'price_item' => $cart['price'],
				'subtotal' => $cart['subtotal']
			);
			$this->transaksi_model->insert_purchase_data($purchase_data);

			$this->produk_model->update_qty_add($cart['id'],array('product_qty' => $cart['qty']));
		}
		$this->cart->destroy();
	}
	public function delete($transaction_id){
		$transaksi = $this->transaksi_model->get_detail($transaction_id);
		foreach($transaksi as $trans){
			$product = $this->produk_model->get_by_id($trans->product_id);
			$total = $product[0]['product_qty'] - $trans->quantity;
			$this->produk_model->update_qty($product[0]['id'] ,array('product_qty' => $total));
		}
		$this->transaksi_model->delete($transaction_id);
		$this->transaksi_model->delete_purchase_data_trx($transaction_id);
		redirect(site_url('transaksi'));
	}
	public function export_csv(){
		$filter = '';
		if(isset($_GET['search'])) {
			if (!empty($_GET['id']) && $_GET['id'] != '') {
				$filter['purchase_transaction.id LIKE'] = "%" . $_GET['id'] . "%";
			}

			if (!empty($_GET['date_from']) && $_GET['date_from'] != '') {
				$filter['DATE(purchase_transaction.date) >='] = $_GET['date_from'];
			}

			if (!empty($_GET['date_end']) && $_GET['date_end'] != '') {
				$filter['DATE(purchase_transaction.date) <='] = $_GET['date_end'];
			}
		}
		$result = $this->transaksi_model->get_filter_csv($filter);
		if($result){
			$result = $this->_set_csv_format($result);
		}
		//echo json_encode($result);
		$this->csv_library->export('transaksi_penjualan.csv',$result);
	}

	private function _set_csv_format($datas){
		$result = false;
		if(is_array($datas)){
			$data_before = "";
			foreach($datas as $k => $data){
				$datas[$k]['type'] = ($data['type'] == 1) ? "Cash" : "Bayar Nanti";
				$datas[$k]['date'] = date("Y-m-d H:i:s",strtotime($data['date']));
				if($data['id'] == $data_before) {
					$datas[$k]['id'] = "";
					$datas[$k]['total_price'] = "";
					$datas[$k]['total_item'] = "";
					$datas[$k]['type'] = "";

					$datas[$k]['date'] = "";
					$datas[$k]['supplier_id'] = "";
					$datas[$k]['supplier_name'] = "";
					$datas[$k]['supplier_phone'] = "";
					$datas[$k]['supplier_address'] = "";
					$datas[$k]['transaction_id'] = "";
					$datas[$k]['category_name'] = "";
				}
				$data_before = $data['id'];
			}
			$result = $datas;
		}
		return $result;
	}
}
