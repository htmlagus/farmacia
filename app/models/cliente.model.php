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

    public function obtenerClientePorId($cliente_id)
    {
        $query = $this->db->prepare("SELECT * FROM clientes WHERE cliente_id = :cliente_id");
        $query->bindParam(':cliente_id', $cliente_id, PDO::PARAM_INT);
        $query->execute();
        return $query->fetch(PDO::FETCH_OBJ);
    }


    public function agregarCliente($nombre, $apellido, $dni, $obra_social)
    {
        $query = $this->db->prepare('INSERT INTO clientes (nombre, apellido,  dni, obra_social) VALUES (?,?,?,?)');
        $query->execute([$nombre, $apellido,  $dni, $obra_social]);

        $id = $this->db->lastInsertId();

        return $id;
    }


    public function borrarCliente($id)
    {
        $query = $this->db->prepare('DELETE FROM clientes WHERE cliente_id = ?');
        $query->execute([$id]);
    }

    public function editarCliente($cliente_id, $nombre, $apellido, $dni, $obra_social)
    {
        $query = $this->db->prepare('UPDATE clientes SET nombre = ?, apellido = ?, dni = ?, obra_social = ? WHERE cliente_id = ?');
        $query->execute([$nombre, $apellido, $dni, $obra_social, $cliente_id]);
    }
}
