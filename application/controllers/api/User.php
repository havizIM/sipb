<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

  function __construct(){
    parent::__construct();

		$this->load->model('UserModel');
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

          $otorisasi = $auth->row();

          if($otorisasi->level != 'Helpdesk'){
            json_output(401, array('status' => 401, 'description' => 'Gagal', 'message' => 'Hak akses tidak disetujui'));
          } else {
            $id_user  		= $this->input->get('id_user');
      			$nama_user	  = $this->input->get('nama_user');

            $show  = $this->UserModel->show($id_user, $nama_user);
            $user  = array();

            foreach($show->result() as $key){
              $json = array();

              $json['id_user']        = $key->id_user;
              $json['nama_user']      = $key->nama_user;
              $json['username']       = $key->username;
              $json['password']       = $key->password;
              $json['level']          = $key->level;
              $json['tgl_registrasi'] = $key->tgl_registrasi;
              $json['foto']           = $key->foto;
              $json['status']         = $key->status;

              $user[] = $json;
            }

            json_output(200, array('status' => 200, 'description' => 'Berhasil', 'data' => $user));
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

          if($otorisasi->level != 'Helpdesk'){
            json_output(401, array('status' => 401, 'description' => 'Gagal', 'message' => 'Hak akses tidak disetujui'));
          } else {
            $nama_user  = $this->input->post('nama_user');
            $username   = $this->input->post('username');
            $level      = $this->input->post('level');

            if($nama_user == null || $username == null || $level == null){
              json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Data yang dikirim tidak lengkap'));
            } else {

              $data = array(
                'id_user'   => $this->KodeModel->buatKode('user', 'USR', 'id_user', 8),
                'nama_user' => $nama_user,
                'username'  => $username,
                'password'  => substr(str_shuffle("01234567890abcdefghijklmnopqestuvwxyz"), 0, 5),
                'level'     => $level,
                'foto'      => 'user.jpg',
                'status'    => 'Aktif',
                'token'     => sha1($username)
              );

              $add = $this->UserModel->add($data);

              if(!$add){
                json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal menambah data user'));
              } else {
                json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil menambah data user'));
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

          if($otorisasi->level != 'Helpdesk'){
            json_output(401, array('status' => 401, 'description' => 'Gagal', 'message' => 'Hak akses tidak disetujui'));
          } else {
            $id_user    = $this->input->get('id_user');
            $nama_user  = $this->input->post('nama_user');
            $username   = $this->input->post('username');
            $status     = $this->input->post('status');

            if($id_user == null){
              json_output(401, array('status' => 401, 'description' => 'Gagal', 'message' => 'Tidak ada ID User yang dipilih'));
            } else {
              if($nama_user == null || $username == null || $status == null){
                json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Data yang dikirim tidak lengkap'));
              } else {
                $data = array(
                  'nama_user' => $nama_user,
                  'username'  => $username,
                  'status'    => $status
                );

                $edit = $this->UserModel->edit($id_user, $data);

                if(!$edit){
                  json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal mengedit user'));
                } else {
                  json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil mengedit user'));
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

          if($otorisasi->level != 'Helpdesk'){
            json_output(401, array('status' => 401, 'description' => 'Gagal', 'message' => 'Hak akses tidak disetujui'));
          } else {
            $id_user = $this->input->get('id_user');

            if($id_user == null){
              json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'ID User tidak ditemukan'));
            } else {
              $delete = $this->UserModel->delete($id_user);

              if(!$delete){
                json_output(400, array('status' => 400, 'description' => 'Gagal', 'message' => 'Gagal menghapus user'));
              } else {
                json_output(200, array('status' => 200, 'description' => 'Berhasil', 'message' => 'Berhasil menghapus user'));
              }
            }
          }
        }
      }
    }
  }

}

?>
