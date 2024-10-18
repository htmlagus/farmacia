<?php

class AuthView
{
    private $user = null;

    public function mostrarLogin($error = '')
    {
        require 'templates/form_login.phtml';
    }
}
