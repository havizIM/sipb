<?php


	defined('BASEPATH') OR exit('No direct script access allowed');

	class BmasukModel extends CI_Model
	{
		function add($barang_masuk, $detail = array(), $log)
        {
            $this->db->trans_start();
            $this->db->insert('barang_masuk', $barang_masuk);
            $this->db->insert_batch('barang_masuk_detail', $detail);
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

		function edit($no_masuk, $barang_masuk, $detail = array(), $log)
        {
            $this->db->trans_start();
            $this->db->where('no_masuk', $no_masuk)->update('barang_masuk', $barang_masuk);
            $this->db->where('no_masuk', $no_masuk)->delete('barang_masuk_detail');
            $this->db->insert_batch('barang_masuk_detail', $detail);
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

		function edit_status($no_masuk, $barang_masuk, $log)
        {
            $this->db->trans_start();
            $this->db->where('no_masuk', $no_masuk)->update('barang_masuk', $barang_masuk);
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

		function show($no_masuk = null)
        {
            $this->db->select('a.*, b.nama_supplier, b.telepon, b.fax, b.email, b.alamat, c.id_user, c.nama_user')
                     ->from('barang_masuk a')
                     ->join('supplier b', 'b.id_supplier = a.id_supplier')
                     ->join('user c', 'c.id_user = a.id_user');

            if($no_masuk != null){
                $this->db->where('a.no_masuk', $no_masuk);
            }

            $this->db->order_by('a.no_masuk', 'desc');
            return $this->db->get();
        }

		function delete($no_masuk, $log)
        {
            $this->db->trans_start();
            $this->db->where('no_masuk', $no_masuk)->delete('barang_masuk');
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

		function detail($no_masuk)
		{
			$this->db->select('a.*,  b.id_identifikasi, b.no_identifikasi, b.no_persediaan, b.keterangan, c.nama_persediaan')
					 ->from('barang_masuk_detail a')
                     ->join('stock b', 'b.id_identifikasi = a.id_identifikasi')
                     ->join('barang c', 'c.no_persediaan = b.no_persediaan');

            if($no_masuk != null){
                $this->db->where('a.no_masuk', $no_masuk);
            }

            $this->db->order_by('a.id_masuk_detail', 'desc');
            return $this->db->get();
		}
  }

  ?>
