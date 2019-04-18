<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';

class Customer extends CI_Controller {

  function __construct(){
    parent::__construct();

		$this->load->model('CustomerModel');
  }

  function show($token = null){
    $method = $_SERVER['REQUEST_METHOD'];

    if ($method != 'GET') {
      json_output(401, array('status' => 401, 'description' => 'Gagal', 'message' => 'Metode request salah'));
		} else {

      if($token == null){
        json_output(401, array('status' => 401, 'description' => 'Gagal', 'message' => 'Request tidak terotorisasi'));
      } else {
        $auth = $this->AuthModel->cekAuth($token);

        if($auth->num_rows() != 1){
          json_output(401, array('status' => 401, 'description' => 'Gagal', 'message' => 'Token tidak dikenali'));
        } else {

          $otorisasi      = $auth->row();
          $id_customer  	= $this->input->get('id_customer');
    			$nama_customer	= $this->input->get('nama_customer');

          $show  = $this->CustomerModel->show($id_customer, $nama_customer);
          $customer  = array();

          foreach($show->result() as $key){
            $json = array();

            $json['id_customer']   = $key->id_customer;
            $json['nama_customer'] = $key->nama_customer;
            $json['telepon']       = $key->telepon;
            $json['fax']           = $key->fax;
            $json['email']         = $key->email;
            $json['alamat']        = $key->alamat;
            $json['tgl_input']     = $key->tgl_input;

            $customer[] = $json;
          }

          json_output(200, array('status' => 200, 'description' => 'Berhasil', 'data' => $customer));
        }
      }
    }
  }

  function add($token = null){
    $method = $_SERVER['REQUEST_METHOD'];

    if ($method != 'POST') {
			json_output(401, array('status' => 401, 'description' => 'Gagal', 'message' => 'Metode request salah'));
		} else {

      if($token == null){
        json_output(401, array('status' => 401, 'description' => 'Gagal', 'message' => 'Request tidak terotorisasi'));
      } else {
        $auth = $this->AuthModel->cekAuth($token);

        if($auth->num_rows() != 1){
          json_output(401, array('status' => 401, 'description' => 'Gagal', 'message' => 'Token tidak dikenali'));
        } else {

          $otorisasi = $auth->row();

          if($otorisasi->level != 'Sales'){
            json_output(401, array('status' => 401, 'description' => 'Gagal', 'message' => 'Hak akses tidak disetujui'));
          } else {
            $id_customer    = $this->KodeModel->buatKode('customer', 'C', 'id_customer', 5);
            $nama_customer  = $this->input->post('nama_customer');
            $telepon        = $this->input->post('telepon');
            $fax            = $this->input->post('fax');
            $email          = $this->input->post('email');
            $alamat         = $this->input->post('alamat');

            if($nama_customer == null || $telepon == null || $fax == null || $email == null || $alamat == null){
              json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Data yang dikirim tidak lengkap'));
            } else {

              $data = array(
                'id_customer'   => $id_customer,
                'nama_customer' => $nama_customer,
                'telepon'       => $telepon,
                'fax'           => $fax,
                'email'         => $email,
                'alamat'        => $alamat
              );

              $log = array(
                'user'        => $otorisasi->id_user,
                'id_ref'      => $id_customer,
                'refrensi'    => 'Customer',
                'keterangan'  => 'Menambah data customer baru',
                'kategori'    => 'Add'
              );

              $add = $this->CustomerModel->add($data, $log);

              if(!$add){
                json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal menambah data customer'));
              } else {
                $options = array(
                  'cluster' => 'ap1',
                  'useTLS' => true
                );
                $pusher = new Pusher\Pusher(
                  '6a169a704ab461b9a26a',
                  'd5825b3c03af460c453f',
                  '745965',
                  $options
                );

                $pusher->trigger('sipb', 'customer', $log);
                json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil menambah data customer'));
              }
            }
          }
        }
      }
    }
  }

  public function edit($token = null){
    $method = $_SERVER['REQUEST_METHOD'];

    if ($method != 'POST') {
			json_output(401, array('status' => 401, 'description' => 'Gagal', 'message' => 'Metode request salah'));
		} else {

      if($token == null){
        json_output(401, array('status' => 401, 'description' => 'Gagal', 'message' => 'Request tidak terotorisasi'));
      } else {
        $auth = $this->AuthModel->cekAuth($token);

        if($auth->num_rows() != 1){
          json_output(401, array('status' => 401, 'description' => 'Gagal', 'message' => 'Token tidak dikenali'));
        } else {
          $otorisasi = $auth->row();

          if($otorisasi->level != 'Sales'){
            json_output(401, array('status' => 401, 'description' => 'Gagal', 'message' => 'Hak akses tidak disetujui'));
          } else {
            $id_customer    = $this->input->get('id_customer');
            $nama_customer  = $this->input->post('nama_customer');
            $telepon        = $this->input->post('telepon');
            $fax            = $this->input->post('fax');
            $email          = $this->input->post('email');
            $alamat         = $this->input->post('alamat');

            if($id_customer == null){
              json_output(401, array('status' => 401, 'description' => 'Gagal', 'message' => 'Tidak ada ID Customer yang dipilih'));
            } else {
              if($nama_customer == null || $telepon == null || $fax == null || $email == null || $alamat == null){
                json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Data yang dikirim tidak lengkap'));
              } else {
                $data = array(
                  'nama_customer' => $nama_customer,
                  'telepon'       => $telepon,
                  'fax'           => $fax,
                  'email'         => $email,
                  'alamat'        => $alamat
                );

                $log = array(
                  'user'        => $otorisasi->id_user,
                  'id_ref'      => $id_customer,
                  'refrensi'    => 'Customer',
                  'keterangan'  => 'Mengedit data customer',
                  'kategori'    => 'Edit'
                );

                $edit = $this->CustomerModel->edit($id_customer, $data, $log);

                if(!$edit){
                  json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal mengedit customer'));
                } else {
                  $options = array(
                    'cluster' => 'ap1',
                    'useTLS' => true
                  );
                  $pusher = new Pusher\Pusher(
                    '6a169a704ab461b9a26a',
                    'd5825b3c03af460c453f',
                    '745965',
                    $options
                  );

                  $pusher->trigger('sipb', 'customer', $log);
                  json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil mengedit customer'));
                }
              }
            }
          }
        }
      }
    }
  }

  public function delete($token = null){
    $method = $_SERVER['REQUEST_METHOD'];

    if ($method != 'GET') {
			json_output(401, array('status' => 401, 'description' => 'Gagal', 'message' => 'Metode request salah'));
		} else {
      if($token == null){
        json_output(401, array('status' => 401, 'description' => 'Gagal', 'message' => 'Request tidak terotorisasi'));
      } else {
        $auth = $this->AuthModel->cekAuth($token);

        if($auth->num_rows() != 1){
          json_output(401, array('status' => 401, 'description' => 'Gagal', 'message' => 'Token tidak dikenali'));
        } else {

          $otorisasi = $auth->row();

          if($otorisasi->level != 'Sales'){
            json_output(401, array('status' => 401, 'description' => 'Gagal', 'message' => 'Hak akses tidak disetujui'));
          } else {
            $id_customer = $this->input->get('id_customer');

            if($id_customer == null){
              json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'ID Customer tidak ditemukan'));
            } else {
              $log = array(
                'user'        => $otorisasi->id_user,
                'id_ref'      => $id_customer,
                'refrensi'    => 'Customer',
                'keterangan'  => 'Menghapus data customer baru',
                'kategori'    => 'Delete'
              );

              $delete = $this->CustomerModel->delete($id_customer, $log);

              if(!$delete){
                json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal menghapus customer'));
              } else {
                $options = array(
                  'cluster' => 'ap1',
                  'useTLS' => true
                );
                $pusher = new Pusher\Pusher(
                  '6a169a704ab461b9a26a',
                  'd5825b3c03af460c453f',
                  '745965',
                  $options
                );

                $pusher->trigger('sipb', 'customer', $log);
                json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil menghapus customer'));
              }
            }
          }
        }
      }
    }
  }


}

?>
