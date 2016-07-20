<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelanggan extends MY_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('pelanggan_model');
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
            
            $total_row = $this->pelanggan_model->count_total_filter($filter);
            $data['pelanggans'] = $this->pelanggan_model->get_filter($filter,url_param());
        }else{
            $total_row = $this->pelanggan_model->count_total();
            $data['pelanggans'] = $this->pelanggan_model->get_all(url_param());
        }
        $data['paggination'] = get_paggination($total_row,get_search());

        $this->load->view('pelanggan/index',$data);
    }

    public function create(){
        $code_supplier = $this->pelanggan_model->get_last_id();
        if($code_supplier){
            $id = $code_supplier[0]->id;
            $data['code_pelanggan'] = generate_code('CUST',$id,4);
        }else{
            $data['code_pelanggan'] = 'CUST0001';
        }

        $this->load->view('pelanggan/form',$data);
    }

    public function edit($id = ''){
        $check_id = $this->pelanggan_model->get_by_id($id);
        if($check_id){
            $data['pelanggan'] = $check_id[0];
            $this->load->view('pelanggan/form',$data);
        }else{
            redirect(site_url('pelanggan'));
        }
    }

    public function save($id = ''){
        $this->form_validation->set_rules('customer_id', 'ID', 'required');
        $this->form_validation->set_rules('customer_name', 'Nama', 'required');
        $this->form_validation->set_rules('customer_date', 'Tanggal', 'required');

        $data['id'] = escape($this->input->post('customer_id'));
        $data['customer_name'] = escape($this->input->post('customer_name'));
        $data['customer_phone'] = escape($this->input->post('customer_phone'));
        $data['customer_address'] = escape($this->input->post('customer_address'));
        $data['date'] = escape($this->input->post('customer_date'));

        if ($this->form_validation->run() != FALSE && !empty($id)) {
            // EDIT
            $check_id = $this->pelanggan_model->get_by_id($id);
            if($check_id){
                unset($data['id']);
                $this->pelanggan_model->update($id,$data);
            }
        }elseif($this->form_validation->run() != FALSE && empty($id)){
            // INSERT NEW
            $this->pelanggan_model->insert($data);
        }else{
            $this->session->set_flashdata('form_false', 'Harap periksa form anda.');
            redirect(site_url('pelanggan/create'));
        }
        redirect(site_url('pelanggan'));
    }
    public function delete($id){
        $check_id = $this->pelanggan_model->get_by_id($id);
        if($check_id){
            $this->pelanggan_model->delete($id);
        }
        redirect(site_url('pelanggan'));
    }
    public function export_csv(){
        $filter = false;
        if(isset($_GET['search'])) {
            if (!empty($_GET['value']) && $_GET['value'] != '') {
                $filter[$_GET['search_by'] . ' LIKE'] = "%" . $_GET['value'] . "%";
            }
        }
        $data = $this->pelanggan_model->get_all_array($filter);
        $this->csv_library->export('pelanggan.csv',$data);
    }
}
