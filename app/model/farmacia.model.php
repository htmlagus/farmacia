<?php

// - Items

class FarmaciaModel {
    private $db;

    public function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=farmacia;charset=utf8', 'root','');
    }

    public function obtenerMedicamentos() {;
    
        $query = $this->db->prepare('SELECT * FROM compras');
        $query->execute();
    
        $compras = $query->fetchAll(PDO::FETCH_OBJ);
    
        return $compras;
    }

    public function obtenerMedicamento($compra_id) { 

        $query = $this->db->prepare('SELECT * FROM compras WHERE compra_id = ?');
        $query->execute([$compra_id]);   
    
        $compra = $query->fetch(PDO::FETCH_OBJ);
    
        return $compra;
    }

    public function añadirMedicamento($monto, $fecha_compra, $nombre_producto, $nombre_droga, $precio, $cliente_foranea_id) {
         
        $query = $this->db->prepare('INSERT INTO compras (monto, fecha_compra, nombre_producto, nombre_droga, precio, cliente_foranea_id) VALUES (?, ?, ?, ?, ?, ?)');
        $query->execute([$monto, $fecha_compra, $nombre_producto, $nombre_droga, $precio, $cliente_foranea_id]);
    
        $id = $this->db->lastInsertId();
    
        return $id;
    }

    // agregar modelos de eliminar y actualizar


    public function obtenerClientes() {

        $query = $this->db->prepare('SELECT cliente_id, nombre, dni, apellido, obra_social FROM clientes');
        $query->execute();
        
        $clientes = $query->fetchAll(PDO::FETCH_OBJ);
    
        return $clientes;
    }
}