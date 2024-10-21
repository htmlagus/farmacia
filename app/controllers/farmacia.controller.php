<?php

// - Items

include_once 'app/models/farmacia.model.php';
include_once 'app/views/farmacia.view.php';

class FarmaciaController
{

    private $model;
    private $view;

    function __construct()
    {
        $this->model = new FarmaciaModel();
        $this->view = new FarmaciaView();
    }

    function mostrarInicio()
    {

        $compras = $this->model->obtenerMedicamentos();

        // actualizo la vista
        $this->view->mostrarInicio($compras);
    }

    public function visualizarMedicamento($compra_id)
    {

        $compra = $this->model->obtenerMedicamento($compra_id);

        if ($compra) {
            $cliente = $this->model->obtenerClientesPorId($compra->cliente_foranea_id);
            $this->view->visualizarMedicamento($compra, $cliente);
        } else {
            echo "No se encontró la compra con ID: " . ($compra_id);
        }
    }

    public function agregarMedicamento()
    {
        $campos = [
            'cantidad' => 'Falta completar el cantidad de la compra',
            'fecha_compra' => 'Falta completar la fecha de compra',
            'nombre_producto' => 'Falta completar el nombre del producto',
            'nombre_droga' => 'Falta completar el nombre de la droga',
            'precio' => 'Falta completar el precio',
            'cliente_id' => 'Falta seleccionar el cliente'
        ];

        // Validar los campos
        foreach ($campos as $campo => $mensajeError) {
            if (!isset($_POST[$campo]) || empty($_POST[$campo])) {
                return $this->view->mostrarError($mensajeError);
            }
        }

        // Si las validaciones pasan, escapa los datos
        $cliente_id = htmlspecialchars($_POST['cliente_id']);
        $cantidad = htmlspecialchars($_POST['cantidad']);
        $fecha_compra = htmlspecialchars($_POST['fecha_compra']);
        $nombre_producto = htmlspecialchars($_POST['nombre_producto']);
        $nombre_droga = htmlspecialchars($_POST['nombre_droga']);
        $precio = htmlspecialchars($_POST['precio']);

        // Llamar al modelo para agregar el medicamento
        $compra_id = $this->model->añadirMedicamento($cantidad, $fecha_compra, $nombre_producto, $nombre_droga, $precio, $cliente_id);

        // Redirigir al usuario después de agregar el medicamento
        header('Location: ' . BASE_URL);
        exit;
    }

    public function eliminarMedicamento($id)
    {
        // obtengo la tarea por id
        $task = $this->model->obtenerMedicamento($id);

        if (!$task) {
            return $this->view->mostrarError("No existe la tarea con el id=$id");
        }

        // borro la tarea y redirijo
        $this->model->borrarMedicamento($id);

        header('Location: ' . BASE_URL);
    }

    public function actualizarMedicamento()
    {

        $campos = [
            'cantidad' => 'Falta completar la cantidad del medicamento',
            'fecha_compra' => 'Falta completar la fecha de la compra',
            'nombre_producto' => 'Falta completar el nombre del producto',
            'nombre_droga' => 'Falta completar el nombre de la droga',
            'precio' => 'Falta completar el precio del medicamento',
            'cliente_id' => 'Falta seleccionar el cliente'
        ];

        // Validar todos los campos en un solo bucle

        foreach ($campos as $campo => $mensajeError) {
            if (!isset($_POST[$campo]) || empty($_POST[$campo])) {
                return $this->view->mostrarError($mensajeError);
            }
        }

        // Si todos los campos son válidos, tomamos los datos

        $id = $_POST['compra_id'];
        $cantidad = $_POST['cantidad'];
        $fecha_compra = $_POST['fecha_compra'];
        $nombre_producto = $_POST['nombre_producto'];
        $nombre_droga = $_POST['nombre_droga'];
        $precio = $_POST['precio'];
        $cliente_id = $_POST['cliente_id'];

        // Llamar al modelo para actualizar los datos
        $this->model->actualizarMedicamento($id, $cantidad, $fecha_compra, $nombre_producto, $nombre_droga, $precio, $cliente_id);

        // Redirigir al usuario
        header('Location: ' . BASE_URL);
        exit;
    }

    public function verFormActualizar($id)
    {

        $clientes = $this->model->obtenerClientes();
        $compra = $this->model->obtenerMedicamento($id);

        if (!$compra) {
            return $this->view->mostrarError("No existe la compra con el id=$id");
        }

        $this->view->verFormActualizar($compra, $clientes);
    }


    public function verFormAgregar()
    {

        $clientes = $this->model->obtenerClientes();
        $this->view->verFormAgregar($clientes);
    }
}
