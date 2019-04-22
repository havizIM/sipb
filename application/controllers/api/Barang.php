<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require 'vendor/autoload.php';

class Barang extends CI_Controller {

  function __construct(){
    parent::__construct();

		$this->load->model('BarangModel');
  }

  function add($token = null)
  {
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

            $no_persediaan   = $this->input->post('no_persediaan');
            $nama_persediaan = $this->input->post('nama_persediaan');
            $satuan          = $this->input->post('satuan');
            $warna           = $this->input->post('warna');
            $keterangan      = $this->input->post('keterangan');
            $foto            = $this->upload_image($no_persediaan);

            if($no_persediaan == null || $nama_persediaan == null || $satuan == null || $warna == null || $keterangan == null || $foto == null){
              json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal menambah data user'));
            } else {

              $data = array(
                'no_persediaan'   => $no_persediaan,
                'nama_persediaan' => $nama_persediaan,
                'satuan'          => $satuan,
                'warna'           => $warna,
                'keterangan'      => $keterangan,
                'foto'            => $foto
              );

              $log = array(
                'user'        => $otorisasi->id_user,
                'id_ref'      => $no_persediaan,
                'refrensi'    => 'Barang',
                'keterangan'  => 'Menambah data barang',
                'kategori'    => 'Add'
              );

              $add = $this->BarangModel->add($data, $log);

              if(!$add){
                json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal menambah data barang'));
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

                $pusher->trigger('sipb', 'barang', $log);
                json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil menambah data barang'));
              }
            }
          }
        }
      }
    }
  }

  function upload_image($no_persediaan)
  {
    if(isset($_FILES['foto']) && $_FILES['foto']['name'] != ""){
      $extention = explode('.', $_FILES['foto']['name']);
      $new_name = $no_persediaan.'.'.$extention[1];
      $destination = './doc/barang/'.$new_name;
      $upload = move_uploaded_file($_FILES['foto']['tmp_name'], $destination);

      if($upload){
        return $new_name;
      } else {
        return 'barang.jpg';
      }
    } else {
      return 'barang.jpg';
    }
  }

  function show($token = null)
  {
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

          $otorisasi  = $auth->row();
          $no_persediaan    = $this->input->get('no_persediaan');
          $nama_persediaan  = $this->input->get('nama_persediaan');

          $show       = $this->BarangModel->show($no_persediaan, $nama_persediaan);
          $persediaan     = array();

          foreach($show->result() as $key){
            $json = array();

            $json['no_persediaan']    = $key->no_persediaan;
            $json['nama_persediaan']  = $key->nama_persediaan;
            $json['satuan']           = $key->satuan;
            $json['warna']            = $key->warna;
            $json['keterangan']       = $key->keterangan;
            $json['foto']             = $key->foto;
            $json['tgl_input']        = $key->tgl_input;

            $persediaan[] = $json;
          }

          json_output(200, array('status' => 200, 'description' => 'Berhasil', 'data' => $persediaan));
        }
      }
    }
  }

  function delete($token = null)
  {
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
            $no_persediaan = $this->input->get('no_persediaan');

            if($no_persediaan == null){
              json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'No Persediaan tidak ditemukan'));
            } else {
              $log = array(
                'user'        => $otorisasi->id_user,
                'id_ref'      => $no_persediaan,
                'refrensi'    => 'Barang',
                'keterangan'  => 'Menghapus data barang',
                'kategori'    => 'Delete'
              );

              $delete = $this->BarangModel->delete($no_persediaan, $log);

              if(!$delete){
                json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal menghapus data barang'));
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

                $pusher->trigger('sipb', 'barang', $log);
                json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil menghapus data barang'));
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
            $no_persediaan   = $this->input->get('no_persediaan');
            $nama_persediaan = $this->input->post('nama_persediaan');
            $satuan          = $this->input->post('satuan');
            $warna           = $this->input->post('warna');
            $keterangan      = $this->input->post('keterangan');
            $foto            = $this->reupload_image($no_persediaan);

            if($no_persediaan == null){
              json_output(401, array('status' => 401, 'description' => 'Gagal', 'message' => 'Tidak ada No Persediaan yang dipilih'));
            } else {
              if($nama_persediaan == null || $satuan == null || $warna == null || $keterangan == null){
                json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Data yang dikirim tidak lengkap'));
              } else {

                if($foto == null){
                  $data = array(
                    'nama_persediaan' => $nama_persediaan,
                    'satuan'          => $satuan,
                    'warna'           => $warna,
                    'keterangan'      => $keterangan
                  );
                } else {
                  $data = array(
                    'nama_persediaan' => $nama_persediaan,
                    'satuan'          => $satuan,
                    'warna'           => $warna,
                    'keterangan'      => $keterangan,
                    'foto'            => $foto
                  );
                }


                $log = array(
                  'user'        => $otorisasi->id_user,
                  'id_ref'      => $no_persediaan,
                  'refrensi'    => 'Barang',
                  'keterangan'  => 'Mengedit data barang',
                  'kategori'    => 'Edit'
                );

                $edit = $this->BarangModel->edit($no_persediaan, $data, $log);

                if(!$edit){
                  json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal mengedit data barang'));
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

                  $pusher->trigger('sipb', 'barang', $log);

                  json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil mengedit data barang'));
                }
              }
            }
          }
        }
      }
    }
  }

  function reupload_image($no_persediaan)
  {
    if(isset($_FILES['foto']) && $_FILES['foto']['name'] != ""){
      $extention = explode('.', $_FILES['foto']['name']);
      $new_name = $no_persediaan.'.'.$extention[1];
      $destination = './doc/barang/'.$new_name;
      $upload = move_uploaded_file($_FILES['foto']['tmp_name'], $destination);

      if($upload){
        return $new_name;
      } else {
        return null;
      }
    } else {
      return null;
    }
  }

}

?>
