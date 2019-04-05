<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Helpdesk extends CI_Controller{

  public function __construct()
  {
    parent::__construct();
    //Codeigniter : Write Less Do More
  }

  function index()
  {
    $this->load->view('helpdesk/main');
  }

  function dashboard()
  {
    $this->load->view('helpdesk/dashboard');
  }

  function user()
  {
    $this->load->view('helpdesk/user');
  }

  function log()
  {
    $this->load->view('helpdesk/log');
  }

}
