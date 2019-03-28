<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class AuthModel extends CI_Model {

    function loginUser($username)
    {
      return $this->db->select('*')->from('user')->where('username', $username)->get();
    }

    function cekAuth($token)
    {
      return $this->db->select('id_user, username, level, password')->from('user')->where('token', $token)->get();
    }

    function gantiPass($param, $data, $log)
    {
      $this->db->trans_start();
      $this->db->where('id_user', $param)->update('user', $data);
      $this->db->insert('log', $log);
      $this->db->trans_complete();

      if ($this->db->trans_status() === FALSE){
        $this->db->trans_rollback();
        return false;
      } else {
        $this->db->trans_commit();
        return true;
      }
    }



}

?>
