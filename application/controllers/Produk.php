<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk extends MY_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('produk_model');
        $this->load->library('form_validation');

        $this->load->model('kategori_model');
        
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

            $total_row = $this->produk_model->count_total_filter($filter);
            $data['produks'] = $this->produk_model->get_filter($filter,url_param());
        }else{
            $total_row = $this->produk_model->count_total();
            $data['produks'] = $this->produk_model->get_all(url_param());
        }
        $data['paggination'] = get_paggination($total_row,get_search());
        
        $this->load->view('produk/index',$data);
    }

    public function create(){
        $data['category'] = $this->kategori_model->get_all();
        $this->load->view('produk/form',$data);
    }

    public function check_id(){
        $id = $this->input->post('id');
        $check_id = $this->produk_model->get_by_id($id);
        if(!$check_id){
            echo "available";
        }else{
            echo "unavailable";
        }
    }

    public function edit($id = ''){
        $check_id = $this->produk_model->get_by_id($id);
        if($check_id){
            $data['category'] = $this->kategori_model->get_all();
            $data['produk'] = $check_id[0];
            $this->load->view('produk/form',$data);
        }else{
            redirect(site_url('produk'));
        }
    }

    public function save($id = ''){
        $this->form_validation->set_rules('product_id', 'ID', 'required');
        $this->form_validation->set_rules('product_name', 'Nama', 'required');
        $this->form_validation->set_rules('category_id', 'Kategori', 'required');
        $this->form_validation->set_rules('sale_price', 'Harga', 'required');
        $this->form_validation->set_rules('product_date', 'Tanggal', 'required');

        $data['id'] = escape($this->input->post('product_id'));
        $data['product_name'] = escape($this->input->post('product_name'));
        $data['category_id'] = escape($this->input->post('category_id'));
        $data['product_desc'] = escape($this->input->post('product_desc'));
        $data['sale_price'] = escape($this->input->post('sale_price'));
        $data['sale_price_type1'] = escape($this->input->post('sale_price_type1'));
        $data['sale_price_type2'] = escape($this->input->post('sale_price_type2'));
        $data['sale_price_type3'] = escape($this->input->post('sale_price_type3'));
        $data['date'] = escape($this->input->post('product_date'));

        if ($this->form_validation->run() != FALSE && !empty($id)) {
            // EDIT
            $check_id = $this->produk_model->get_by_id($id);
            if($check_id){
                unset($data['id']);
                $this->produk_model->update($id,$data);
            }
        }elseif($this->form_validation->run() != FALSE && empty($id)){
            // INSERT NEW
            $this->produk_model->insert($data);
        }else{
            $this->session->set_flashdata('form_false', 'Harap periksa form anda.');
            redirect(site_url('produk/create'));
        }
        redirect(site_url('produk'));
    }
    public function delete($id){
        $check_id = $this->produk_model->get_by_id($id);
        if($check_id){
            $this->produk_model->delete($id);
        }
        redirect(site_url('produk'));
    }
    public function export_csv(){
        $data = $this->produk_model->get_all_array();
        $this->csv_library->export('produk.csv',$data);
    }
}
