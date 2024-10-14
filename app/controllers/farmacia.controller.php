<?php

include_once 'app/model/farmacia.model.php';
include_once 'app/view/farmacia.view.php';

class FarmaciaController {

    private $model;
    private $view;

    function __construct() {
        $this->model = new FarmaciaModel();
        $this->view = new FarmaciaView();
    }

    function mostrarInicio() {

        $compras = $this->model->obtenerMedicamentos();

        // actualizo la vista
        $this->view->mostrarInicio($compras);
    }

    public function visualizarMedicamento($compra_id) {

        $compra = $this->model->obtenerMedicamento($compra_id);
    
        if ($compra) {
            return $this->view->visualizarMedicamento($compra);
        } else {
            echo "No se encontró la compra con ID: " . ($compra_id);
        }
    }
}