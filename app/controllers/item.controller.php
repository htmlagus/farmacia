<?php

include_once 'app/model/item.model.php';
include_once 'app/view/item.view.php';

class ItemController
{
    private $model;
    private $view;

    public function __construct()
    {
        $this->model = new ItemModel();
        $this->view = new ItemView(); // Instanciamos de la vista
    }

    public function listarComprasPorClientes($idClientes)
    {
        $Compras = $this->model->obtenerItemsPorCliente($idClientes);
        $this->view->mostrarCompras($Compras); // Llama al método de la vista
    }
}
