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

}