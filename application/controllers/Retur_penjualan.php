<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Retur_penjualan extends MY_Controller {
	function __construct(){
        parent::__construct();
		$this->load->model('auth_model');
        $this->load->library('form_validation');
		$this->load->model('retur_penjualan_model');
		$this->penjualan = $this->retur_penjualan_model;
		$this->load->model('pelanggan_model');
		$this->load->model('penjualan_model');
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
				$filter['sales_transaction.id LIKE'] = "%".$_GET['id']."%";
			}

			if(!empty($_GET['date_from']) && $_GET['date_from'] != ''){
				$filter['DATE(sales_transaction.date) >='] = $_GET['date_from'];
			}

			if(!empty($_GET['date_end']) && $_GET['date_end'] != ''){
				$filter['DATE(sales_transaction.date) <='] = $_GET['date_end'];
			}

			$total_row = $this->penjualan->count_total_filter($filter);
			$data['penjualans'] = $this->penjualan->get_filter($filter,url_param());
		}else{
			$total_row = $this->penjualan->count_total();
			$data['penjualans'] = $this->penjualan->get_all(url_param());
		}
		$data['paggination'] = get_paggination($total_row,get_search());
		$this->load->view('retur_penjualan/index',$data);
	}
	
	function create(){
		if(isset($_GET['search'])){
			$filter = '';
			if(!empty($_GET['id']) && $_GET['id'] != ''){
				$filter['sales_transaction.id LIKE'] = "%".$_GET['id']."%";
			}

			if(!empty($_GET['date_from']) && $_GET['date_from'] != ''){
				$filter['DATE(sales_transaction.date) >='] = $_GET['date_from'];
			}

			if(!empty($_GET['date_end']) && $_GET['date_end'] != ''){
				$filter['DATE(sales_transaction.date) <='] = $_GET['date_end'];
			}

			$total_row = $this->penjualan_model->count_total_filter($filter);
			$data['penjualans'] = $this->penjualan_model->get_filter($filter,url_param());
		}else{
			$total_row = $this->penjualan_model->count_total();
			$data['penjualans'] = $this->penjualan_model->get_all(url_param());
		}
		$data['retur'] = true;
		$data['paggination'] = get_paggination($total_row,get_search());
		$this->load->view('retur_penjualan/retur_index',$data);
	}

	function create_retur($id){
		// destry cart
		$this->cart->destroy();

		$details = $this->penjualan_model->get_detail($id);
		if(!$details){
			redirect(site_url());
		}
		$cart_data = $this->_process_cart($details);
		//print_r($cart_data); exit;
		$data['carts'] = $cart_data;
		$data['code_penjualan'] = $id;
		$data['code_retur_penjualan'] = "RETS".strtotime(date("Y-m-d H:i:s"));
		$data['customers'] = $this->pelanggan_model->get_all();
		$data['kategoris'] = $this->kategori_model->get_all();
		$data['details'] = $details;
		$this->load->view('retur_penjualan/form',$data);
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

	public function update_cart($rowid = ''){
		$qty = $this->input->post("qty");
		$data = array(
			'rowid' => $rowid,
			'qty'   => $qty
		);
		$this->cart->update($data);

		echo json_encode($this->cart->contents());
	}

	private function _process_cart($transaksi = ''){
		if(!empty($transaksi) & is_array($transaksi)){
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
		$this->form_validation->set_rules('retur_penjualan_id', 'retur_penjualan_id', 'required');
		$this->form_validation->set_rules('retur_penjualan_date', 'retur_penjualan_date', 'required');
		$this->form_validation->set_rules('code_penjualan', 'code_penjualan', 'required');

		$carts =  $this->cart->contents();

		if($this->form_validation->run() != FALSE && !empty($carts) && is_array($carts)){
			$data['id'] = escape($this->input->post('retur_penjualan_id'));
			$data['sales_id'] = escape($this->input->post('code_penjualan'));
			$data['total_price'] = $this->cart->total();
			$data['total_item'] = $this->cart->total_items();
			$data['is_return'] = "0";
			$data['date'] = escape($this->input->post('retur_penjualan_date'));

			$this->retur_penjualan_model->insert($data);
			if($data['id']){
				$this->_insert_purchase_data($data['id'],$carts);
			}
			echo json_encode(array('status' => 'ok'));
		}else{
			echo json_encode(array('status' => 'error', 'carts' => $carts));
		}
	}

	public function edit($retur_id){
		// destry cart
		$this->cart->destroy();

		$details = $this->penjualan->get_detail($retur_id);
		if(!$details){
			redirect(site_url());
		}
		$cart_data = $this->_process_cart($details);
		//print_r($cart_data); exit;
		$data['edit'] = true;
		$data['carts'] = $cart_data;
		$data['code_penjualan'] = $details[0]->sales_id;
		$data['code_retur_penjualan'] = $details[0]->id;
		$data['date'] = $details[0]->date;
		$data['details'] = $details;
		$this->load->view('retur_penjualan/form',$data);
	}

	public function update($retur_id){
		$details = $this->penjualan->get_detail_by_id($retur_id);
		if(!$details){
			redirect(site_url());
			exit;
		}


		$carts =  $this->cart->contents();
		$is_return = escape($this->input->post("is_return"));
		$check_qty = $this->_check_qty($carts);
		if(!empty($carts) && is_array($carts) && $check_qty){
			// Delete Row on sales_data table
			foreach($details as $detail){
				$this->penjualan->delete_data($detail->sales_id);
			}
			
			$data['id'] = $retur_id;
			$data['total_price'] = $this->cart->total();
			$data['total_item'] = $this->cart->total_items();
			$data['is_return'] = ($is_return != "undefined") ? (int)$is_return : "0";

			$this->penjualan->update($retur_id,$data);
			if($is_return == "1"){
				// Update product
				foreach($carts as $cart){
					$this->produk_model->update_qty_min($cart['id'],array('product_qty' => $cart['qty']));
				}
			}
			
			if($data['id']){
				$this->_insert_purchase_data($data['id'],$carts);
			}

			echo json_encode(array('status' => 'ok','is_return' => $is_return));
		}else if(!$check_qty){
			echo json_encode(array('status' => 'limit'));
		}else{
			echo json_encode(array('status' => 'error','is_return' => $is_return));
		}
	}

	private function _check_qty($carts){
		$result = true;
		foreach($carts as $cart) {
			// Check Quantity Product
			$product = $this->produk_model->get_by_id($cart['id']);
			$qty = $product[0]['product_qty'];
			if($cart['qty'] > $qty){
				$result = false;
				break;
			}
		}
		return $result;
	}
	/*private function _check_qty($carts){
		$status = false;
		foreach($carts as $key => $cart){
			$product = $this->produk_model->get_by_id($cart['id']);
			if($cart['qty'] > $product[0]['product_qty']){
				$status = true;
				break;
			}
		}
		return $status;
	}*/
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
	public function delete($retur_id){
		$details = $this->penjualan->get_detail_by_id($retur_id);

		if(!$details){
			redirect(site_url());
			exit;
		}

		// Delete Row on sales_data table
		foreach($details as $detail){
			$this->penjualan->delete_data($detail->sales_id);
		}
		$this->penjualan->delete($retur_id);
		redirect(site_url('retur_penjualan'));
	}
	public function export_csv(){
		$data = $this->penjualan->get_filter('',url_param(),true);
		$this->csv_library->export('sales.csv',$data);
	}
}
