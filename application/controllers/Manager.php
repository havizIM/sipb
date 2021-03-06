<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manager extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

  function index()
  {
    $this->load->view('manager/main');
  }

  function dashboard()
  {
    $this->load->view('manager/dashboard');
  }

  function customer()
  {
    $this->load->view('manager/customer');
  }

  function riwayat($id)
  {
    $this->load->view('manager/detail_customer');
  }

  function barang()
  {
    $this->load->view('manager/barang');
  }

  function pesanan()
  {
    $this->load->view('manager/pesanan');
  }

  function detail_pesanan()
  {
    $this->load->view('manager/detail_pesanan');
  }

  function laporan_pesanan()
  {
    $this->load->view('manager/laporan_pesanan');
  }

  function laporan_stock()
  {
    $this->load->view('manager/laporan_stock');
  }

}
