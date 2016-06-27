<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Retur_purchase_model extends CI_Model {
	private $table;
	private $table_data;
	private $select_default;
	function __construct(){
        parent::__construct();
		$this->table = "purchase_retur";
		$this->table_data = "purchase_data";
		$this->select_default = '*, purchase_retur.id AS id, sales_retur_id,total_price, total_item,purchase_retur.date AS date,return_by';
	}
	
	public function get_all($limit_offset = array()){
		$this->db->select($this->select_default);
		if(!empty($limit_offset)){
			$query = $this->db->get($this->table,$limit_offset['limit'],$limit_offset['offset']);
		}else{
			$query = $this->db->get($this->table);
		}
		return $query->result();
	}
	public function count_total(){
		$query = $this->db->get($this->table);
		return $query->num_rows();
	}
	public function get_all_array(){
		$query = $this->db->get($this->table);
		return $query->result_array();
	}
	public function get_last_id(){
		$this->db->order_by('id', 'DESC');

		$query = $this->db->get($this->table,1,0);
		return $query->result();
	}
	public function insert($data){
		$this->db->insert($this->table, $data);
	}
	public function update($id,$data){
		$this->db->where('id', $id);
		$this->db->update($this->table, $data);
	}
	public function get_by_id($id){
		$response = false;
		$query = $this->db->get_where($this->table,array('id' => $id));
		if($query && $query->num_rows()){
			$response = $query->result_array();
		}
		return $response;
	}
	public function delete($id){
		$this->db->delete($this->table, array('id' => $id));
	}

	public function delete_data($sales_id){
		$this->db->delete("purchase_data", array('transaction_id' => $sales_id));
	}
	public function delete_data_sales($sales_id){
		$this->db->delete("sales_data", array('sales_id' => $sales_id));
	}
	public function get_detail($retur_id){
		$sql = "SELECT *, purchase_retur.id AS id, product.id as product_id FROM purchase_retur 
				JOIN purchase_data ON purchase_retur.id = purchase_data.transaction_id 
				JOIN product ON product.id = purchase_data.product_id 
				JOIN category ON category.id = purchase_data.category_id 
				WHERE purchase_retur.sales_retur_id = '".$retur_id."'";
		$query = $this->db->query($sql);
		return $query->result();
	}
	public function get_detail_by_id($id){
		$sql = "SELECT *, purchase_retur.id AS id, product.id as product_id FROM purchase_retur 
					JOIN purchase_data ON purchase_retur.id = purchase_data.transaction_id 
					JOIN product ON product.id = purchase_data.product_id 
					JOIN category ON category.id = purchase_data.category_id 
			  	WHERE purchase_retur.id = '".$id."'";
		$query = $this->db->query($sql);
		return $query->result();
	}
	public function get_detail_by_sales_id($id){
		$sql = "SELECT *, purchase_retur.id AS id, product.id as product_id FROM purchase_retur 
					JOIN sales_data ON purchase_retur.sales_retur_id = sales_data.sales_id 
					JOIN product ON product.id = sales_data.product_id 
					JOIN category ON category.id = sales_data.category_id 
			  	WHERE purchase_retur.id = '".$id."'";
		$query = $this->db->query($sql);
		return $query->result();
	}
	public function get_filter($filter = '',$limit_offset = array(),$is_array = false){
		$this->db->select($this->select_default);
		if(!empty($filter)){
			$this->db->where($filter);
			if($limit_offset){
				$this->db->limit($limit_offset['limit'],$limit_offset['offset']);
			}
			$query = $this->db->get($this->table);
		}else{
			$query = $this->db->get($this->table,$limit_offset['limit'],$limit_offset['offset']);
		}
		if($is_array){
			return $query->result_array();
		}else{
			return $query->result();
		}
	}
	public function count_total_filter($filter = array()){
		if(!empty($filter)){
			$query = $this->db->get_where($this->table,$filter);
		}else{
			$query = $this->db->get($this->table);
		}
		return $query->num_rows();
	}
	public function insert_purchase_data($data){
		$this->db->insert($this->table_data, $data);
	}
	public function delete_purchase_data_trx($transaction_id){
		$this->db->delete($this->table_data, array('sales_id' => $transaction_id));
	}

	/*
	 * Tunggakan Disini
	 */
	public function count_total_filter_tunggakan($filter = array()){
		$filter['is_cash'] = 0;
		$query = $this->db->get_where($this->table,$filter);
		return $query->num_rows();
	}
	public function get_filter_tunggakan($filter = '',$limit_offset = array(),$is_array = false){
		$filter['is_cash'] = 0;
		$this->db->select($this->select_default);
		$this->db->join('customer', 'customer.id = sales_transaction.customer_id', 'left');
		$this->db->where($filter);
		if($limit_offset){
			$this->db->limit($limit_offset['limit'],$limit_offset['offset']);
		}
		$query = $this->db->get($this->table);

		if($is_array){
			$resopnse = $query->result_array();
		}else{
			$resopnse = $query->result();
		}
		return $resopnse;
	}

	public function insert_retur_carts($purchase_retur_id,$carts){
		foreach($carts as $key => $cart){
			$retur_data = array(
				'transaction_id' => $purchase_retur_id,
				'product_id' => $cart['id'],
				'category_id' => $cart['category_id'],
				'quantity' => $cart['qty'],
				'price_item' => $cart['price'],
				'subtotal' => $cart['subtotal']
			);
			$this->insert_purchase_data($retur_data);

			///$this->produk_model->update_qty_min($cart['id'],array('product_qty' => $cart['qty']));
		}
	}
}