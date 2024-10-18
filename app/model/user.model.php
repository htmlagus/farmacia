<?php

class UsuarioModel
{
    private $db;

    public function __construct()
    {
        $this->db = new PDO('mysql:host=localhost;dbname=farmacia;charset=utf8', 'root', '');
    }

    public function obtenerUsuario($usuario)
    {

        $query = $this->db->prepare('SELECT * FROM usuarios WHERE usuario = ?');
        $query->execute([$usuario]);

        $user = $query->fetch(PDO::FETCH_OBJ);

        return $user;
    }
}
