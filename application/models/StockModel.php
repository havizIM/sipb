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

    function laporan($tgl_awal, $tgl_akhir)
    {
      $this->db->select('*')
               ->select('(SELECT sum(qty_keluar) FROM barang_keluar_detail, barang_keluar WHERE barang_keluar_detail.id_identifikasi = stock.id_identifikasi AND barang_keluar_detail.no_keluar = barang_keluar.no_keluar AND barang_keluar.tgl_keluar < DATE("'.$tgl_awal.'")) as jml_barang_keluar')
               ->select('(SELECT sum(qty_masuk) FROM barang_masuk_detail, barang_masuk WHERE barang_masuk_detail.id_identifikasi = stock.id_identifikasi AND barang_masuk_detail.no_masuk = barang_masuk.no_masuk AND barang_masuk.tgl_masuk < DATE("'.$tgl_awal.'")) as jml_barang_masuk')
               ->select('(SELECT sum(qty_return_keluar) FROM return_keluar_detail, return_keluar WHERE return_keluar_detail.id_identifikasi = stock.id_identifikasi AND return_keluar_detail.no_return_keluar = return_keluar.no_return_keluar AND return_keluar.tgl_return < DATE("'.$tgl_awal.'")) as jml_return_keluar')
               ->select('(SELECT sum(qty_return_masuk) FROM return_masuk_detail, return_masuk WHERE return_masuk_detail.id_identifikasi = stock.id_identifikasi AND return_masuk_detail.no_return_masuk = return_masuk.no_return_masuk AND return_masuk.tgl_return < DATE("'.$tgl_awal.'")) as jml_return_masuk')
               ->select('(SELECT sum(qty_masuk) FROM memorandum_detail, memorandum WHERE memorandum_detail.id_identifikasi = stock.id_identifikasi AND memorandum_detail.no_memo = memorandum.no_memo  AND memorandum.tgl_memo < DATE("'.$tgl_awal.'")) as jml_memorandum_in')
               ->select('(SELECT sum(qty_keluar) FROM memorandum_detail, memorandum WHERE memorandum_detail.id_identifikasi = stock.id_identifikasi AND memorandum_detail.no_memo = memorandum.no_memo AND memorandum.tgl_memo < DATE("'.$tgl_awal.'")) as jml_memorandum_out')

               ->select('(SELECT sum(qty_keluar) FROM barang_keluar_detail, barang_keluar WHERE barang_keluar_detail.id_identifikasi = stock.id_identifikasi AND barang_keluar_detail.no_keluar = barang_keluar.no_keluar AND barang_keluar.tgl_keluar BETWEEN DATE("'.$tgl_awal.'") AND DATE("'.$tgl_akhir.'")) as act_barang_keluar')
               ->select('(SELECT sum(qty_masuk) FROM barang_masuk_detail, barang_masuk WHERE barang_masuk_detail.id_identifikasi = stock.id_identifikasi AND barang_masuk_detail.no_masuk = barang_masuk.no_masuk AND barang_masuk.tgl_masuk BETWEEN DATE("'.$tgl_awal.'") AND DATE("'.$tgl_akhir.'")) as act_barang_masuk')
               ->select('(SELECT sum(qty_return_keluar) FROM return_keluar_detail, return_keluar WHERE return_keluar_detail.id_identifikasi = stock.id_identifikasi AND return_keluar_detail.no_return_keluar = return_keluar.no_return_keluar AND return_keluar.tgl_return BETWEEN DATE("'.$tgl_awal.'") AND DATE("'.$tgl_akhir.'")) as act_return_keluar')
               ->select('(SELECT sum(qty_return_masuk) FROM return_masuk_detail, return_masuk WHERE return_masuk_detail.id_identifikasi = stock.id_identifikasi AND return_masuk_detail.no_return_masuk = return_masuk.no_return_masuk AND return_masuk.tgl_return BETWEEN DATE("'.$tgl_awal.'") AND DATE("'.$tgl_akhir.'")) as act_return_masuk')
               ->select('(SELECT sum(qty_masuk) FROM memorandum_detail, memorandum WHERE memorandum_detail.id_identifikasi = stock.id_identifikasi AND memorandum_detail.no_memo = memorandum.no_memo  AND memorandum.tgl_memo BETWEEN DATE("'.$tgl_awal.'") AND DATE("'.$tgl_akhir.'")) as act_memorandum_in')
               ->select('(SELECT sum(qty_keluar) FROM memorandum_detail, memorandum WHERE memorandum_detail.id_identifikasi = stock.id_identifikasi AND memorandum_detail.no_memo = memorandum.no_memo AND memorandum.tgl_memo BETWEEN DATE("'.$tgl_awal.'") AND DATE("'.$tgl_akhir.'")) as act_memorandum_out')
               
               ->from('stock');


      $this->db->order_by('id_identifikasi', 'desc');
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
