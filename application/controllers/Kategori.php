<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori extends MY_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model('kategori_model');
        $this->load->library('form_validation');

        // Check Session Login
        if(!isset($_SESSION['logged_in'])){
            redirect(site_url('auth/login'));
        }
    }

    public function index(){
        if(isset($_GET['search'])){
            $filter = array();
            if(!empty($_GET['id']) && $_GET['id'] != ''){
                $filter['id'] = $_GET['id'];
            }

            if(!empty($_GET['kategori_name']) && $_GET['kategori_name'] != ''){
                $filter['category_name'] = $_GET['kategori_name'];
            }
            $total_row = $this->kategori_model->count_total_filter($filter);
            
            $result = $this->kategori_model->get_filter($filter,url_param());
            $data['kategoris'] = $result;
        }else{
            $total_row = $this->kategori_model->count_total();
            
            $result = $this->kategori_model->get_all(url_param());
            $data['kategoris'] = $result;
        }
        $data['paggination'] = get_paggination($total_row,get_search());

        $this->load->view('kategori/index',$data);
    }

    public function create(){
        $this->load->view('kategori/form');
    }

    public function check_id(){
        $id = $this->input->post('id');
        $check_id = $this->kategori_model->get_by_id($id);
        if(!$check_id){
            echo "available";
        }else{
            echo "unavailable";
        }
    }

    public function edit($id = ''){
        $check_id = $this->kategori_model->get_by_id($id);
        if($check_id){
            $data['kategori'] = $check_id[0];
            $this->load->view('kategori/form',$data);
        }else{
            redirect(site_url('kategori'));
        }
    }

    public function save($id = ''){
        $this->form_validation->set_rules('category_id', 'ID', 'required');
        $this->form_validation->set_rules('category_name', 'Nama', 'required');
        $this->form_validation->set_rules('category_date', 'Tanggal', 'required');

        $data['id'] = escape($this->input->post('category_id'));
        $data['category_name'] = escape($this->input->post('category_name'));
        $data['category_desc'] = escape($this->input->post('category_desc'));
        $data['date'] = escape($this->input->post('category_date'));

        if ($this->form_validation->run() != FALSE && !empty($id)) {
            // EDIT
            $check_id = $this->kategori_model->get_by_id($id);
            if($check_id){
                unset($data['id']);
                $this->kategori_model->update($id,$data);
            }
        }elseif($this->form_validation->run() != FALSE && empty($id)){
            // INSERT NEW
            $this->kategori_model->insert($data);
        }else{
            $this->session->set_flashdata('form_false', 'Harap periksa form anda.');
            redirect(site_url('kategori/create'));
        }
        redirect(site_url('kategori'));
    }
    public function delete($id){
        $check_id = $this->kategori_model->get_by_id($id);
        if($check_id){
            $this->kategori_model->delete($id);
        }
        redirect(site_url('pelanggan'));
    }
    public function export_csv(){
        $data = $this->kategori_model->get_all_array();
        $this->csv_library->export('pelanggan.csv',$data);
    }
}
