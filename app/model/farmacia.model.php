<?php

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
}