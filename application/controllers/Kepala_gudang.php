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

  function customer()
  {
    $this->load->view('kepala_gudang/customer');
  }

  function riwayat($id)
  {
    $this->load->view('kepala_gudang/detail_customer');
  }

  function supplier()
  {
    $this->load->view('kepala_gudang/supplier');
  }

  function pesanan()
  {
    $this->load->view('kepala_gudang/pesanan');
  }

  function detail_pesanan()
  {
    $this->load->view('kepala_gudang/detail_pesanan');
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

  function return_keluar()
  {
    $this->load->view('kepala_gudang/return_keluar');
  }

  function detail_return_keluar()
  {
    $this->load->view('kepala_gudang/detail_return_keluar');
  }

  function return_masuk()
  {
    $this->load->view('kepala_gudang/return_masuk');
  }

  function detail_return_masuk()
  {
    $this->load->view('kepala_gudang/detail_return_masuk');
  }

  function memorandum()
  {
    $this->load->view('kepala_gudang/memorandum');
  }

  function detail_memorandum()
  {
    $this->load->view('kepala_gudang/detail_memorandum');
  }

}
