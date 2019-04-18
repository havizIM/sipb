<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class SupplierModel extends CI_Model {

    function show($id_supplier = null, $nama_supplier = null)
    {
      $this->db->select('*')->from('supplier');

      if($id_supplier != null){
        $this->db->where('id_supplier', $id_supplier);
      }

      if($nama_supplier != null){
        $this->db->like('nama_supplier', $nama_supplier);
      }

      $this->db->order_by('tgl_input', 'desc');
      return $this->db->get();
    }

    function add($data, $log)
    {
      $this->db->trans_start();
      $this->db->insert('supplier', $data);
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
      $this->db->where('id_supplier', $param)->update('supplier', $data);
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
      $this->db->where('id_supplier', $param)->delete('supplier');
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
