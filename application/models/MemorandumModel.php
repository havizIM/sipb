<?php


	defined('BASEPATH') OR exit('No direct script access allowed');

	class MemorandumModel extends CI_Model
	{
		function add($memorandum, $detail = array(), $log)
        {
            $this->db->trans_start();
            $this->db->insert('memorandum', $memorandum);
            $this->db->insert_batch('memorandum_detail', $detail);
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

		function edit($no_memo, $memorandum, $detail = array(), $log)
        {
            $this->db->trans_start();
            $this->db->where('no_memo', $no_memo)->update('memorandum', $memorandum);
            $this->db->where('no_memo', $no_memo)->delete('memorandum_detail');
            $this->db->insert_batch('memorandum_detail', $detail);
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

		function edit_status($no_memo, $memorandum, $log)
        {
            $this->db->trans_start();
            $this->db->where('no_memo', $no_memo)->update('memorandum', $memorandum);
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

		function show($no_memo = null)
        {
            $this->db->select('a.*, c.id_user, c.nama_user')
                     ->from('memorandum a')
                     ->join('user c', 'c.id_user = a.id_user');

            if($no_memo != null){
                $this->db->where('a.no_memo', $no_memo);
            }

            $this->db->order_by('a.no_memo', 'desc');
            return $this->db->get();
        }

		function delete($no_memo, $log)
        {
            $this->db->trans_start();
            $this->db->where('no_memo', $no_memo)->delete('memorandum');
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

		function detail($no_memo)
		{
			$this->db->select('a.*,  b.id_identifikasi, b.no_identifikasi, b.no_persediaan, c.nama_persediaan')
					 ->from('memorandum_detail a')
                     ->join('stock b', 'b.id_identifikasi = a.id_identifikasi')
                     ->join('barang c', 'c.no_persediaan = b.no_persediaan');

            if($no_memo != null){
                $this->db->where('a.no_memo', $no_memo);
            }

            $this->db->order_by('a.id_memorandum_detail', 'desc');
            return $this->db->get();
		}
  }

  ?>
