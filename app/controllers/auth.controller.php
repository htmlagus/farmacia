<?php
require_once 'app/models/user.model.php';
require_once 'app/views/auth.view.php';

class AuthController
{

    private $model;
    private $view;

    function __construct()
    {
        $this->model = new UsuarioModel();
        $this->view = new AuthView();
    }

    function mostrarLogin()
    {

        // muestro form de login
        return $this->view->mostrarLogin();
    }


    public function login()


    {
        if (!isset($_POST['usuario']) || empty($_POST['usuario'])) {
            return $this->view->mostrarLogin('Falta completar el nombre de usuario');
        }

        if (!isset($_POST['contraseña']) || empty($_POST['contraseña'])) {
            return $this->view->mostrarLogin('Falta completar la contraseña');
        }

        $usuario = htmlspecialchars($_POST['usuario']);
        $contraseña = htmlspecialchars($_POST['contraseña']);

        // Verificar que el usuario está en la base de datos
        $userFromDB = $this->model->obtenerUsuario($usuario);

        if ($userFromDB && password_verify($contraseña, $userFromDB->contraseña)) {
            // Guardo en la sesión el ID del usuario
            session_start();
            session_regenerate_id(true); // Regenera el Id de la sesion para evitar ataques de fijacion de sesion
            $_SESSION['ID_USER'] = $userFromDB->id;
            $_SESSION['USERNAME'] = $userFromDB->usuario;
            $_SESSION['LAST_ACTIVITY'] = time();

            // Redirijo al home
            header('Location: ' . BASE_URL);
        } else {
            return $this->view->mostrarLogin('Credenciales incorrectas');
        }
    }

    public function logout()
    {
        session_start(); // Va a buscar la cookie
        session_unset();
        session_destroy(); // Borra la cookie que se buscó
        header('Location: ' . BASE_URL);
        exit();
    }
}
