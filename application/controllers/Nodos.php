<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . "/libraries/REST_Controller.php";

class Nodos extends \Restserver\Libraries\REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("nodos_model");
    }

    public function index_get() {
        $nodos = $this->nodos_model->get();
        
        $nodoArr = [];
        $edgesArr = [];        
        
        if (!is_null($nodos)) {
            foreach ($nodos as $clave => $nodo) {           
                $arrNodo = array(
                    "id" => $nodo["Id"],
                    "label" => $nodo["Nodo"]
                );
                array_push($nodoArr, $arrNodo);            
                
                $Edges = array(
                    "id" => $nodo["Id"],
                    "from" => $nodo["Padre"],
                    "to" => $nodo["Id"]
                );
                array_push($edgesArr, $Edges);
            }
            
            $this->response(array("Nodes" => $nodoArr,"Edges" => $edgesArr, "status" => 200));
        } else {
            $this->response(array("error" => "no hey registros de nodess", "status" => 404));
        }
    }

    public function find_get($id) {
        if (!$id) {
            $this->response(null, 404);
        }
        $nodos = $this->nodos_model->get($id);
        if (!is_null($nodos)) {
            
            
            
            $this->response(array("response" => $nodos, "status" => 200));
        } else {
            $this->response(array("error" => "no se encontro el nodes", "status" => 404));
        }
    }

    public function index_post() {
        if ($this->post("nodes")) {
            $id = $this->nodos_model->save($this->post("nodes"));
            if (!is_null($id)) {
                $this->response(array("response" => $id, "status" => 202));
            } else {
                $this->response(array("error" => "error de servidor", "status" => 400));
            }
        } else {
            $this->response(array("error" => "falta informacion", "status" => 400));
        }
    }

    public function index_put($id) {
        if (!$this->put("nodes") || !$id || !$this->put("status")) {
            $this->response(null, 400);
        }
        if ($this->put("nodes") && $id) {
            $update = $this->nodos_modelx->update($id, $this->put("nodes"));
            if (!is_null($update)) {
                $this->response(array("response" => "se ha iditado correctamente", "status" => 200));
            } else {
                $this->response(array("error" => "error de servidor", "status" => 400));
            }
        }
        if ($this->put("status") && $id) {
            $update = $this->nodos_model->active($id, $this->put("status"));
            if (!is_null($update)) {
                $this->response(array("response" => "se ha iditado correctamente", "status" => 200));
            } else {
                $this->response(array("error" => "error de servidor", "status" => 400));
            }
        }
    }

    public function index_delete($id) {
        if (!$id) {
            $this->response(null, 400);
        }

        $delete = $this->nodos_model->delete($id);
        if (!is_null($delete)) {
            $this->response(array("response" => "se ha eliminado correctamente", "status" => 200));
        } else {
            $this->response(array("error" => "error de servidor", "status" => 400));
        }
    }

    

}
