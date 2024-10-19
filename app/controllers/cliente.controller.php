<?php

include_once 'app/view/cliente.view.php';
include_once 'app/model/cliente.model.php';

class ClienteController
{
    private $model;
    private $view;

    public function __construct()
    {
        $this->model = new ClienteModel();
        $this->view = new ClienteView(); // Instanciamos de la vista
    }

    public function listarClientes()
    {
        $Clientes = $this->model->obtenerTodosLosClientes();
        $this->view->mostrarClientes($Clientes); // Llama al método de la vista
    }

    public function verCliente($id)
    {

        $cliente = $this->model->obtenerClientePorId($id);

        if ($cliente) {
            $this->view->mostrarCliente($cliente);
        } else {
            echo "Cliente no encontrado";
        }
    }
}
