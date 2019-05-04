<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';

class Pesanan extends CI_Controller {

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

		$this->load->model('PesananModel');
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
          $no_pesanan    = $this->input->get('no_pesanan');

          $show  = $this->PesananModel->show($no_pesanan, $otorisasi);
          $pesanan  = array();

          foreach($show->result() as $key){
            $json = array();

            $json['no_pesanan']    = $key->no_pesanan;
            $json['tgl_pesanan']   = $key->tgl_pesanan;
            $json['tgl_kirim']     = $key->tgl_kirim;
            $json['id_customer']   = $key->id_customer;
            $json['nama_customer'] = $key->nama_customer;
            $json['alamat_kirim']  = $key->alamat_kirim;
            $json['status']        = $key->status;
            $json['id_user']       = $key->id_user;
            $json['nama_user']     = $key->nama_user;

            $pesanan[] = $json;
          }

          json_output(200, array('status' => 200, 'description' => 'Berhasil', 'data' => $pesanan));
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
          $no_pesanan    = $this->input->get('no_pesanan');

          if($no_pesanan == null){
            json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'No Pesanan tidak dipilih'));
          } else {
            $show  = $this->PesananModel->show($no_pesanan, $otorisasi);
            $show2 = $this->PesananModel->detail($no_pesanan);

            $pesanan   = array();
            $detail = array();

            foreach($show2->result() as $key){
              $json = array();

              $json['id_detail_pesanan'] = $key->id_detail_pesanan;
              $json['no_persediaan']     = $key->no_persediaan;
              $json['nama_persediaan']   = $key->nama_persediaan;
              $json['keterangan']        = $key->keterangan;
              $json['qty_pesanan']       = $key->qty_pesanan;

              $detail[] = $json;
            }

            foreach($show->result() as $key){
              $json = array();

              $json['no_pesanan']    = $key->no_pesanan;
              $json['tgl_pesanan']   = $key->tgl_pesanan;
              $json['tgl_kirim']     = $key->tgl_kirim;
              $json['id_customer']   = $key->id_customer;
              $json['nama_customer'] = $key->nama_customer;
              $json['alamat_kirim']  = $key->alamat_kirim;
              $json['status']        = $key->status;
              $json['id_user']       = $key->id_user;
              $json['nama_user']     = $key->nama_user;
              $json['detail']         = $detail;

              $pesanan[] = $json;
            }

            json_output(200, array('status' => 200, 'description' => 'Berhasil', 'data' => $pesanan));
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

          if($otorisasi->level != 'Sales'){
            json_output(401, array('status' => 401, 'description' => 'Gagal', 'message' => 'Hak akses tidak disetujui'));
          } else {
            $post           = $this->input->post();

            $no_pesanan     = $this->KodeModel->buatKode('pesanan', 'PS', 'no_pesanan', 10);
            $tgl_kirim      = $post['tgl_kirim'];
            $id_customer    = $post['id_customer'];
            $alamat_kirim   = $post['alamat_kirim'];

            if($tgl_kirim == null || $id_customer == null || $alamat_kirim == null){
              json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Data yang dikirim tidak lengkap'));
            } else {
              $total_detail = count($post['no_persediaan']);

              if($total_detail < 1){
                json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Pilih barang yang akan dipilih'));
              } else {
                $detail       = array();
                foreach($post['no_persediaan'] as $key => $val){
                  $detail[] = array(
                    'no_pesanan'     => $no_pesanan,
                    'no_persediaan'  => $post['no_persediaan'][$key],
                    'keterangan'     => $post['keterangan'][$key],
                    'qty_pesanan'    => $post['qty_pesanan'][$key]
                  );
                }

                $pesanan = array(
                  'no_pesanan'    => $no_pesanan,
                  'tgl_kirim'     => $tgl_kirim,
                  'id_customer'   => $id_customer,
                  'alamat_kirim'  => $alamat_kirim,
                  'id_user'       => $otorisasi->id_user
                );

                $log = array(
                  'user'        => $otorisasi->id_user,
                  'id_ref'      => $no_pesanan,
                  'refrensi'    => 'Pesanan',
                  'keterangan'  => 'Menambah data pesanan',
                  'kategori'    => 'Add'
                );

                $add = $this->PesananModel->add($pesanan, $detail, $log);

                if(!$add){
                  json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal membuat pesanan'));
                } else {
                  $this->pusher->trigger('sipb', 'pesanan', $log);
                  json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil membuat pesanan'));
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

          if($otorisasi->level != 'Sales'){
            json_output(401, array('status' => 401, 'description' => 'Gagal', 'message' => 'Hak akses tidak disetujui'));
          } else {
            $post           = $this->input->post();

            $no_pesanan     = $this->input->get('no_pesanan');
            $tgl_kirim      = $post['tgl_kirim'];
            $id_customer    = $post['id_customer'];
            $alamat_kirim   = $post['alamat_kirim'];

            if($no_pesanan == null){
              json_output(401, array('status' => 400, 'description' => 'Gagal', 'message' => 'No Pesanan tidak ditemukan'));
            } else {
              if($tgl_kirim == null || $id_customer == null || $alamat_kirim == null){
                json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Data yang dikirim tidak lengkap'));
              } else {
                $total_detail   = count($post['no_persediaan']);

                if($total_detail < 1){
                  json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Tidak ada detail yang diisi'));
                } else {
                  $detail       = array();
                  foreach($post['no_persediaan'] as $key => $val){
                    $detail[] = array(
                      'no_pesanan'     => $no_pesanan,
                      'no_persediaan'  => $post['no_persediaan'][$key],
                      'keterangan'     => $post['keterangan'][$key],
                      'qty_pesanan'    => $post['qty_pesanan'][$key]
                    );
                  }

                  $pesanan = array(
                    'no_pesanan'    => $no_pesanan,
                    'tgl_kirim'     => $tgl_kirim,
                    'id_customer'   => $id_customer,
                    'alamat_kirim'  => $alamat_kirim,
                    'id_user'       => $otorisasi->id_user
                  );

                  $log = array(
                    'user'        => $otorisasi->id_user,
                    'id_ref'      => $no_pesanan,
                    'refrensi'    => 'Pesanan',
                    'keterangan'  => 'Mengedit data pesanan',
                    'kategori'    => 'Edit'
                  );

                  $edit = $this->PesananModel->edit($no_pesanan, $pesanan, $detail, $log);

                  if(!$edit){
                    json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal mengedit data pesanan'));
                  } else {
                    $this->pusher->trigger('sipb', 'pesanan', $log);
                    json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil mengedit data pesanan'));
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

          if($otorisasi->level != 'Sales'){
            json_output(401, array('status' => 401, 'description' => 'Gagal', 'message' => 'Hak akses tidak disetujui'));
          } else {
            $no_pesanan = $this->input->get('no_pesanan');

            if($no_pesanan == null){
              json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'No Rekening tidak ditemukan'));
            } else {
              $log = array(
                'user'        => $otorisasi->id_user,
                'id_ref'      => $no_pesanan,
                'refrensi'    => 'Pesanan',
                'keterangan'  => 'Menghapus data Menghapus Data Pesanan',
                'kategori'    => 'Delete'
              );

              $delete = $this->PesananModel->delete($no_pesanan, $log);

              if(!$delete){
                json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal menghapus pesanan'));
              } else {
                $this->pusher->trigger('sipb', 'pesanan', $log);
                json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil menghapus pesanan'));
              }
            }
          }
        }
      }
    }
  }

}

?>
