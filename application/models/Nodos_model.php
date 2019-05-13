<?php

class Nodos_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get($id = null) {
        if (!is_null($id)) {
            $query = $this->db->select("*")->from("nodes")->where("id", $id)->get();
            if ($query->num_rows() === 1) {
                return $query->row_array();
            }
            return false;
        } else {
            $query = $this->db->select("*")->from("nodes")->get();
            if ($query->num_rows() > 0){
                
                return $query->result_array();
            } else {
                return false;
            }
        }
    }

    public function save($nodo) {
        $this->db->set($this->__setNodo($nodo))->insert("nodes");
        if ($this->db->affected_rows() === 1) {
            return true;
        } else {
            return false;
        }
    }

    public function update($id, $costo) {
        $this->db->set($this->__setNodo($costo))->where("id", $id)->update("nodes");
        if ($this->db->affected_rows() === 1) {
            return true;
        } else {
            return false;
        }
    }

    public function delete($id) {
        $this->db->where("id", $id)->delete("nodes");
        if ($this->db->affected_rows() === 1) {
            return true;
        } else {
            return false;
        }
    }

    public function active($id, $status) {
        $updateAll = array("status" => 0);
        $this->db->update("nodes", $updateAll);
        $updateData = array("status" => $status);
        $this->db->where("id", $id);
        $this->db->update("nodes", $updateData);
        if ($this->db->affected_rows() === 1) {
            return true;
        } else {
            return false;
        }
    }

    private function __setNodo($nodo) {
        
        $query = $this->db->select("Id")->where("Nodo", $nodo["padre"])->from("nodes")->get();
        $parent = "";
        if ($query->num_rows() > 0) {
            $parent = $query->row_array();
            $parent = $parent["Id"];
        }
        
        
        return array(
            "Id" => $nodo["id"],
            "Nodo" => $nodo['nodo'],
            "Padre" => $parent,
            "Dir" => $nodo['Dir']
        );
    }

    public function getActiveCosto() {
        $query = $this->db->select("id")->where("status",1)->from("nodes")->get();
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }

}
