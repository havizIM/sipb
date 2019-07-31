<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';

class Stock extends CI_Controller {

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

		$this->load->model('StockModel');
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

          $otorisasi        = $auth->row();
          $id_identifikasi  = $this->input->get('id_identifikasi');
    			$no_identifikasi	= $this->input->get('no_identifikasi');
          $no_persediaan	  = $this->input->get('no_persediaan');

          $show  = $this->StockModel->show($id_identifikasi, $no_identifikasi, $no_persediaan);
          $stock  = array();

          foreach($show->result() as $key){
            $json = array();

            $json['id_identifikasi']   = $key->id_identifikasi;
            $json['no_identifikasi']  = $key->no_identifikasi;
            $json['ket_stock']         = $key->ket_stock;
            $json['saldo_awal']        = $key->saldo_awal;
            $json['no_persediaan']     = $key->no_persediaan;
            $json['nama_persediaan']   = $key->nama_persediaan;
            $json['satuan']            = $key->satuan;
            $json['warna']             = $key->warna;
            $json['ket_barang']        = $key->ket_barang;
            $json['tgl_input']         = $key->tgl_input;

            $stock[] = $json;
          }

          json_output(200, array('status' => 200, 'description' => 'Berhasil', 'data' => $stock));
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
            $no_identifikasi  = $this->input->post('no_identifikasi');
            $no_persediaan    = $this->input->post('no_persediaan');
            $keterangan       = $this->input->post('keterangan');
            $saldo_awal       = $this->input->post('saldo_awal');

            if($no_identifikasi == null || $no_persediaan == null || $keterangan == null || $saldo_awal == null){
              json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Data yang dikirim tidak lengkap'));
            } else {

              $data = array(
                'no_identifikasi' => $no_identifikasi,
                'no_persediaan'   => $no_persediaan,
                'keterangan'      => $keterangan,
                'saldo_awal'      => $saldo_awal
              );

              $log = array(
                'user'        => $otorisasi->id_user,
                'id_ref'      => $no_persediaan.' - '.$no_identifikasi,
                'refrensi'    => 'Stock',
                'keterangan'  => 'Menambah data stock baru',
                'kategori'    => 'Add'
              );

              $add = $this->StockModel->add($data, $log);

              if(!$add){
                json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal menambah data stock'));
              } else {
                $this->pusher->trigger('sipb', 'stock', $log);
                json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil menambah data stock'));
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
            $id_identifikasi  = $this->input->get('id_identifikasi');
            $no_identifikasi  = $this->input->post('no_identifikasi');
            $no_persediaan    = $this->input->post('no_persediaan');
            $keterangan       = $this->input->post('keterangan');

            if($id_identifikasi == null){
              json_output(401, array('status' => 401, 'description' => 'Gagal', 'message' => 'Tidak ada ID Identifikasi yang dipilih'));
            } else {
              if($no_identifikasi == null || $no_persediaan == null || $keterangan == null){
                json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Data yang dikirim tidak lengkap'));
              } else {
                $data = array(
                  'no_identifikasi' => $no_identifikasi,
                  'no_persediaan'   => $no_persediaan,
                  'keterangan'      => $keterangan
                );

                $log = array(
                  'user'        => $otorisasi->id_user,
                  'id_ref'      => $id_identifikasi,
                  'refrensi'    => 'Stock',
                  'keterangan'  => 'Mengedit data stock',
                  'kategori'    => 'Edit'
                );

                $edit = $this->StockModel->edit($id_identifikasi, $data, $log);

                if(!$edit){
                  json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal mengedit stock'));
                } else {
                  $this->pusher->trigger('sipb', 'stock', $log);
                  json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil mengedit stock'));
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
            $id_identifikasi = $this->input->get('id_identifikasi');

            if($id_identifikasi == null){
              json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'ID Identifikasi tidak ditemukan'));
            } else {
              $log = array(
                'user'        => $otorisasi->id_user,
                'id_ref'      => $id_identifikasi,
                'refrensi'    => 'Stock',
                'keterangan'  => 'Menghapus data stock baru',
                'kategori'    => 'Delete'
              );

              $delete = $this->StockModel->delete($id_identifikasi, $log);

              if(!$delete){
                json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal menghapus stock'));
              } else {
                $this->pusher->trigger('sipb', 'stock', $log);
                json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil menghapus stock'));
              }
            }
          }
        }
      }
    }
  }

  function laporan($token = null){
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

          $otorisasi        = $auth->row();
          $tgl_awal  = $this->input->get('tgl_awal');
    			$tgl_akhir	= $this->input->get('tgl_akhir');

          $show  = $this->StockModel->laporan($tgl_awal, $tgl_akhir);
          $stock  = array();

          foreach($show->result() as $key){
            $json = array();

            $json['id_identifikasi']   = $key->id_identifikasi;
            $json['no_persediaan']     = $key->no_persediaan;
            $json['no_identifikasi']   = $key->no_identifikasi;
            $json['keterangan']        = $key->keterangan;

            $masuk                    = $key->jml_barang_masuk + $key->jml_return_masuk + $key->jml_memorandum_in;
            $keluar                   = $key->jml_barang_keluar + $key->jml_return_keluar + $key->jml_memorandum_out;
            $json['saldo_awal']       = ($key->saldo_awal + $masuk) - $keluar;
            $json['barang_masuk']     = $key->act_barang_masuk + $key->act_return_masuk + $key->act_memorandum_in;
            $json['barang_keluar']    = $key->act_barang_keluar + $key->act_return_keluar + $key->act_memorandum_out;
            $json['saldo_akhir']       = ($json['saldo_awal'] + $json['barang_masuk']) - $json['barang_keluar'];
            
            



            $stock[] = $json;
          }

          json_output(200, array('status' => 200, 'description' => 'Berhasil', 'data' => $stock));
        }
      }
    }
  }


}

?>
