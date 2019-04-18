<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';

class Supplier extends CI_Controller {

  function __construct(){
    parent::__construct();

		$this->load->model('SupplierModel');
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
          $id_supplier  	= $this->input->get('id_supplier');
    			$nama_supplier	= $this->input->get('nama_supplier');

          $show  = $this->SupplierModel->show($id_supplier, $nama_supplier);
          $supplier  = array();

          foreach($show->result() as $key){
            $json = array();

            $json['id_supplier']   = $key->id_supplier;
            $json['nama_supplier'] = $key->nama_supplier;
            $json['telepon']       = $key->telepon;
            $json['fax']           = $key->fax;
            $json['email']         = $key->email;
            $json['alamat']        = $key->alamat;
            $json['tgl_input']     = $key->tgl_input;

            $supplier[] = $json;
          }

          json_output(200, array('status' => 200, 'description' => 'Berhasil', 'data' => $supplier));
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

          if($otorisasi->level != 'Admin'){
            json_output(401, array('status' => 401, 'description' => 'Gagal', 'message' => 'Hak akses tidak disetujui'));
          } else {
            $id_supplier    = $this->KodeModel->buatKode('supplier', 'S', 'id_supplier', 5);
            $nama_supplier  = $this->input->post('nama_supplier');
            $telepon        = $this->input->post('telepon');
            $fax            = $this->input->post('fax');
            $email          = $this->input->post('email');
            $alamat         = $this->input->post('alamat');

            if($nama_supplier == null || $telepon == null || $fax == null || $email == null || $alamat == null){
              json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Data yang dikirim tidak lengkap'));
            } else {

              $data = array(
                'id_supplier'   => $id_supplier,
                'nama_supplier' => $nama_supplier,
                'telepon'       => $telepon,
                'fax'           => $fax,
                'email'         => $email,
                'alamat'        => $alamat
              );

              $log = array(
                'user'        => $otorisasi->id_user,
                'id_ref'      => $id_supplier,
                'refrensi'    => 'Supplier',
                'keterangan'  => 'Menambah data supplier baru',
                'kategori'    => 'Add'
              );

              $add = $this->SupplierModel->add($data, $log);

              if(!$add){
                json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal menambah data supplier'));
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

                $pusher->trigger('sipb', 'supplier', $log);
                json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil menambah data supplier'));
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

          if($otorisasi->level != 'Admin'){
            json_output(401, array('status' => 401, 'description' => 'Gagal', 'message' => 'Hak akses tidak disetujui'));
          } else {
            $id_supplier    = $this->input->get('id_supplier');
            $nama_supplier  = $this->input->post('nama_supplier');
            $telepon        = $this->input->post('telepon');
            $fax            = $this->input->post('fax');
            $email          = $this->input->post('email');
            $alamat         = $this->input->post('alamat');

            if($id_supplier == null){
              json_output(401, array('status' => 401, 'description' => 'Gagal', 'message' => 'Tidak ada ID Supplier yang dipilih'));
            } else {
              if($nama_supplier == null || $telepon == null || $fax == null || $email == null || $alamat == null){
                json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Data yang dikirim tidak lengkap'));
              } else {
                $data = array(
                  'nama_supplier' => $nama_supplier,
                  'telepon'       => $telepon,
                  'fax'           => $fax,
                  'email'         => $email,
                  'alamat'        => $alamat
                );

                $log = array(
                  'user'        => $otorisasi->id_user,
                  'id_ref'      => $id_supplier,
                  'refrensi'    => 'Supplier',
                  'keterangan'  => 'Mengedit data supplier',
                  'kategori'    => 'Edit'
                );

                $edit = $this->SupplierModel->edit($id_supplier, $data, $log);

                if(!$edit){
                  json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal mengedit supplier'));
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

                  $pusher->trigger('sipb', 'supplier', $log);
                  json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil mengedit supplier'));
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

          if($otorisasi->level != 'Admin'){
            json_output(401, array('status' => 401, 'description' => 'Gagal', 'message' => 'Hak akses tidak disetujui'));
          } else {
            $id_supplier = $this->input->get('id_supplier');

            if($id_supplier == null){
              json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'ID Supplier tidak ditemukan'));
            } else {
              $log = array(
                'user'        => $otorisasi->id_user,
                'id_ref'      => $id_supplier,
                'refrensi'    => 'Supplier',
                'keterangan'  => 'Menghapus data supplier baru',
                'kategori'    => 'Delete'
              );

              $delete = $this->SupplierModel->delete($id_supplier, $log);

              if(!$delete){
                json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal menghapus supplier'));
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

                $pusher->trigger('sipb', 'supplier', $log);
                json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil menghapus supplier'));
              }
            }
          }
        }
      }
    }
  }


}

?>
