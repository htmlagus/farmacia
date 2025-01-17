<?php

// - Items 

require_once 'app/models/config.php';

class FarmaciaModel
{
    protected $db;

    private function deploy()
    {
        $query = $this->db->query("SHOW TABLES LIKE 'clientes'");
        $tables = $query->fetchAll();

        if (count($tables) == 0) {
            $sql = <<<END
            CREATE TABLE `clientes` (
                `cliente_id` INT(11) NOT NULL AUTO_INCREMENT,
                `nombre` VARCHAR(255) NOT NULL,
                `dni` INT(11) NOT NULL,
                `apellido` VARCHAR(255) NOT NULL,
                `obra_social` VARCHAR(255) NOT NULL,
                PRIMARY KEY (`cliente_id`)
            );
    
            INSERT INTO `clientes` (`cliente_id`, `nombre`, `dni`, `apellido`, `obra_social`) VALUES
            (1, 'José', 34569231, 'Gutierrez', 'OSDE'),
            (2, 'María', 45678231, 'Lopez', 'IOMA');
    
            CREATE TABLE `compras` (
                `compra_id` INT(11) NOT NULL AUTO_INCREMENT,
                `cantidad` DECIMAL(10, 2) NOT NULL,
                `fecha_compra` DATE NOT NULL,
                `nombre_producto` VARCHAR(100) NOT NULL,
                `nombre_droga` VARCHAR(100) NOT NULL,
                `precio` INT(11) NOT NULL,
                `cliente_foranea_id` INT(11) NOT NULL,
                PRIMARY KEY (`compra_id`),
                FOREIGN KEY (`cliente_foranea_id`) REFERENCES `clientes`(`cliente_id`)
            );
    
            INSERT INTO `compras` (`compra_id`, `cantidad`, `fecha_compra`, `nombre_producto`, `nombre_droga`, `precio`, `cliente_foranea_id`) VALUES
            (1, 2.00, '2024-09-17', 'Tafirol', 'Paracetamol', 3000, 1),
            (2, 5.00, '2024-09-16', 'Alikal', 'Antiácido', 3500, 2);
    
            CREATE TABLE `usuarios` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `usuario` VARCHAR(250) NOT NULL,
                `contraseña` CHAR(60) NOT NULL,
                PRIMARY KEY (`id`)
            );
    
            INSERT INTO `usuarios` (`id`, `usuario`, `contraseña`) VALUES
            (1, 'webadmin', '$2y$10$4D4EvRG7Su3mNi7kc5/imeC6Avq8G6Bbeohvy4E0cjA5ZW7KyatL2'),
            (3, 'farmaceutico', '\$2y\$10\$FkLDMaMgLN1nnaC0N4g83O3DYsL2n6cNnzA/hcMgGNIHc74zjmR2e');
            END;

            $this->db->query($sql);
        }
    }


    public function __construct()
    {
        $this->db = new PDO(
            'mysql:host=' . MYSQL_HOST .
                ';dbname=' . MYSQL_DB .
                ';charset=utf8',
            MYSQL_USER,
            MYSQL_PASS
        );
        $this->deploy();
    }

    public function obtenerMedicamentos()
    {

        $query = $this->db->prepare('SELECT * FROM compras');
        $query->execute();

        $compras = $query->fetchAll(PDO::FETCH_OBJ);

        return $compras;
    }

    public function obtenerMedicamento($compra_id)
    {

        $query = $this->db->prepare('SELECT * FROM compras WHERE compra_id = ?');
        $query->execute([$compra_id]);

        $compra = $query->fetch(PDO::FETCH_OBJ);

        return $compra;
    }

    public function añadirMedicamento($cantidad, $fecha_compra, $nombre_producto, $nombre_droga, $precio, $cliente_foranea_id)
    {

        $query = $this->db->prepare('INSERT INTO compras (cantidad, fecha_compra, nombre_producto, nombre_droga, precio, cliente_foranea_id) VALUES (?, ?, ?, ?, ?, ?)');
        $query->execute([$cantidad, $fecha_compra, $nombre_producto, $nombre_droga, $precio, $cliente_foranea_id]);

        $id = $this->db->lastInsertId();

        return $id;
    }

    public function borrarMedicamento($id)
    {
        $query = $this->db->prepare('DELETE FROM compras WHERE compra_id = ?');
        $query->execute([$id]);
    }

    public function actualizarMedicamento($id, $cantidad, $fecha_compra, $nombre_producto, $nombre_droga, $precio, $cliente_foranea_id)
    {
        $query = $this->db->prepare('UPDATE compras SET cantidad = ?, fecha_compra = ?, nombre_producto = ?, nombre_droga = ?, precio = ?, cliente_foranea_id = ?WHERE compra_id = ?');
        $query->execute([$cantidad, $fecha_compra, $nombre_producto, $nombre_droga, $precio, $cliente_foranea_id, $id]);
    }

    public function obtenerClientes()
    {

        $query = $this->db->prepare('SELECT cliente_id, nombre, dni, apellido, obra_social FROM clientes');
        $query->execute();

        $clientes = $query->fetchAll(PDO::FETCH_OBJ);

        return $clientes;
    }

    public function obtenerClientesPorId($cliente_id)
    {
        $query = $this->db->prepare('SELECT nombre, apellido FROM clientes WHERE cliente_id = ?');
        $query->execute([$cliente_id]);

        return $query->fetch(PDO::FETCH_OBJ);
    }
}
