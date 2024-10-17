<?php

// - Items

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

        $clientes = $this->model->obtenerClientes();
    
        if ($compra) {
            return $this->view->visualizarMedicamento($compra, $clientes);
        } else {
            echo "No se encontró la compra con ID: " . ($compra_id);
        }
    }

    public function agregarMedicamento() {

        if (!isset($_POST['monto']) || empty($_POST['monto'])) {
            return $this->view->mostrarError('Agrege un monto.');
        }
    
        if (!isset($_POST['fecha_compra']) || empty($_POST['fecha_compra'])) {
            return $this->view->mostrarError('Agrege una fecha.');
        }

        if (!isset($_POST['nombre_producto']) || empty($_POST['nombre_producto'])) {
            return $this->view->mostrarError('Agrege un producto.');
        }

        if (!isset($_POST['nombre_droga']) || empty($_POST['nombre_droga'])) {
            return $this->view->mostrarError('Agrege el nombre de la droga.');
        }

        if (!isset($_POST['precio']) || empty($_POST['precio'])) {
            return $this->view->mostrarError('Agrege un precio.');
        }
        
        $cliente_id = $_POST ['cliente_id'];
        $monto = $_POST['monto'];
        $fecha_compra = $_POST['fecha_compra'];
        $nombre_producto = $_POST['nombre_producto'];
        $nombre_droga = $_POST['nombre_droga'];
        $precio = $_POST['precio'];
    
        $compra_id = $this->model->añadirMedicamento( $monto, $fecha_compra, $nombre_producto, $nombre_droga, $precio, $cliente_id,);
    
        header('Location: '. BASE_URL);
    }

    public function verFormAgregar() {

        $clientes = $this->model->obtenerClientes();
        $this->view->verFormAgregar($clientes);
    }
}