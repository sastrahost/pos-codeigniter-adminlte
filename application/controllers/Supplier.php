<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier extends MY_Controller {
	function __construct(){
        parent::__construct();
		$this->load->model('supplier_model');
        $this->load->library('form_validation');
		
		// Check Session Login
		if(!isset($_SESSION['logged_in'])){
			redirect(site_url('auth/login'));
		}
	}
	
	public function index(){
		if(isset($_GET['search'])){
			$filter = array();
			if(!empty($_GET['value']) && $_GET['value'] != ''){
				$filter[$_GET['search_by'].' LIKE'] = "%".$_GET['value']."%";
			}

			$total_row = $this->supplier_model->count_total_filter($filter);
			$data['suppliers'] = $this->supplier_model->get_filter($filter,url_param());
		}else{
			$total_row = $this->supplier_model->count_total();
			$data['suppliers'] = $this->supplier_model->get_all(url_param());
		}
		$data['paggination'] = get_paggination($total_row,get_search());

		$this->load->view('supplier/index',$data);
	}
	
	public function create(){
		$code_supplier = $this->supplier_model->get_last_id();
		if($code_supplier){
			$id = $code_supplier[0]->id;
			$data['code_supplier'] = generate_code('SUP',$id);
		}else{
			$data['code_supplier'] = 'SUP001';
		}
		
		$this->load->view('supplier/form',$data);
	}

	public function edit($id = ''){
		$check_id = $this->supplier_model->get_by_id($id);
		if($check_id){
			$data['supplier'] = $check_id[0];
			$this->load->view('supplier/form',$data);
		}else{
			redirect(site_url('supplier'));
		}
	}

	public function save($id = ''){
		$this->form_validation->set_rules('supplier_id', 'ID', 'required');
		$this->form_validation->set_rules('supplier_name', 'Nama', 'required');
		$this->form_validation->set_rules('supplier_date', 'Tanggal', 'required');

		$data['id'] = escape($this->input->post('supplier_id'));
		$data['supplier_name'] = escape($this->input->post('supplier_name'));
		$data['supplier_phone'] = escape($this->input->post('supplier_phone'));
		$data['supplier_address'] = escape($this->input->post('supplier_address'));
		$data['date'] = escape($this->input->post('supplier_date'));

		if ($this->form_validation->run() != FALSE && !empty($id)) {
			// EDIT
			$check_id = $this->supplier_model->get_by_id($id);
			if($check_id){
				unset($data['id']);
				$this->supplier_model->update($id,$data);
			}
		}elseif($this->form_validation->run() != FALSE && empty($id)){
			// INSERT NEW
			$this->supplier_model->insert($data);
		}else{
			$this->session->set_flashdata('form_false', 'Harap periksa form anda.');
			redirect(site_url('supplier/create'));
		}
		redirect(site_url('supplier'));
	}
	public function delete($id){
		$check_id = $this->supplier_model->get_by_id($id);
		if($check_id){
			$this->supplier_model->delete($id);
		}
		redirect(site_url('supplier'));
	}
	public function export_csv(){
		$data = $this->supplier_model->get_all_array();
		$this->csv_library->export('supplier.csv',$data);
	}
}
