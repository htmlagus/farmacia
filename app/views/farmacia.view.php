<?php

// - Items

class FarmaciaView
{
    private $user = null;

    public function mostrarInicio($compras)
    {

        $count = count($compras);

        require './templates/farmacia_listado.phtml';
    }

    public function visualizarMedicamento($compra, $cliente)
    {

        require 'templates/farmacia_visualizacion.phtml';
    }

    public function mostrarError($error)
    {

        require 'templates/error.phtml';
    }

    public function verFormAgregar($clientes)
    {

        require 'templates/form_agregar.phtml';
    }

    public function verFormActualizar($compra, $clientes)
    {

        require 'templates/form_actualizar.phtml';
    }
}
