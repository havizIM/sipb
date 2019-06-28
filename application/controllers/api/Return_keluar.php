<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';

class Return_keluar extends CI_Controller {

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

		$this->load->model('RkeluarModel');
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
          $no_return_keluar     = $this->input->get('no_return_keluar');

          $show           = $this->RkeluarModel->show($no_return_keluar);
          $return_keluar  = array();

          foreach($show->result() as $key){
            $json = array();

            $json['no_return_keluar']     = $key->no_return_keluar;
            $json['tgl_return']           = $key->tgl_return;
            $json['id_supplier']          = $key->id_supplier;
            $json['nama_supplier']        = $key->nama_supplier;
            $json['telepon']              = $key->telepon;
            $json['email']                = $key->email;
            $json['fax']                  = $key->fax;
            $json['alamat']               = $key->alamat;
            $json['no_ref']               = $key->no_ref;
            $json['status']               = $key->status;
            $json['id_user']              = $key->id_user;
            $json['nama_user']            = $key->nama_user;

            $return_keluar[] = $json;
          }

          json_output(200, array('status' => 200, 'description' => 'Berhasil', 'data' => $return_keluar));
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
          $no_return_keluar     = $this->input->get('no_return_keluar');

          if($no_return_keluar == null){
            json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'No Surat Jalan tidak dipilih'));
          } else {
            $show  = $this->RkeluarModel->show($no_return_keluar);
            $show2 = $this->RkeluarModel->detail($no_return_keluar);

            $return_keluar = array();
            $detail        = array();

            foreach($show2->result() as $key){
              $json = array();

              $json['id_dreturn_keluar'] = $key->id_dreturn_keluar;
              $json['id_identifikasi']  = $key->id_identifikasi;
              $json['no_identifikasi']  = $key->no_identifikasi;
              $json['no_persediaan']    = $key->no_persediaan;
              $json['nama_persediaan']  = $key->nama_persediaan;
              $json['keterangan']       = $key->keterangan;
              $json['qty_return_keluar']       = $key->qty_return_keluar;

              $detail[] = $json;
            }

            foreach($show->result() as $key){
              $json = array();

              $json['no_return_keluar']     = $key->no_return_keluar;
              $json['tgl_return']           = $key->tgl_return;
              $json['id_supplier']          = $key->id_supplier;
              $json['nama_supplier']        = $key->nama_supplier;
              $json['telepon']              = $key->telepon;
              $json['email']                = $key->email;
              $json['fax']                  = $key->fax;
              $json['alamat']               = $key->alamat;
              $json['no_ref']               = $key->no_ref;
              $json['status']               = $key->status;
              $json['id_user']              = $key->id_user;
              $json['nama_user']            = $key->nama_user;
              $json['detail']        = $detail;

              $return_keluar[] = $json;
            }

            json_output(200, array('status' => 200, 'description' => 'Berhasil', 'data' => $return_keluar));
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

            $no_return_keluar     = $this->KodeModel->buatKode('return_keluar', 'RTR-K', 'no_return_keluar', 9);
            $no_ref               = $post['no_ref'];
            $id_supplier          = $post['id_supplier'];
            $status               = 'Proses';

            if($no_ref == null || $id_supplier == null){
              json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Data yang dikirim tidak lengkap'));
            } else {
              if(!isset($post['id_identifikasi']) && count($post['id_identifikasi']) < 1){
                json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Pilih barang yang akan dikeluarkan'));
              } else {
                $detail       = array();
                foreach($post['id_identifikasi'] as $key => $val){
                  $detail[] = array(
                    'no_return_keluar'        => $no_return_keluar,
                    'id_identifikasi'         => $post['id_identifikasi'][$key],
                    'qty_return_keluar'       => $post['qty_return_keluar'][$key]
                  );
                }

                $return_barang = array(
                  'no_return_keluar'  => $no_return_keluar,
                  'no_ref'            => $no_ref,
                  'id_supplier'       => $id_supplier,
                  'status'            => $status,
                  'id_user'           => $otorisasi->id_user
                );

                $log = array(
                  'user'        => $otorisasi->id_user,
                  'id_ref'      => $no_return_keluar,
                  'refrensi'    => 'Return Keluar',
                  'keterangan'  => 'Menambah Data Return Keluar',
                  'kategori'    => 'Add'
                );

                $add = $this->RkeluarModel->add($return_barang, $detail, $log);

                if(!$add){
                  json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal menambah data return keluar'));
                } else {
                  $this->pusher->trigger('sipb', 'return_keluar', $log);
                  json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil menambah data return keluar'));
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

            $no_return_keluar     = $this->input->get('no_return_keluar');
            $no_ref               = $post['no_ref'];
            $id_supplier          = $post['id_supplier'];

            if($no_return_keluar == null){
              json_output(401, array('status' => 400, 'description' => 'Gagal', 'message' => 'No Surat Jalan tidak ditemukan'));
            } else {
              if($no_ref == null || $id_supplier == null){
                json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Data yang dikirim tidak lengkap'));
              } else {

                if(!isset($post['id_identifikasi']) && count($post['id_identifikasi']) < 1){
                  json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Pilih barang terlebih dahulu'));
                } else {
                  $detail       = array();
                  foreach($post['id_identifikasi'] as $key => $val){
                    $detail[] = array(
                      'no_return_keluar'    => $no_return_keluar,
                      'id_identifikasi'     => $post['id_identifikasi'][$key],
                      'qty_return_keluar'   => $post['qty_return_keluar'][$key]
                    );
                  }

                  $return_keluar = array(
                    'no_ref'            => $no_ref,
                    'id_supplier'       => $id_supplier
                  );

                  $log = array(
                    'user'        => $otorisasi->id_user,
                    'id_ref'      => $no_return_keluar,
                    'refrensi'    => 'Return Keluar',
                    'keterangan'  => 'Mengedit data return keluar',
                    'kategori'    => 'Edit'
                  );

                  $edit = $this->RkeluarModel->edit($no_return_keluar, $return_keluar, $detail, $log);

                  if(!$edit){
                    json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal mengedit data return keluar'));
                  } else {
                    $this->pusher->trigger('sipb', 'return_keluar', $log);
                    json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil mengedit data return keluar'));
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
            $no_return_keluar = $this->input->get('no_return_keluar');

            if($no_return_keluar == null){
              json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'No Surat Jalan tidak ditemukan'));
            } else {
              $log = array(
                'user'        => $otorisasi->id_user,
                'id_ref'      => $no_return_keluar,
                'refrensi'    => 'Return Keluar',
                'keterangan'  => 'Menghapus Data Return Keluar',
                'kategori'    => 'Delete'
              );

              $delete = $this->RkeluarModel->delete($no_return_keluar, $log);

              if(!$delete){
                json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal menghapus return keluar'));
              } else {
                $this->pusher->trigger('sipb', 'return_keluar', $log);
                json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil menghapus return keluar'));
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
            $no_return_keluar = $this->input->get('no_return_keluar');

            if($no_return_keluar == null){
              json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'No Surat Jalan tidak ditemukan'));
            } else {
              $data = array(
                'status' => 'Disetujui'
              );

              $log = array(
                'user'        => $otorisasi->id_user,
                'id_ref'      => $no_return_keluar,
                'refrensi'    => 'Return keluar',
                'keterangan'  => 'Menyetujui Data Return Keluar',
                'kategori'    => 'Approve'
              );

              $approve = $this->RkeluarModel->edit_status($no_return_keluar, $data, $log);

              if(!$approve){
                json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal menyetujui return keluar'));
              } else {
                $this->pusher->trigger('sipb', 'return_keluar', $log);
                json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil menyetujui return keluar'));
              }
            }
          }
        }
      }
    }
  }

}

?>
