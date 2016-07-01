<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penjualan_model extends CI_Model {
	private $table;
	private $select_default;
	function __construct(){
        parent::__construct();
		$this->table = "sales_transaction";
		$this->select_default = 'sales_transaction.id AS id, customer_name, customer_phone, total_price, total_item,sales_transaction.date AS date,sales_transaction.pay_deadline_date,sales_transaction.is_cash';
	}
	
	public function get_all($limit_offset = array()){
		$this->db->select($this->select_default);
		$this->db->join('customer', 'customer.id = sales_transaction.customer_id', 'left');
		$this->db->order_by("date", "desc");
		if(!empty($limit_offset)){
			$query = $this->db->get($this->table,$limit_offset['limit'],$limit_offset['offset']);
		}else{
			$query = $this->db->get($this->table);
		}
		return $query->result();
	}
	public function count_total(){
		$query = $this->db->order_by("date", "desc")->get($this->table);
		return $query->num_rows();
	}
	public function get_all_array(){
		$query = $this->db->order_by("date", "desc")->get($this->table);
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
	public function get_detail($id){
		$sql = "SELECT *, sales_transaction.id AS id, product.id as product_id FROM sales_transaction 
				JOIN sales_data ON sales_transaction.id = sales_data.sales_id 
				JOIN product ON product.id = sales_data.product_id 
				JOIN customer ON customer.id = sales_transaction.customer_id 
				JOIN category ON category.id = sales_data.category_id 
				WHERE sales_data.sales_id = '".$id."'";
		$query = $this->db->query($sql);
		return $query->result();
	}
	public function get_filter($filter = '',$limit_offset = array(),$is_array = false){
		$this->db->select($this->select_default);
		$this->db->join('customer', 'customer.id = sales_transaction.customer_id', 'left');
		$this->db->order_by("date", "desc");
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
		$this->db->insert('sales_data', $data);
	}
	public function delete_purchase_data_trx($transaction_id){
		$this->db->delete('sales_data', array('sales_id' => $transaction_id));
	}

	/*
	 * Tunggakan Disini
	 */
	public function count_total_filter_tunggakan($filter = array()){
		$filter['is_cash'] = 0;
		$query = $this->db->order_by("date", "desc")->get_where($this->table,$filter);
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
		$query = $this->db->order_by($this->table.".date", "desc")->get($this->table);

		if($is_array){
			$resopnse = $query->result_array();
		}else{
			$resopnse = $query->result();
		}
		return $resopnse;
	}
}