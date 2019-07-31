<?php


	defined('BASEPATH') OR exit('No direct script access allowed');

	class PesananModel extends CI_Model
	{
		function add($pesanan, $detail = array(), $log)
    {
      $this->db->trans_start();
      $this->db->insert('pesanan', $pesanan);
			$this->db->insert_batch('pesanan_detail', $detail);
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

		function edit($no_pesanan, $pesanan, $detail = array(), $log)
    {
      $this->db->trans_start();
      $this->db->where('no_pesanan', $no_pesanan)->update('pesanan', $pesanan);
			$this->db->where('no_pesanan', $no_pesanan)->delete('pesanan_detail');
			$this->db->insert_batch('pesanan_detail', $detail);
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

		function edit_status($no_pesanan, $pesanan, $log)
    {
      $this->db->trans_start();
      $this->db->where('no_pesanan', $no_pesanan)->update('pesanan', $pesanan);
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

		function show($no_pesanan = null, $otorisasi)
    {
      $this->db->select('a.*, b.nama_customer, c.id_user, c.nama_user')
							 ->from('pesanan a')
							 ->join('customer b', 'b.id_customer = a.id_customer')
               ->join('user c', 'c.id_user = a.id_user');

      if($no_pesanan != null){
        $this->db->where('a.no_pesanan', $no_pesanan);
      }

      if($otorisasi->level == 'Sales'){
        $this->db->where('a.id_user', $otorisasi->id_user);
      }

			if($otorisasi->level == 'Admin' && $otorisasi->level == 'Kepala Gudang'){
        $this->db->where('a.status', 'Disetujui');
      }

      $this->db->order_by('a.no_pesanan', 'desc');
      return $this->db->get();
    }

    function riwayat($customer)
    {
      $this->db->select('a.*, b.nama_customer, c.id_user, c.nama_user')
							 ->from('pesanan a')
							 ->join('customer b', 'b.id_customer = a.id_customer')
               ->join('user c', 'c.id_user = a.id_user');

      
      $this->db->where('a.id_customer', $customer);
      

      $this->db->order_by('a.no_pesanan', 'desc');
      return $this->db->get();
    }

    function laporan($where)
    {
      $this->db->select('a.*, b.nama_customer, c.id_user, c.nama_user')
							 ->from('pesanan a')
							 ->join('customer b', 'b.id_customer = a.id_customer')
               ->join('user c', 'c.id_user = a.id_user');

      if(!empty($where)){
        foreach($where as $key => $value){
            if($value != null){
                $this->db->where($key, $value);
            }
        }
      }

      $this->db->order_by('a.no_pesanan', 'desc');
      return $this->db->get();
    }

		function delete($no_pesanan, $log)
    {
      $this->db->trans_start();
      $this->db->where('no_pesanan', $no_pesanan)->delete('pesanan');
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

		function detail($no_pesanan)
		{
			$this->db->select('a.id_detail_pesanan, a.keterangan, a.qty_pesanan,  b.no_persediaan, b.nama_persediaan')
							 ->from('pesanan_detail a')
							 ->join('barang b', 'b.no_persediaan = a.no_persediaan');

      if($no_pesanan != null){
        $this->db->where('a.no_pesanan', $no_pesanan);
      }

      $this->db->order_by('a.id_detail_pesanan', 'desc');
      return $this->db->get();
		}
  }

  ?>
