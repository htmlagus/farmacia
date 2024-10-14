<?php

require_once 'app/controllers/farmacia.controller.php';
require_once 'app/model/farmacia.model.php';
require_once 'app/view/farmacia.view.php';

define('BASE_URL', '//'.$_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']).'/');

// inicio -> mostrarInicio()
// visualizar -> visualizarMedicamento()

$action = 'inicio';

if (!empty($_GET["action"])) {
    $action = $_GET["action"];
}

$params = explode('/',$action);

switch ($params[0]) {
    
    case 'inicio':
        $controller = new FarmaciaController();
        $controller->mostrarInicio();
        break;

    case 'visualizar':
            
     if (!empty($params[1])) { 
        
         $compra_id = $params[1];
         $controller = new FarmaciaController();
         $controller->visualizarMedicamento($compra_id);

        } else {
                echo "Error: ID de compra no válido o no presente.";
            }
            
        break;
     
}