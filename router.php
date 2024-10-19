<?php

require_once 'libs/response.php';

require_once 'app/middlewares/session.auth.middleware.php';
require_once 'app/middlewares/verify.auth.middleware.php';

require_once 'app/controllers/farmacia.controller.php';
require_once 'app/controllers/auth.controller.php';
require_once 'app/controllers/cliente.controller.php';

require_once 'app/models/farmacia.model.php';
require_once 'app/models/cliente.model.php';

require_once 'app/views/farmacia.view.php';
require_once 'app/views/cliente.view.php';

define('BASE_URL', '//' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']) . '/');

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

$params = explode('/', $action);

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
        sessionAuthMiddleware($res);
        verifyAuthMiddleware($res);
        $controller = new FarmaciaController($res);
        $controller->agregarMedicamento();
        break;




    case 'eliminar':
        sessionAuthMiddleware($res);
        verifyAuthMiddleware($res); // Verifica que el usuario esté logueado o redirige a login
        $controller = new FarmaciaController($res);
        $controller->eliminarMedicamento($params[1]);
        break;

    case 'actualizarMedicamento':
        sessionAuthMiddleware($res);
        verifyAuthMiddleware($res);
        $controller = new FarmaciaController($res);
        $controller->actualizarMedicamento();
        break;

    case 'verFormActualizar':
        sessionAuthMiddleware($res);
        if (isset($params[1])) {
            $id = $params[1];
            $controller = new FarmaciaController($res);
            $controller->verFormActualizar($id);
            break;
        }

    case 'verFormAgregar':
        sessionAuthMiddleware($res);
        $controller = new FarmaciaController();
        $controller->verFormAgregar();
        break;

    case 'clientes':
        sessionAuthMiddleware($res);
        $clienteController = new ClienteController();
        $clienteController->listarClientes();
        break;


    case 'cliente': // Asegúrate de que la acción coincide con la ruta

        if (isset($params[1])) {
            sessionAuthMiddleware($res);
            $idCliente = (int)$params[1];
            $clienteController = new ClienteController();
            $clienteController->verCliente($idCliente); // Obtén el cliente por ID
        } else {
            // Manejo de error: si no hay ID, puedes redirigir o mostrar un error
            echo "ID de cliente no proporcionado.";
        }
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
