<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi_model extends CI_Model {
	private $table;
	private $select_default;
	function __construct(){
        parent::__construct();
		$this->table = "purchase_transaction";
		$this->select_default = 'purchase_transaction.id AS id, supplier_name, total_price, total_item,purchase_transaction.date AS date';
	}
	
	public function get_all($limit_offset = array()){
		$this->db->select($this->select_default);
		$this->db->join('supplier', 'supplier.id = purchase_transaction.supplier_id', 'left');
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
	public function get_detail($id){
		$this->db->select('*,purchase_transaction.id AS id, product.id as product_id ');
		$this->db->from('purchase_data');
		$this->db->join('purchase_transaction', 'purchase_data.transaction_id = purchase_transaction.id','right');
		$this->db->join('product', 'product.id = purchase_data.product_id', 'left');
		$this->db->join('supplier', 'supplier.id = purchase_transaction.supplier_id', 'left');
		$this->db->join('category', 'category.id = purchase_data.category_id', 'left');
		$this->db->where('purchase_data.transaction_id',$id);
		$query = $this->db->get();
		return $query->result();
	}
	public function get_filter($filter = '',$limit_offset = array()){
		$this->db->select($this->select_default);
		$this->db->join('supplier', 'supplier.id = purchase_transaction.supplier_id', 'left');
		if(!empty($filter)){
			$this->db->where($filter);
			if($limit_offset){
				$this->db->limit($limit_offset['limit'],$limit_offset['offset']);
			}
			$query = $this->db->get($this->table);
		}else{
			$query = $this->db->get($this->table,$limit_offset['limit'],$limit_offset['offset']);
		}
		return $query->result();
	}
	public function count_total_filter($filter = array()){
		if(!empty($filter)){
			if(!empty($filter['date'])){
				//$filter['date'] = 
			}
			$query = $this->db->get_where($this->table,$filter);
		}else{
			$query = $this->db->get($this->table);
		}
		return $query->num_rows();
	}
	public function insert_purchase_data($data){
		$this->db->insert('purchase_data', $data);
	}
	public function delete_purchase_data_trx($transaction_id){
		$this->db->delete('purchase_data', array('transaction_id' => $transaction_id));
	}
}