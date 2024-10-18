<?php
function sessionAuthMiddleware($res)
{
    session_start();
    if (isset($_SESSION['ID_USER'])) {
        $res->user = new stdClass();
        $res->user->id = $_SESSION['ID_USER'];
        $res->user->usuario = $_SESSION['USERNAME'];
        return;
    }
}
