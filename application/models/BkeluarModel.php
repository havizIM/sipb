<?php


	defined('BASEPATH') OR exit('No direct script access allowed');

	class BkeluarModel extends CI_Model
	{
		function add($barang_keluar, $detail = array(), $log)
        {
            $this->db->trans_start();
            $this->db->insert('barang_keluar', $barang_keluar);
            $this->db->insert_batch('barang_keluar_detail', $detail);
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

		function edit($no_keluar, $barang_keluar, $detail = array(), $log)
        {
            $this->db->trans_start();
            $this->db->where('no_keluar', $no_keluar)->update('barang_keluar', $barang_keluar);

            if(!empty($detail)){
                $this->db->where('no_keluar', $no_keluar)->delete('barang_keluar_detail');
                $this->db->insert_batch('barang_keluar_detail', $detail);
            }

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

		function edit_status($no_keluar, $barang_keluar, $log)
        {
            $this->db->trans_start();
            $this->db->where('no_keluar', $no_keluar)->update('barang_keluar', $barang_keluar);
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

		function show($no_keluar = null)
        {
            $this->db->select('a.*, b.nama_customer, c.id_user, c.nama_user')
                     ->from('barang_keluar a')
                     ->join('customer b', 'b.id_customer = a.id_customer')
                     ->join('user c', 'c.id_user = a.id_user');

            if($no_keluar != null){
                $this->db->where('a.no_keluar', $no_keluar);
            }

            $this->db->order_by('a.no_keluar', 'desc');
            return $this->db->get();
        }

		function delete($no_keluar, $log)
        {
            $this->db->trans_start();
            $this->db->where('no_keluar', $no_keluar)->delete('barang_keluar');
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

		function detail($no_keluar)
		{
			$this->db->select('a.*,  b.id_identifikasi, b.no_identifikasi, b.no_persediaan, b.keterangan, c.nama_persediaan')
					 ->from('barang_keluar_detail a')
                     ->join('stock b', 'b.id_identifikasi = a.id_identifikasi')
                     ->join('barang c', 'c.no_persediaan = b.no_persediaan');

            if($no_keluar != null){
                $this->db->where('a.no_keluar', $no_keluar);
            }

            $this->db->order_by('a.id_keluar_detail', 'desc');
            return $this->db->get();
		}
  }

  ?>
