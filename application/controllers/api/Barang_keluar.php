<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';

class Barang_keluar extends CI_Controller {

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

		$this->load->model('BkeluarModel');
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

          $otorisasi     = $auth->row();
          $no_keluar     = $this->input->get('no_keluar');

          $show           = $this->BkeluarModel->show($no_keluar);
          $barang_keluar  = array();

          foreach($show->result() as $key){
            $json = array();

            $json['no_keluar']     = $key->no_keluar;
            $json['tgl_keluar']    = $key->tgl_keluar;
            $json['id_customer']   = $key->id_customer;
            $json['nama_customer'] = $key->nama_customer;
            $json['alamat_kirim']  = $key->alamat_kirim;
            $json['no_sp']         = $key->no_sp;
            $json['ekspedisi']     = $key->ekspedisi;
            $json['no_truk']       = $key->no_truk;
            $json['status']        = $key->status;
            $json['id_user']       = $key->id_user;
            $json['nama_user']     = $key->nama_user;

            $barang_keluar[] = $json;
          }

          json_output(200, array('status' => 200, 'description' => 'Berhasil', 'data' => $barang_keluar));
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

          $otorisasi     = $auth->row();
          $no_keluar     = $this->input->get('no_keluar');

          if($no_keluar == null){
            json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'No Surat Jalan tidak dipilih'));
          } else {
            $show  = $this->BkeluarModel->show($no_keluar);
            $show2 = $this->BkeluarModel->detail($no_keluar);

            $barang_keluar = array();
            $detail        = array();

            foreach($show2->result() as $key){
              $json = array();

              $json['id_keluar_detail'] = $key->id_keluar_detail;
              $json['id_identifikasi']  = $key->id_identifikasi;
              $json['no_identifikasi']  = $key->no_identifikasi;
              $json['no_persediaan']    = $key->no_persediaan;
              $json['nama_persediaan']  = $key->nama_persediaan;
              $json['keterangan']       = $key->keterangan;
              $json['qty_keluar']       = $key->qty_keluar;

              $detail[] = $json;
            }

            foreach($show->result() as $key){
              $json = array();

              $json['no_keluar']     = $key->no_keluar;
              $json['tgl_keluar']    = $key->tgl_keluar;
              $json['id_customer']   = $key->id_customer;
              $json['nama_customer'] = $key->nama_customer;
              $json['alamat_kirim']  = $key->alamat_kirim;
              $json['no_sp']         = $key->no_sp;
              $json['ekspedisi']     = $key->ekspedisi;
              $json['no_truk']       = $key->no_truk;
              $json['status']        = $key->status;
              $json['id_user']       = $key->id_user;
              $json['nama_user']     = $key->nama_user;
              $json['detail']        = $detail;

              $barang_keluar[] = $json;
            }

            json_output(200, array('status' => 200, 'description' => 'Berhasil', 'data' => $barang_keluar));
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
            $post           = $this->input->post();

            $no_keluar     = $this->KodeModel->buatKode('barang_keluar', 'BK', 'no_keluar', 9);
            $id_customer   = $post['id_customer'];
            $alamat_kirim  = $post['alamat_kirim'];
            $no_sp         = $post['no_sp'];
            $ekspedisi     = $post['ekspedisi'];
            $no_truk       = $post['no_truk'];
            $status        = 'Proses';

            if($id_customer == null || $no_sp == null || $alamat_kirim == null || $ekspedisi == null || $no_truk == null || $status == null){
              json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Data yang dikirim tidak lengkap'));
            } else {
              if(!isset($post['id_identifikasi']) && count($post['id_identifikasi']) < 1){
                json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Pilih barang yang akan dikeluarkan'));
              } else {
                $detail       = array();
                foreach($post['id_identifikasi'] as $key => $val){
                  $detail[] = array(
                    'no_keluar'        => $no_keluar,
                    'id_identifikasi'  => $post['id_identifikasi'][$key],
                    'qty_keluar'       => $post['qty_keluar'][$key]
                  );
                }

                $barang_keluar = array(
                  'no_keluar'     => $no_keluar,
                  'id_customer'   => $id_customer,
                  'alamat_kirim'  => $alamat_kirim,
                  'no_sp'         => $no_sp,
                  'ekspedisi'     => $ekspedisi,
                  'no_truk'       => $no_truk,
                  'status'        => $status,
                  'id_user'       => $otorisasi->id_user
                );

                $log = array(
                  'user'        => $otorisasi->id_user,
                  'id_ref'      => $no_keluar,
                  'refrensi'    => 'Barang Keluar',
                  'keterangan'  => 'Menambah Data Barang Keluar',
                  'kategori'    => 'Add'
                );

                $add = $this->BkeluarModel->add($barang_keluar, $detail, $log);

                if(!$add){
                  json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal menambah data barang keluar'));
                } else {
                  $this->pusher->trigger('sipb', 'barang_keluar', $log);
                  json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil menambah data barang keluar'));
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
            $post           = $this->input->post();

            $no_keluar     = $this->input->get('no_keluar');
            $id_customer   = $post['id_customer'];
            $alamat_kirim  = $post['alamat_kirim'];
            $no_sp         = $post['no_sp'];
            $ekspedisi     = $post['ekspedisi'];
            $no_truk       = $post['no_truk'];

            if($no_keluar == null){
              json_output(401, array('status' => 400, 'description' => 'Gagal', 'message' => 'No Surat Jalan tidak ditemukan'));
            } else {
              if($id_customer == null || $alamat_kirim == null || $no_sp == null || $ekspedisi == null || $no_truk == null){
                json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Data yang dikirim tidak lengkap'));
              } else {

                if(!isset($post['id_identifikasi']) && count($post['id_identifikasi']) < 1){
                  json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Pilih barang terlebih dahulu'));
                } else {
                  $detail       = array();
                  foreach($post['id_identifikasi'] as $key => $val){
                    $detail[] = array(
                      'no_keluar'       => $no_keluar,
                      'id_identifikasi' => $post['id_identifikasi'][$key],
                      'qty_keluar'      => $post['qty_keluar'][$key]
                    );
                  }

                  $barang_keluar = array(
                    'id_customer'   => $id_customer,
                    'alamat_kirim'  => $alamat_kirim,
                    'no_sp'         => $no_sp,
                    'ekspedisi'     => $ekspedisi,
                    'no_truk'       => $no_truk,
                    'id_user'       => $otorisasi->id_user
                  );

                  $log = array(
                    'user'        => $otorisasi->id_user,
                    'id_ref'      => $no_keluar,
                    'refrensi'    => 'Barang Keluar',
                    'keterangan'  => 'Mengedit data barang keluar',
                    'kategori'    => 'Edit'
                  );

                  $edit = $this->BkeluarModel->edit($no_keluar, $barang_keluar, $detail, $log);

                  if(!$edit){
                    json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal mengedit data barang_keluar'));
                  } else {
                    $this->pusher->trigger('sipb', 'barang_keluar', $log);
                    json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil mengedit data barang_keluar'));
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
            $no_keluar = $this->input->get('no_keluar');

            if($no_keluar == null){
              json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'No Surat Jalan tidak ditemukan'));
            } else {
              $log = array(
                'user'        => $otorisasi->id_user,
                'id_ref'      => $no_keluar,
                'refrensi'    => 'Barang Keluar',
                'keterangan'  => 'Menghapus Data Barang Keluar',
                'kategori'    => 'Delete'
              );

              $delete = $this->BkeluarModel->delete($no_keluar, $log);

              if(!$delete){
                json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal menghapus barang keluar'));
              } else {
                $this->pusher->trigger('sipb', 'barang_keluar', $log);
                json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil menghapus barang keluar'));
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
            $no_keluar = $this->input->get('no_keluar');

            if($no_keluar == null){
              json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'No Surat Jalan tidak ditemukan'));
            } else {
              $data = array(
                'status' => 'Disetujui'
              );

              $log = array(
                'user'        => $otorisasi->id_user,
                'id_ref'      => $no_keluar,
                'refrensi'    => 'Barang keluar',
                'keterangan'  => 'Menyetujui Data Barang Keluar',
                'kategori'    => 'Approve'
              );

              $approve = $this->BkeluarModel->edit_status($no_keluar, $data, $log);

              if(!$approve){
                json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal menyetujui barang keluar'));
              } else {
                $this->pusher->trigger('sipb', 'barang_keluar', $log);
                json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil menyetujui barang keluar'));
              }
            }
          }
        }
      }
    }
  }

}

?>
