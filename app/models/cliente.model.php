<?php

class ClienteModel
{
    private $db;

    public function __construct()
    {
        $this->db = new PDO('mysql:host=localhost;dbname=farmacia;charset=utf8', 'root', '');
    }

    public function obtenerTodosLosClientes()
    {
        $query = $this->db->prepare("SELECT * FROM clientes");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ); // Retorna todas las categorías como objetos
    }

    public function obtenerClientePorId($cliente_id){
        $query = $this->db->prepare("SELECT * FROM clientes WHERE cliente_id = :cliente_id");
        $query -> bindParam(':cliente_id', $cliente_id, PDO::PARAM_INT);
        $query-> execute();
        return $query-> fetch(PDO::FETCH_OBJ);
    }

}
