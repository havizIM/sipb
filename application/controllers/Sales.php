<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

  function index()
  {
    $this->load->view('sales/main');
  }

  function dashboard()
  {
    $this->load->view('sales/dashboard');
  }

  function barang()
  {
    $this->load->view('sales/barang');
  }

  function customer()
  {
    $this->load->view('sales/customer');
  }

  function riwayat($id)
  {
    $this->load->view('sales/detail_customer');
  }

  function pesanan()
  {
    $this->load->view('sales/pesanan');
  }

  function add_pesanan()
  {
    $this->load->view('sales/add_pesanan');
  }

  function edit_pesanan($id)
  {
    $this->load->view('sales/edit_pesanan');
  }

  function detail_pesanan($id)
  {
    $this->load->view('sales/detail_pesanan');
  }

}
