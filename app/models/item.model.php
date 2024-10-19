<?php

class ItemModel
{
    private $db;

    public function __construct()
    {
        $this->db = new PDO('mysql:host=localhost;dbname=farmacia;charset=utf8', 'root', '');
    }

    public function obtenerItemsPorCliente($idCliente)
    {
        $query = $this->db->prepare("SELECT * FROM compras WHERE cliente_id = ?");
        $query->execute([$idCliente]);
        return $query->fetchAll(PDO::FETCH_OBJ); // Retorna los ítems de esa categoría
    }
}
