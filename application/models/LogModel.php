<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class LogModel extends CI_Model {

    function add($data)
    {
      return $this->db->insert('log', $data);
    }

    function show()
    {
      return $this->db->select('*')->from('log a')->join('user b', 'b.id_user = a.user', 'left')->get();
    }

    function statistic($tahun)
    {
      $this->db->select("YEAR(tgl_log) as tahun, MONTH(tgl_log) as bulan, COUNT('id_log') as jml_log");

      $this->db->from("log");
      $this->db->where("YEAR(tgl_log)", $tahun);

      $this->db->group_by("MONTH(tgl_log)");
      return $this->db->get();
    }

}

?>
