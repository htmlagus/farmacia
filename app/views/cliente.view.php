<?php

class ClienteView
{
    public function mostrarClientes($clientes)
    {
        require 'templates/clientes.phtml';
    }

    public function mostrarCliente($cliente)
    {
        require 'templates/cliente.phtml';
    }

    public function mostrarError($error)
    {

        require 'templates/error.phtml';
    }

    public function editarClienteForm($cliente)
    {
        require 'templates/actualizarCliente.phtml';
    }

    public function agregarClienteForm(){
        require 'templates/agregarCliente.phtml';
    }}
