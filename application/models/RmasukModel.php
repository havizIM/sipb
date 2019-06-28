<?php


	defined('BASEPATH') OR exit('No direct script access allowed');

	class RmasukModel extends CI_Model
	{
		function add($return_masuk, $detail = array(), $log)
        {
            $this->db->trans_start();
            $this->db->insert('return_masuk', $return_masuk);
            $this->db->insert_batch('return_masuk_detail', $detail);
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

		function edit($no_return_masuk, $return_masuk, $detail = array(), $log)
        {
            $this->db->trans_start();
            $this->db->where('no_return_masuk', $no_return_masuk)->update('return_masuk', $return_masuk);
            $this->db->where('no_return_masuk', $no_return_masuk)->delete('return_masuk_detail');
            $this->db->insert_batch('return_masuk_detail', $detail);
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

		function edit_status($no_return_masuk, $return_masuk, $log)
        {
            $this->db->trans_start();
            $this->db->where('no_return_masuk', $no_return_masuk)->update('return_masuk', $return_masuk);
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

		function show($no_return_masuk = null)
        {
            $this->db->select('a.*, b.nama_customer, b.telepon, b.fax, b.email, b.alamat, c.id_user, c.nama_user')
                     ->from('return_masuk a')
                     ->join('customer b', 'b.id_customer = a.id_customer')
                     ->join('user c', 'c.id_user = a.id_user');

            if($no_return_masuk != null){
                $this->db->where('a.no_return_masuk', $no_return_masuk);
            }

            $this->db->order_by('a.no_return_masuk', 'desc');
            return $this->db->get();
        }

		function delete($no_return_masuk, $log)
        {
            $this->db->trans_start();
            $this->db->where('no_return_masuk', $no_return_masuk)->delete('return_masuk');
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

		function detail($no_return_masuk)
		{
			$this->db->select('a.*,  b.id_identifikasi, b.no_identifikasi, b.no_persediaan, b.keterangan, c.nama_persediaan')
					 ->from('return_masuk_detail a')
                     ->join('stock b', 'b.id_identifikasi = a.id_identifikasi')
                     ->join('barang c', 'c.no_persediaan = b.no_persediaan');

            if($no_return_masuk != null){
                $this->db->where('a.no_return_masuk', $no_return_masuk);
            }

            $this->db->order_by('a.id_dreturn_masuk', 'desc');
            return $this->db->get();
		}
  }

  ?>
