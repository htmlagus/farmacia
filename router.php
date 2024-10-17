<?php

require_once 'libs/response.php';

require_once 'app/middlewares/session.auth.middleware.php';
require_once 'app/middlewares/verify.auth.middleware.php';

require_once 'app/controllers/farmacia.controller.php';
require_once 'app/controllers/auth.controller.php';

require_once 'app/model/farmacia.model.php';
require_once 'app/view/farmacia.view.php';

define('BASE_URL', '//'.$_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']).'/');

// inicio -> mostrarInicio()
// visualizar -> visualizarMedicamento()
// agregar -> agregarMedicamento();
// eliminar -> eliminarMedicamento();
// editar -> editarMedicamento();


$res = new Response();

$action = 'inicio';

if (!empty($_GET["action"])) {
    $action = $_GET["action"];
}

$params = explode('/',$action);

switch ($params[0]) {
    
    case 'inicio':
        sessionAuthMiddleware($res);
        $controller = new FarmaciaController();
        $controller->mostrarInicio();
        break;

    case 'visualizar':
            
     if (!empty($params[1])) { 
         sessionAuthMiddleware($res);
         $compra_id = $params[1];
         $controller = new FarmaciaController();
         $controller->visualizarMedicamento($compra_id);
        } else {
                echo "Error: ID de compra no válido o no presente.";
        }
         break;

     case 'agregarMedicamento':
         $controller = new FarmaciaController();
         $controller->agregarMedicamento();
         break;

    case 'verFormAgregar':
          $controller = new FarmaciaController();
          $controller->verFormAgregar();
          break;

    case 'mostrarLogin':
          $controller = new AuthController();
          $controller->mostrarLogin();
          break;

    case 'login':
          $controller = new AuthController();
          $controller->login();
          break;
          
          case 'logout':
            $controller = new AuthController();
            $controller->logout();
            break;
}