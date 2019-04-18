<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class StockModel extends CI_Model {

    function show($id_identifikasi = null, $no_identifikasi = null, $no_persediaan = null)
    {
      $this->db->select('a.id_identifikasi, a.no_identifikasi, a.keterangan as ket_stock, a.saldo_awal, a.tgl_input, b.no_persediaan, b.nama_persediaan, b.satuan, b.warna, b.keterangan as ket_barang')
               ->from('stock a')
               ->join('barang b', 'b.no_persediaan = a.no_persediaan');

      if($id_identifikasi != null){
        $this->db->where('a.id_identifikasi', $id_identifikasi);
      }

      if($no_identifikasi != null){
        $this->db->like('a.no_identifikasi', $no_identifikasi);
      }

      if($no_persediaan != null){
        $this->db->like('b.no_persediaan', $no_persediaan);
      }

      $this->db->order_by('a.tgl_input', 'desc');
      return $this->db->get();
    }

    function add($data, $log)
    {
      $this->db->trans_start();
      $this->db->insert('stock', $data);
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

    function edit($param, $data, $log)
    {
      $this->db->trans_start();
      $this->db->where('id_identifikasi', $param)->update('stock', $data);
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

    function delete($param, $log)
    {
      $this->db->trans_start();
      $this->db->where('id_identifikasi', $param)->delete('stock');
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
