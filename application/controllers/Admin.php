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

  function edit_stok()
  {
    $this->load->view('admin/edit_stok');
  }

  function supplier()
  {
    $this->load->view('admin/supplier');
  }

}
