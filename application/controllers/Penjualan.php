<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penjualan extends MY_Controller {
	function __construct(){
        parent::__construct();
		$this->load->model('auth_model');
        $this->load->library('form_validation');
		$this->load->model('penjualan_model');
		$this->load->model('pelanggan_model');
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
				$filter['sales_transaction.id'] = $_GET['id'];
			}

			if(!empty($_GET['date']) && $_GET['date'] != ''){
				$filter['DATE(sales_transaction.date)'] = $_GET['date'];
			}

			$total_row = $this->penjualan_model->count_total_filter($filter);
			$data['penjualans'] = $this->penjualan_model->get_filter($filter,url_param());
		}else{
			$total_row = $this->penjualan_model->count_total();
			$data['penjualans'] = $this->penjualan_model->get_all(url_param());
		}
		$data['paggination'] = get_paggination($total_row,get_search());
		$this->load->view('penjualan/index',$data);
	}
	
	function create(){
		// destry cart
		$this->cart->destroy();

		$data['code_penjualan'] = "OUT".strtotime(date("Y-m-d H:i:s"));
		$data['customers'] = $this->pelanggan_model->get_all();
		$data['kategoris'] = $this->kategori_model->get_all();
		$this->load->view('penjualan/form',$data);
	}
	
	public function detail($id){
		$details = $this->penjualan_model->get_detail($id);
		if($details){
			$data['details'] = $details;
			$this->load->view('penjualan/detail',$data);
		}else{
			redirect(site_url('penjualan'));
		}
	}
	public function edit($id){
		// destry cart
		$this->cart->destroy();
		$data['suppliers'] = $this->supplier_model->get_all();
		$data['kategoris'] = $this->kategori_model->get_all();

		$transaksi = $this->penjualan_model->get_detail($id);
		if($transaksi){
			//print_r($transaksi); exit;
			$data['carts'] = $this->_process_cart($transaksi);
			$data['pembelian'] = $transaksi;
			$this->load->view('penjualan/form',$data);
		}else{
			redirect(site_url('penjualan'));
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
		$check_id = $this->penjualan_model->get_by_id($id);
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
		$this->form_validation->set_rules('sales_id', 'sales_id', 'required');
		$this->form_validation->set_rules('customer_id', 'customer_id', 'required');
		$this->form_validation->set_rules('is_cash', 'is_cash', 'required');

		$carts =  $this->cart->contents();
		if($this->_check_qty($carts)){
			echo json_encode(array('status' => 'limit'));
			exit;
		}
		
		if($this->form_validation->run() != FALSE && !empty($carts) && is_array($carts)){
			$data['id'] = escape($this->input->post('sales_id'));
			$data['customer_id'] = escape($this->input->post('customer_id'));
			$data['is_cash'] = escape($this->input->post('is_cash'));
			$data['total_price'] = $this->cart->total();
			$data['total_item'] = $this->cart->total_items();

			if($data['is_cash'] == 0){
				$data['pay_deadline_date'] = date('Y-m-d', strtotime("+30 days"));
			}else{
				$data['pay_deadline_date'] = date('Y-m-d');
			}

			$this->penjualan_model->insert($data);
			if($data['id']){
				$this->_insert_purchase_data($data['id'],$carts);
			}
			echo json_encode(array('status' => 'ok'));
		}else{
			echo json_encode(array('status' => 'error'));
		}
	}
	/*public function update($transaction_id){
		$this->form_validation->set_rules('supplier_id', 'supplier_id', 'required');

		$carts =  $this->cart->contents();
		if($this->form_validation->run() != FALSE && !empty($carts) && is_array($carts)){
			$data['id'] = $transaction_id;
			$data['supplier_id'] = escape($this->input->post('supplier_id'));
			$data['total_price'] = $this->cart->total();
			$data['total_item'] = $this->cart->total_items();


			$this->penjualan_model->update($transaction_id,$data);
			if($data['id']){
				$transaksi = $this->penjualan_model->get_detail($transaction_id);
				$this->penjualan_model->delete_purchase_data_trx($transaction_id);
				$this->_insert_purchase_data($transaction_id,$carts);
			}
			echo json_encode(array('status' => 'ok'));
		}else{
			echo json_encode(array('status' => 'error'));
		}
	}*/
	private function _check_qty($carts){
		$status = false;
		foreach($carts as $key => $cart){
			$product = $this->produk_model->get_by_id($cart['id']);
			if($cart['qty'] > $product[0]['product_qty']){
				$status = true;
				break;
			}
		}
		return $status;
	}
	private function _insert_purchase_data($sales_id,$carts){
		foreach($carts as $key => $cart){
			$purchase_data = array(
				'sales_id' => $sales_id,
				'product_id' => $cart['id'],
				'category_id' => $cart['category_id'],
				'quantity' => $cart['qty'],
				'price_item' => $cart['price'],
				'subtotal' => $cart['subtotal']
			);
			$this->penjualan_model->insert_purchase_data($purchase_data);

			$this->produk_model->update_qty_min($cart['id'],array('product_qty' => $cart['qty']));
		}
		$this->cart->destroy();
	}
	public function delete($transaction_id){
		$transaksi = $this->penjualan_model->get_detail($transaction_id);
		foreach($transaksi as $trans){
			$product = $this->produk_model->get_by_id($trans->product_id);
			$total = $product[0]['product_qty'] - $trans->quantity;
			$this->produk_model->update_qty($product[0]['id'] ,array('product_qty' => $total));
		}
		$this->penjualan_model->delete($transaction_id);
		$this->penjualan_model->delete_purchase_data_trx($transaction_id);
		redirect(site_url('penjualan'));
	}
}
