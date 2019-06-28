<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';

class Return_masuk extends CI_Controller {

  function __construct(){
    parent::__construct();

    $this->options = array(
      'cluster' => 'ap1',
      'useTLS' => true
    );
    $this->pusher = new Pusher\Pusher(
      '6a169a704ab461b9a26a',
      'd5825b3c03af460c453f',
      '745965',
      $this->options
    );

		$this->load->model('RmasukModel');
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

          $otorisasi            = $auth->row();
          $no_return_masuk     = $this->input->get('no_return_masuk');

          $show           = $this->RmasukModel->show($no_return_masuk);
          $return_masuk   = array();

          foreach($show->result() as $key){
            $json = array();

            $json['no_return_masuk']      = $key->no_return_masuk;
            $json['tgl_return']           = $key->tgl_return;
            $json['id_customer']          = $key->id_customer;
            $json['nama_customer']        = $key->nama_customer;
            $json['alamat']               = $key->alamat;
            $json['no_ref']               = $key->no_ref;
            $json['status']               = $key->status;
            $json['id_user']              = $key->id_user;
            $json['nama_user']            = $key->nama_user;

            $return_masuk[] = $json;
          }

          json_output(200, array('status' => 200, 'description' => 'Berhasil', 'data' => $return_masuk));
        }
      }
    }
  }

  function detail($token = null){
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

          $otorisasi            = $auth->row();
          $no_return_masuk     = $this->input->get('no_return_masuk');

          if($no_return_masuk == null){
            json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'No Surat Jalan tidak dipilih'));
          } else {
            $show  = $this->RmasukModel->show($no_return_masuk);
            $show2 = $this->RmasukModel->detail($no_return_masuk);

            $return_masuk   = array();
            $detail         = array();

            foreach($show2->result() as $key){
              $json = array();

              $json['id_dreturn_masuk']   = $key->id_dreturn_masuk;
              $json['id_identifikasi']    = $key->id_identifikasi;
              $json['no_identifikasi']    = $key->no_identifikasi;
              $json['no_persediaan']      = $key->no_persediaan;
              $json['nama_persediaan']    = $key->nama_persediaan;
              $json['keterangan']         = $key->keterangan;
              $json['qty_return_masuk']   = $key->qty_return_masuk;

              $detail[] = $json;
            }

            foreach($show->result() as $key){
              $json = array();

              $json['no_return_masuk']      = $key->no_return_masuk;
              $json['tgl_return']           = $key->tgl_return;
              $json['id_customer']          = $key->id_customer;
              $json['nama_customer']        = $key->nama_customer;
              $json['alamat']               = $key->alamat;
              $json['no_ref']               = $key->no_ref;
              $json['status']               = $key->status;
              $json['id_user']              = $key->id_user;
              $json['nama_user']            = $key->nama_user;
              $json['detail']               = $detail;

              $return_masuk[] = $json;
            }

            json_output(200, array('status' => 200, 'description' => 'Berhasil', 'data' => $return_masuk));
          }
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
            $post                 = $this->input->post();

            $no_return_masuk      = $this->KodeModel->buatKode('return_masuk', 'RTR-M', 'no_return_masuk', 9);
            $no_ref               = $post['no_ref'];
            $id_customer          = $post['id_customer'];
            $status               = 'Proses';

            if($no_ref == null || $id_customer == null){
              json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Data yang dikirim tidak lengkap'));
            } else {
              if(!isset($post['id_identifikasi']) && count($post['id_identifikasi']) < 1){
                json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Pilih barang yang akan dikeluarkan'));
              } else {
                $detail       = array();
                foreach($post['id_identifikasi'] as $key => $val){
                  $detail[] = array(
                    'no_return_masuk'        => $no_return_masuk,
                    'id_identifikasi'        => $post['id_identifikasi'][$key],
                    'qty_return_masuk'       => $post['qty_return_masuk'][$key]
                  );
                }

                $return_barang = array(
                  'no_return_masuk'   => $no_return_masuk,
                  'no_ref'            => $no_ref,
                  'id_customer'       => $id_customer,
                  'status'            => $status,
                  'id_user'           => $otorisasi->id_user
                );

                $log = array(
                  'user'        => $otorisasi->id_user,
                  'id_ref'      => $no_return_masuk,
                  'refrensi'    => 'Return Masuk',
                  'keterangan'  => 'Menambah Data Return Masuk',
                  'kategori'    => 'Add'
                );

                $add = $this->RmasukModel->add($return_barang, $detail, $log);

                if(!$add){
                  json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal menambah data return masuk'));
                } else {
                  $this->pusher->trigger('sipb', 'return_masuk', $log);
                  json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil menambah data return masuk'));
                }
              }
            }
          }
        }
      }
    }
  }


  function edit($token = null){
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
            $post                 = $this->input->post();

            $no_return_masuk      = $this->input->get('no_return_masuk');
            $no_ref               = $post['no_ref'];
            $id_customer          = $post['id_customer'];

            if($no_return_masuk == null){
              json_output(401, array('status' => 400, 'description' => 'Gagal', 'message' => 'No Surat Jalan tidak ditemukan'));
            } else {
              if($no_ref == null || $id_customer == null){
                json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Data yang dikirim tidak lengkap'));
              } else {

                if(!isset($post['id_identifikasi']) && count($post['id_identifikasi']) < 1){
                  json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Pilih barang terlebih dahulu'));
                } else {
                  $detail       = array();
                  foreach($post['id_identifikasi'] as $key => $val){
                    $detail[] = array(
                      'no_return_masuk'    => $no_return_masuk,
                      'id_identifikasi'    => $post['id_identifikasi'][$key],
                      'qty_return_masuk'   => $post['qty_return_masuk'][$key]
                    );
                  }

                  $return_masuk = array(
                    'no_ref'            => $no_ref,
                    'id_customer'       => $id_customer
                  );

                  $log = array(
                    'user'        => $otorisasi->id_user,
                    'id_ref'      => $no_return_masuk,
                    'refrensi'    => 'Return Masuk',
                    'keterangan'  => 'Mengedit data return Masuk',
                    'kategori'    => 'Edit'
                  );

                  $edit = $this->RmasukModel->edit($no_return_masuk, $return_masuk, $detail, $log);

                  if(!$edit){
                    json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal mengedit data return masuk'));
                  } else {
                    $this->pusher->trigger('sipb', 'return_masuk', $log);
                    json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil mengedit data return masuk'));
                  }
                }
              }
            }
          }
        }
      }
    }
  }

  function delete($token = null){
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
            $no_return_masuk = $this->input->get('no_return_masuk');

            if($no_return_masuk == null){
              json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'No Surat Jalan tidak ditemukan'));
            } else {
              $log = array(
                'user'        => $otorisasi->id_user,
                'id_ref'      => $no_return_masuk,
                'refrensi'    => 'Return Masuk',
                'keterangan'  => 'Menghapus Data Return Masuk',
                'kategori'    => 'Delete'
              );

              $delete = $this->RmasukModel->delete($no_return_masuk, $log);

              if(!$delete){
                json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal menghapus return masuk'));
              } else {
                $this->pusher->trigger('sipb', 'return_masuk', $log);
                json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil menghapus return masuk'));
              }
            }
          }
        }
      }
    }
  }

  function approve($token = null){
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

          if($otorisasi->level != 'Kepala Gudang'){
            json_output(401, array('status' => 401, 'description' => 'Gagal', 'message' => 'Hak akses tidak disetujui'));
          } else {
            $no_return_masuk = $this->input->get('no_return_masuk');

            if($no_return_masuk == null){
              json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'No Surat Jalan tidak ditemukan'));
            } else {
              $data = array(
                'status' => 'Disetujui'
              );

              $log = array(
                'user'        => $otorisasi->id_user,
                'id_ref'      => $no_return_masuk,
                'refrensi'    => 'Return masuk',
                'keterangan'  => 'Menyetujui Data Return masuk',
                'kategori'    => 'Approve'
              );

              $approve = $this->RmasukModel->edit_status($no_return_masuk, $data, $log);

              if(!$approve){
                json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal menyetujui return masuk'));
              } else {
                $this->pusher->trigger('sipb', 'return_masuk', $log);
                json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil menyetujui return masuk'));
              }
            }
          }
        }
      }
    }
  }

}

?>
