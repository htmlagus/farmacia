<?php

include_once 'app/views/cliente.view.php';
include_once 'app/models/cliente.model.php';

class ClienteController
{
    private $model;
    private $view;

    public function __construct()
    {
        $this->model = new ClienteModel();
        $this->view = new ClienteView(); // Instanciamos de la vista
    }

    public function listarClientes()
    {
        $Clientes = $this->model->obtenerTodosLosClientes();
        $this->view->mostrarClientes($Clientes);
    }

    public function verCliente($id)
    {

        $cliente = $this->model->obtenerClientePorId($id);

        if ($cliente) {
            $this->view->mostrarCliente($cliente);
        } else {
            echo "Cliente no encontrado";
        }
    }

    public function agregarCliente()
    { {

            $campos = [
                'nombre' => 'Falta completar el nombre',
                'apellido' => 'Falta completar el apellido',
                'dni' => 'Falta completar el Dni',
                'obra_social' => 'Falta completar la obra social',
            ];

            // Validacion de campos

            foreach ($campos as $campo => $mensajeError) {
                if (!isset($_POST[$campo]) || empty($_POST[$campo])) {
                    return $this->view->mostrarError($mensajeError);
                }
            }

            // Si las validaciones son correctas entonces

            $nombre = htmlspecialchars($_POST['nombre']);
            $apellido = htmlspecialchars($_POST['apellido']);
            $dni = htmlspecialchars($_POST['dni']);
            $obra_social = htmlspecialchars($_POST['obra_social']);

            // Llamo al modelo para crear el cliente

            $cliente_id = $this->model->agregarCliente($nombre, $apellido,  $dni, $obra_social);

            header('Location: ' . BASE_URL . 'clientes');
            exit;
        }
    }

    public function agregarClienteForm()
    {
        $this->view->agregarClienteForm();
    }

    public function actualizarClienteForm($id)
    {
        $cliente = $this->model->obtenerClientePorId($id);
        $this->view->editarClienteForm($cliente);
    }

    public function eliminarCliente($id)
    {
        // Borro la tarea y redirijo

        $this->model->borrarCliente($id);

        header('Location: ' . BASE_URL);
    }

    public function editarCliente()
    {

        $campos = [
            'nombre' => 'Falta completar el nombre',
            'apellido' => 'Falta completar el apellido',
            'dni' => 'Falta completar el Dni',
            'obra_social' => 'Falta completar la obra social',
        ];

        // Validacion de campos

        foreach ($campos as $campo => $mensajeError) {
            if (!isset($_POST[$campo]) || empty($_POST[$campo])) {
                return $this->view->mostrarError($mensajeError);
            }
        }

        // Si las validaciones son correctas entonces

        $cliente_id = ($_POST['cliente_id']);
        $nombre = ($_POST['nombre']);
        $apellido = ($_POST['apellido']);
        $dni = ($_POST['dni']);
        $obra_social = ($_POST['obra_social']);

        // Llamo al modelo para editar el cliente

        $res = $this->model->editarCliente($nombre, $apellido,  $dni, $obra_social, $cliente_id);

        if ($res) {
            header('Location: ' . BASE_URL . 'clientes');
            exit;
        } else {
            // Manejar el error, quizás redirigir a una página de error o mostrar un mensaje
            return $this->view->mostrarError('Error al actualizar el cliente.');
        }

        exit;
    }
}
