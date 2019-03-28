<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class UserModel extends CI_Model {

    function show($id_user = null, $nama_user = null)
    {
      $this->db->select('*')->from('user');

      if($id_user != null){
        $this->db->where('id_user', $id_user);
      }

      if($nama_user != null){
        $this->db->like('nama_user', $nama_user);
      }

      $this->db->where('level !=', 'Helpdesk');
      $this->db->order_by('tgl_registrasi', 'desc');
      return $this->db->get();
    }

    function add($data)
    {
      return $this->db->insert('user', $data);
    }

    function edit($param, $data)
    {
      $this->db->where('id_user', $param);
      return $this->db->update('user', $data);
    }

    function delete($param)
    {
      $this->db->where('id_user', $param);
      return $this->db->delete('user');
    }
}

?>
