<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier_model extends CI_Model {
	function __construct(){
        parent::__construct();
	}
	
	public function get_all(){
		$query = $this->db->get("supplier");
		return $query->result();
	}
	public function get_last_id(){
		$this->db->order_by('id', 'DESC');

		$query = $this->db->get("supplier",1,0);
		return $query->result();
	}
	public function insert($data){
		$this->db->insert('supplier', $data);
	}
	public function update($id,$data){
		$this->db->where('id', $id);
		$this->db->update('supplier', $data);
	}
	public function get_by_id($id){
		$response = false;
		$query = $this->db->get_where('supplier',array('id' => $id));
		if($query && $query->num_rows()){
			$response = $query->result_array();
		}
		return $response;
	}
	public function delete($id){
		$this->db->delete('supplier', array('id' => $id));
	}
}