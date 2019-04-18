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

}
