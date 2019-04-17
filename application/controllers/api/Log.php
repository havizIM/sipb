<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Log extends CI_Controller {

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

          $otorisasi = $auth->row();

          if($otorisasi->level != 'Helpdesk'){
            json_output(401, array('status' => 401, 'description' => 'Gagal', 'message' => 'Hak akses tidak disetujui'));
          } else {

            $show  = $this->LogModel->show();
            $user  = array();

            foreach($show->result() as $key){
              $json = array();

              $json['id_log']     = $key->id_log;
              $json['id_user']    = $key->id_user;
              $json['nama_user']  = $key->nama_user;
              $json['id_ref']     = $key->id_ref;
              $json['refrensi']   = $key->refrensi;
              $json['keterangan'] = $key->keterangan;
              $json['kategori']   = $key->kategori;
              $json['tgl_log']    = $key->tgl_log;

              $user[] = $json;
            }

            json_output(200, array('status' => 200, 'description' => 'Berhasil', 'data' => $user));
          }
        }
      }
    }
  }

  function statistic($token = null)
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

          if($otorisasi->level != 'Helpdesk'){
            json_output(401, array('status' => 401, 'description' => 'Gagal', 'message' => 'Hak akses tidak disetujui'));
          } else {

            $tahun = date('Y');
            $show  = $this->LogModel->statistic($tahun);
            $jml_log  = array("0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0", "0");
            $total = 0;

            foreach($show->result() as $key){
              $index = $key->bulan - 1;

              $jml_log[$index] = $key->jml_log;
              $total += $key->jml_log;
            }

            $statistic = array(
              'tahun'         => $tahun,
              'total_log'     => $total,
              'log_by_month'  => $jml_log
            );

            json_output(200, array('status' => 200, 'description' => 'Berhasil', 'data' => $statistic));
          }
        }
      }
    }
  }

}

?>
