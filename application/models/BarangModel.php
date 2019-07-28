<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class BarangModel extends CI_Model {

  function show($no_persediaan = null, $nama_persediaan = null){

      $this->db->select('*')
               ->select('(SELECT sum(qty_keluar) FROM barang_keluar_detail, stock WHERE barang_keluar_detail.id_identifikasi = stock.id_identifikasi AND stock.no_persediaan = barang.no_persediaan) as jml_barang_keluar')
               ->select('(SELECT sum(qty_masuk) FROM barang_masuk_detail, stock WHERE barang_masuk_detail.id_identifikasi = stock.id_identifikasi AND stock.no_persediaan = barang.no_persediaan) as jml_barang_masuk')
               ->select('(SELECT sum(qty_return_keluar) FROM return_keluar_detail, stock WHERE return_keluar_detail.id_identifikasi = stock.id_identifikasi AND stock.no_persediaan = barang.no_persediaan) as jml_return_keluar')
               ->select('(SELECT sum(qty_return_masuk) FROM return_masuk_detail, stock WHERE return_masuk_detail.id_identifikasi = stock.id_identifikasi AND stock.no_persediaan = barang.no_persediaan) as jml_return_masuk')
               ->select('(SELECT sum(qty_masuk) FROM memorandum_detail, stock WHERE memorandum_detail.id_identifikasi = stock.id_identifikasi AND stock.no_persediaan = barang.no_persediaan) as jml_memorandum_in')
               ->select('(SELECT sum(qty_keluar) FROM memorandum_detail, stock WHERE memorandum_detail.id_identifikasi = stock.id_identifikasi AND stock.no_persediaan = barang.no_persediaan) as jml_memorandum_out')
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
