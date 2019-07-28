<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';

class Memorandum extends CI_Controller {

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

		$this->load->model('MemorandumModel');
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
          $no_memo              = $this->input->get('no_memo');

          $show           = $this->MemorandumModel->show($no_memo);
          $memorandum  = array();

          foreach($show->result() as $key){
            $json = array();

            $json['no_memo']              = $key->no_memo;
            $json['tgl_memo']             = $key->tgl_memo;
            $json['keterangan_memo']      = $key->keterangan_memo;
            $json['status']               = $key->status;
            $json['id_user']              = $key->id_user;
            $json['nama_user']            = $key->nama_user;

            $memorandum[] = $json;
          }

          json_output(200, array('status' => 200, 'description' => 'Berhasil', 'data' => $memorandum));
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
          $no_memo     = $this->input->get('no_memo');

          if($no_memo == null){
            json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'No Surat Jalan tidak dipilih'));
          } else {
            $show  = $this->MemorandumModel->show($no_memo);
            $show2 = $this->MemorandumModel->detail($no_memo);

            $memorandum = array();
            $detail        = array();

            foreach($show2->result() as $key){
              $json = array();

              $json['id_memorandum_detail'] = $key->id_memorandum_detail;
              $json['id_identifikasi']      = $key->id_identifikasi;
              $json['no_identifikasi']      = $key->no_identifikasi;
              $json['no_persediaan']        = $key->no_persediaan;
              $json['nama_persediaan']      = $key->nama_persediaan;
              $json['keterangan']           = $key->keterangan;
              $json['qty_masuk']            = $key->qty_masuk;
              $json['qty_keluar']           = $key->qty_keluar;
              $json['keterangan']           = $key->keterangan;

              $detail[] = $json;
            }

            foreach($show->result() as $key){
              $json = array();

              $json['no_memo']              = $key->no_memo;
              $json['tgl_memo']             = $key->tgl_memo;
              $json['keterangan_memo']      = $key->keterangan_memo;
              $json['status']               = $key->status;
              $json['id_user']              = $key->id_user;
              $json['nama_user']            = $key->nama_user;
              $json['detail']               = $detail;

              $memorandum[] = $json;
            }

            json_output(200, array('status' => 200, 'description' => 'Berhasil', 'data' => $memorandum));
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

            $mycode               = 'MEMO-'.date('mY').'-';
            $no_memo              = $this->KodeModel->buatKode('memorandum', $mycode, 'no_memo', 3);
            $keterangan_memo      = $post['keterangan_memo'];
            $status               = 'Proses';

            if($keterangan_memo == null){
              json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Data yang dikirim tidak lengkap'));
            } else {
              if(!isset($post['id_identifikasi']) && count($post['id_identifikasi']) < 1){
                json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Pilih barang yang akan dikeluarkan'));
              } else {
                $detail       = array();
                foreach($post['id_identifikasi'] as $key => $val){
                  $detail[] = array(
                    'no_memo'           => $no_memo,
                    'id_identifikasi'   => $post['id_identifikasi'][$key],
                    'qty_masuk'         => $post['qty_masuk'][$key],
                    'qty_keluar'        => $post['qty_keluar'][$key],
                    'keterangan'        => $post['keterangan'][$key]
                  );
                }

                $memorandum = array(
                  'no_memo'           => $no_memo,
                  'keterangan_memo'   => $keterangan_memo,
                  'status'            => $status,
                  'id_user'           => $otorisasi->id_user
                );

                $log = array(
                  'user'        => $otorisasi->id_user,
                  'id_ref'      => $no_memo,
                  'refrensi'    => 'Memorandum',
                  'keterangan'  => 'Menambah Data Memorandum',
                  'kategori'    => 'Add'
                );

                $add = $this->MemorandumModel->add($memorandum, $detail, $log);

                if(!$add){
                  json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal menambah data memorandum'));
                } else {
                  $this->pusher->trigger('sipb', 'memorandum', $log);
                  json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil menambah data memorandum'));
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

            $no_memo              = $this->input->get('no_memo');
            $keterangan_memo      = $post['keterangan_memo'];

            if($no_memo == null){
              json_output(401, array('status' => 400, 'description' => 'Gagal', 'message' => 'No Surat Jalan tidak ditemukan'));
            } else {
              if($keterangan_memo == null){
                json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Data yang dikirim tidak lengkap'));
              } else {

                if(!isset($post['id_identifikasi']) && count($post['id_identifikasi']) < 1){
                  json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Pilih barang terlebih dahulu'));
                } else {
                  $detail       = array();
                  foreach($post['id_identifikasi'] as $key => $val){
                    $detail[] = array(
                      'no_memo'          => $no_memo,
                      'id_identifikasi'  => $post['id_identifikasi'][$key],
                      'qty_masuk'        => $post['qty_masuk'][$key],
                      'qty_keluar'       => $post['qty_keluar'][$key],
                      'keterangan'       => $post['keterangan'][$key]
                    );
                  }

                  $memorandum = array(
                    'keterangan_memo'       => $keterangan_memo
                  );

                  $log = array(
                    'user'        => $otorisasi->id_user,
                    'id_ref'      => $no_memo,
                    'refrensi'    => 'Memorandum',
                    'keterangan'  => 'Mengedit data Memorandum',
                    'kategori'    => 'Edit'
                  );

                  $edit = $this->MemorandumModel->edit($no_memo, $memorandum, $detail, $log);

                  if(!$edit){
                    json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal mengedit data Memorandum'));
                  } else {
                    $this->pusher->trigger('sipb', 'memorandum', $log);
                    json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil mengedit data Memorandum'));
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
            $no_memo = $this->input->get('no_memo');

            if($no_memo == null){
              json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'No Surat Jalan tidak ditemukan'));
            } else {
              $log = array(
                'user'        => $otorisasi->id_user,
                'id_ref'      => $no_memo,
                'refrensi'    => 'Memorandum',
                'keterangan'  => 'Menghapus Data Memorandum',
                'kategori'    => 'Delete'
              );

              $delete = $this->MemorandumModel->delete($no_memo, $log);

              if(!$delete){
                json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal menghapus Memorandum'));
              } else {
                $this->pusher->trigger('sipb', 'memorandum', $log);
                json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil menghapus Memorandum'));
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
            $no_memo = $this->input->get('no_memo');

            if($no_memo == null){
              json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'No Surat Jalan tidak ditemukan'));
            } else {
              $data = array(
                'status' => 'Disetujui'
              );

              $log = array(
                'user'        => $otorisasi->id_user,
                'id_ref'      => $no_memo,
                'refrensi'    => 'Memorandum',
                'keterangan'  => 'Menyetujui Data Memorandum',
                'kategori'    => 'Approve'
              );

              $approve = $this->MemorandumModel->edit_status($no_memo, $data, $log);

              if(!$approve){
                json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal menyetujui Memorandum'));
              } else {
                $this->pusher->trigger('sipb', 'memorandum', $log);
                json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil menyetujui Memorandum'));
              }
            }
          }
        }
      }
    }
  }

}

?>
