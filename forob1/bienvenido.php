<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    echo "Acceso denegado. <a href='login.html'>Iniciar sesión</a>";
    exit();
}

echo "¡Bienvenido a tu perfil, usuario con ID " . $_SESSION['usuario_id'] . "!";
?>