<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori_model extends CI_Model {
	function __construct(){
        parent::__construct();
	}
	
	public function get_all(){
		$query = $this->db->get("category");
		return $query->result();
	}
	public function get_all_array(){
		$query = $this->db->get("category");
		return $query->result_array();
	}
	public function get_last_id(){
		$this->db->order_by('id', 'DESC');

		$query = $this->db->get("category",1,0);
		return $query->result();
	}
	public function insert($data){
		$this->db->insert('category', $data);
	}
	public function update($id,$data){
		$this->db->where('id', $id);
		$this->db->update('category', $data);
	}
	public function get_by_id($id){
		$response = false;
		$query = $this->db->get_where('category',array('id' => $id));
		if($query && $query->num_rows()){
			$response = $query->result_array();
		}
		return $response;
	}
	public function delete($id){
		$this->db->delete('category', array('id' => $id));
	}
	public function get_filter($filter = ''){
		if(!empty($filter)){
			$query = $this->db->get_where("category",$filter);
		}else{
			$query = $this->db->get("category");
		}
		return $query->result();
	}
}