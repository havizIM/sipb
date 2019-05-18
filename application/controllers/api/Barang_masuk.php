<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';

class Barang_masuk extends CI_Controller {

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

		$this->load->model('BmasukModel');
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
          $no_masuk      = $this->input->get('no_masuk');

          $show           = $this->BmasukModel->show($no_masuk);
          $barang_masuk   = array();

          foreach($show->result() as $key){
            $json = array();

            $json['no_masuk']       = $key->no_masuk;
            $json['no_surat']       = $key->no_surat;
            $json['no_po']          = $key->no_po;
            $json['tgl_masuk']      = $key->tgl_masuk;
            $json['id_supplier']    = $key->id_supplier;
            $json['nama_supplier']  = $key->nama_supplier;
            $json['telepon']        = $key->telepon;
            $json['fax']            = $key->fax;
            $json['email']          = $key->email;
            $json['alamat']         = $key->alamat;
            $json['tgl_masuk']      = $key->tgl_masuk;
            $json['status']         = $key->status;
            $json['id_user']        = $key->id_user;
            $json['nama_user']      = $key->nama_user;

            $barang_masuk[] = $json;
          }

          json_output(200, array('status' => 200, 'description' => 'Berhasil', 'data' => $barang_masuk));
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
          $no_masuk     = $this->input->get('no_masuk');

          if($no_masuk == null){
            json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'No Surat Jalan tidak dipilih'));
          } else {
            $show  = $this->BmasukModel->show($no_masuk);
            $show2 = $this->BmasukModel->detail($no_masuk);

            $barang_masuk = array();
            $detail        = array();

            foreach($show2->result() as $key){
              $json = array();

              $json['id_masuk_detail']  = $key->id_masuk_detail;
              $json['id_identifikasi']  = $key->id_identifikasi;
              $json['no_identifikasi']  = $key->no_identifikasi;
              $json['no_persediaan']    = $key->no_persediaan;
              $json['nama_persediaan']  = $key->nama_persediaan;
              $json['keterangan']       = $key->keterangan;
              $json['qty_masuk']       = $key->qty_masuk;

              $detail[] = $json;
            }

            foreach($show->result() as $key){
              $json = array();

              $json['no_masuk']       = $key->no_masuk;
              $json['no_surat']       = $key->no_surat;
              $json['no_po']          = $key->no_po;
              $json['tgl_masuk']      = $key->tgl_masuk;
              $json['id_supplier']    = $key->id_supplier;
              $json['nama_supplier']  = $key->nama_supplier;
              $json['telepon']        = $key->telepon;
              $json['fax']            = $key->fax;
              $json['email']          = $key->email;
              $json['alamat']         = $key->alamat;
              $json['tgl_masuk']      = $key->tgl_masuk;
              $json['status']         = $key->status;
              $json['id_user']        = $key->id_user;
              $json['nama_user']      = $key->nama_user;
              $json['detail']         = $detail;

              $barang_masuk[] = $json;
            }

            json_output(200, array('status' => 200, 'description' => 'Berhasil', 'data' => $barang_masuk));
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

            $no_masuk       = $this->KodeModel->buatKode('barang_masuk', 'BM', 'no_masuk', 9);
            $id_supplier    = $post['id_supplier'];
            $no_surat       = $post['no_surat'];
            $no_po          = $post['no_po'];
            $tgl_masuk      = $post['tgl_masuk'];
            $status         = 'Proses';

            if($id_supplier == null || $no_surat == null || $no_po == null || $tgl_masuk == null){
              json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Data yang dikirim tidak lengkap'));
            } else {
              if(!isset($post['id_identifikasi']) && count($post['id_identifikasi']) < 1){
                json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Pilih barang yang akan dimasukkan'));
              } else {
                $detail       = array();

                foreach($post['id_identifikasi'] as $key => $val){
                  $detail[] = array(
                    'no_masuk'        => $no_masuk,
                    'id_identifikasi'  => $post['id_identifikasi'][$key],
                    'qty_masuk'        => $post['qty_masuk'][$key]
                  );
                }

                $barang_masuk = array(
                  'no_masuk'    => $no_masuk,
                  'no_surat'    => $no_surat,
                  'no_po'       => $no_po,
                  'tgl_masuk'   => $tgl_masuk,
                  'id_supplier' => $id_supplier,
                  'status'      => $status,
                  'id_user'     => $otorisasi->id_user
                );

                $log = array(
                  'user'        => $otorisasi->id_user,
                  'id_ref'      => $no_masuk,
                  'refrensi'    => 'Barang Masuk',
                  'keterangan'  => 'Menambah Data Barang Masuk',
                  'kategori'    => 'Add'
                );

                $add = $this->BmasukModel->add($barang_masuk, $detail, $log);

                if(!$add){
                  json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal menambah data barang masuk'));
                } else {
                  $this->pusher->trigger('sipb', 'barang_masuk', $log);
                  json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil menambah data barang masuk'));
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

            $no_masuk       = $this->input->get('no_masuk');
            $id_supplier    = $post['id_supplier'];
            $no_surat       = $post['no_surat'];
            $no_po          = $post['no_po'];
            $tgl_masuk      = $post['tgl_masuk'];

            if($no_masuk == null){
              json_output(401, array('status' => 400, 'description' => 'Gagal', 'message' => 'No Surat Jalan tidak ditemukan'));
            } else {
              if($id_supplier == null || $no_surat == null || $no_po == null || $tgl_masuk == null){
                json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Data yang dikirim tidak lengkap'));
              } else {

                if(!isset($post['id_identifikasi']) && count($post['id_identifikasi']) < 1){
                  json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Pilih barang terlebih dahulu'));
                } else {
                  $detail       = array();
                  foreach($post['id_identifikasi'] as $key => $val){
                    $detail[] = array(
                      'no_masuk'       => $no_masuk,
                      'id_identifikasi' => $post['id_identifikasi'][$key],
                      'qty_masuk'      => $post['qty_masuk'][$key]
                    );
                  }

                  $barang_masuk = array(
                    'no_surat'    => $no_surat,
                    'no_po'       => $no_po,
                    'tgl_masuk'   => $tgl_masuk,
                    'id_supplier' => $id_supplier,
                    'id_user'     => $otorisasi->id_user
                  );

                  $log = array(
                    'user'        => $otorisasi->id_user,
                    'id_ref'      => $no_masuk,
                    'refrensi'    => 'Barang Masuk',
                    'keterangan'  => 'Mengedit Data Barang Masuk',
                    'kategori'    => 'Edit'
                  );

                  $edit = $this->BmasukModel->edit($no_masuk, $barang_masuk, $detail, $log);

                  if(!$edit){
                    json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal mengedit data barang masuk'));
                  } else {
                    $this->pusher->trigger('sipb', 'barang_masuk', $log);
                    json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil mengedit data barang masuk'));
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
            $no_masuk = $this->input->get('no_masuk');

            if($no_masuk == null){
              json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'No Surat Jalan tidak ditemukan'));
            } else {
              $log = array(
                'user'        => $otorisasi->id_user,
                'id_ref'      => $no_masuk,
                'refrensi'    => 'Barang Masuk',
                'keterangan'  => 'Menghapus Data Barang Masuk',
                'kategori'    => 'Delete'
              );

              $delete = $this->BmasukModel->delete($no_masuk, $log);

              if(!$delete){
                json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal menghapus barang masuk'));
              } else {
                $this->pusher->trigger('sipb', 'barang_masuk', $log);
                json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil menghapus barang masuk'));
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
            $no_masuk = $this->input->get('no_masuk');

            if($no_masuk == null){
              json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'No Surat Jalan tidak ditemukan'));
            } else {
              $data = array(
                'status' => 'Disetujui'
              );

              $log = array(
                'user'        => $otorisasi->id_user,
                'id_ref'      => $no_masuk,
                'refrensi'    => 'Barang Masuk',
                'keterangan'  => 'Menyetujui Data Barang Masuk',
                'kategori'    => 'Approve'
              );

              $approve = $this->BmasukModel->edit_status($no_masuk, $data, $log);

              if(!$approve){
                json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal menyetujui barang masuk'));
              } else {
                $this->pusher->trigger('sipb', 'barang_masuk', $log);
                json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil menyetujui barang masuk'));
              }
            }
          }
        }
      }
    }
  }

}

?>
