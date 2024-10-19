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
}
