<?php


	defined('BASEPATH') OR exit('No direct script access allowed');

	class RkeluarModel extends CI_Model
	{
		function add($return_keluar, $detail = array(), $log)
        {
            $this->db->trans_start();
            $this->db->insert('return_keluar', $return_keluar);
            $this->db->insert_batch('return_keluar_detail', $detail);
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

		function edit($no_return_keluar, $return_keluar, $detail = array(), $log)
        {
            $this->db->trans_start();
            $this->db->where('no_return_keluar', $no_return_keluar)->update('return_keluar', $return_keluar);
            $this->db->where('no_return_keluar', $no_return_keluar)->delete('return_keluar_detail');
            $this->db->insert_batch('return_keluar_detail', $detail);
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

		function edit_status($no_return_keluar, $return_keluar, $log)
        {
            $this->db->trans_start();
            $this->db->where('no_return_keluar', $no_return_keluar)->update('return_keluar', $return_keluar);
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

		function show($no_return_keluar = null)
        {
            $this->db->select('a.*, b.nama_supplier, b.alamat, b.fax, b.telepon, b.email, c.id_user, c.nama_user')
                     ->from('return_keluar a')
                     ->join('supplier b', 'b.id_supplier = a.id_supplier')
                     ->join('user c', 'c.id_user = a.id_user');

            if($no_return_keluar != null){
                $this->db->where('a.no_return_keluar', $no_return_keluar);
            }

            $this->db->order_by('a.no_return_keluar', 'desc');
            return $this->db->get();
        }

		function delete($no_return_keluar, $log)
        {
            $this->db->trans_start();
            $this->db->where('no_return_keluar', $no_return_keluar)->delete('return_keluar');
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

		function detail($no_return_keluar)
		{
			$this->db->select('a.*,  b.id_identifikasi, b.no_identifikasi, b.no_persediaan, b.keterangan, c.nama_persediaan')
					 ->from('return_keluar_detail a')
                     ->join('stock b', 'b.id_identifikasi = a.id_identifikasi')
                     ->join('barang c', 'c.no_persediaan = b.no_persediaan');

            if($no_return_keluar != null){
                $this->db->where('a.no_return_keluar', $no_return_keluar);
            }

            $this->db->order_by('a.id_dreturn_keluar', 'desc');
            return $this->db->get();
		}
  }

  ?>
