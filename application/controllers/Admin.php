<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

  function index()
  {
    $this->load->view('admin/main');
  }

  function dashboard()
  {
    $this->load->view('admin/dashboard');
  }

  function barang()
  {
    $this->load->view('admin/barang');
  }

  function stok()
  {
    $this->load->view('admin/stok');
  }

  function add_stok()
  {
    $this->load->view('admin/add_stok');
  }

  function edit_stok($id)
  {
    $this->load->view('admin/edit_stok');
  }

  function supplier()
  {
    $this->load->view('admin/supplier');
  }

  function customer()
  {
    $this->load->view('admin/customer');
  }

  function pesanan()
  {
    $this->load->view('admin/pesanan');
  }

  function detail_pesanan()
  {
    $this->load->view('admin/detail_pesanan');
  }

  function barang_keluar()
  {
    $this->load->view('admin/barang_keluar');
  }

  function add_barang_keluar()
  {
    $this->load->view('admin/add_barang_keluar');
  }

  function edit_barang_keluar($id)
  {
    $this->load->view('admin/edit_barang_keluar');
  }

  function detail_barang_keluar()
  {
    $this->load->view('admin/detail_barang_keluar');
  }

  function barang_masuk()
  {
    $this->load->view('admin/barang_masuk');
  }

  function add_barang_masuk()
  {
    $this->load->view('admin/add_barang_masuk');
  }

  function edit_barang_masuk($id)
  {
    $this->load->view('admin/edit_barang_masuk');
  }

  function detail_barang_masuk()
  {
    $this->load->view('admin/detail_barang_masuk');
  }

  function return_keluar()
  {
    $this->load->view('admin/return_keluar');
  }

  function add_return_keluar()
  {
    $this->load->view('admin/add_return_keluar');
  }

  function edit_return_keluar($id)
  {
    $this->load->view('admin/edit_return_keluar');
  }

  function detail_return_keluar()
  {
    $this->load->view('admin/detail_return_keluar');
  }

  function return_masuk()
  {
    $this->load->view('admin/return_masuk');
  }

  function add_return_masuk()
  {
    $this->load->view('admin/add_return_masuk');
  }

  function edit_return_masuk()
  {
    $this->load->view('admin/edit_return_masuk');
  }

  function detail_return_masuk()
  {
    $this->load->view('admin/detail_return_masuk');
  }

  function memorandum()
  {
    $this->load->view('admin/memorandum');
  }

  function add_memorandum()
  {
    $this->load->view('admin/add_memorandum');
  }

  function edit_memorandum($id)
  {
    $this->load->view('admin/edit_memorandum');
  }

  function detail_memorandum()
  {
    $this->load->view('admin/detail_memorandum');
  }

}
