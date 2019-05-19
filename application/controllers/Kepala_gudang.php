<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kepala_gudang extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

  function index()
  {
    $this->load->view('kepala_gudang/main');
  }

  function dashboard()
  {
    $this->load->view('kepala_gudang/dashboard');
  }

  function barang()
  {
    $this->load->view('kepala_gudang/barang');
  }

  function stok()
  {
    $this->load->view('kepala_gudang/stok');
  }

  function supplier()
  {
    $this->load->view('kepala_gudang/supplier');
  }

  function pesanan()
  {
    $this->load->view('kepala_gudang/pesanan');
  }

  function cetak_pesanan()
  {
    $this->load->view('kepala_gudang/cetak_pesanan');
  }

  function barang_keluar()
  {
    $this->load->view('kepala_gudang/barang_keluar');
  }

  function detail_barang_keluar()
  {
    $this->load->view('kepala_gudang/detail_barang_keluar');
  }

  function barang_masuk()
  {
    $this->load->view('kepala_gudang/barang_masuk');
  }

  function detail_barang_masuk()
  {
    $this->load->view('kepala_gudang/detail_barang_masuk');
  }

}
