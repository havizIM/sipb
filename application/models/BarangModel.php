<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class BarangModel extends CI_Model {

  function show($no_persediaan = null, $nama_persediaan = null){

      $this->db->select('*')
               // ->select('(SELECT count(id_peserta) from peserta WHERE jadwal.id_jadwal = peserta.jadwal) as jml_peserta')
               ->from('barang');

      if($no_persediaan != null){
        $this->db->where('no_persediaan', $no_persediaan);
      }

      if($nama_persediaan != null){
        $this->db->like('nama_persediaan', $nama_persediaan);
      }

      $this->db->order_by('tgl_input', 'desc');
      return $this->db->get();
  }

  function add($data, $log)
  {
    $this->db->trans_start();
    $this->db->insert('barang', $data);
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

  function edit($no_persediaan, $data, $log)
  {
    $this->db->trans_start();
    $this->db->where('no_persediaan', $no_persediaan)->update('barang', $data);
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

  function delete($no_persediaan, $log)
  {
    $this->db->trans_start();
    $this->db->where('no_persediaan', $no_persediaan)->delete('barang');
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
