<?php

$host = 'localhost';
$dbname = 'usuarios_db';
$username = 'root';
$password = '';
$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_usuario = $_POST['nombre_usuario'];
    $contrasena = $_POST['contrasena'];


    $sql = "SELECT id, contrasena FROM usuarios WHERE nombre_usuario = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $nombre_usuario);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($id, $contrasena_hash);

        if ($stmt->fetch()) {
            if (password_verify($contrasena, $contrasena_hash)) {
                session_start();
                $_SESSION['usuario_id'] = $id;
                echo "Bienvenido, " . $nombre_usuario . "! <a href='bienvenido.php'>Ir a tu perfil</a>";
            } else {
                echo "Contraseña incorrecta.";
            }
        } else {
            echo "El usuario no existe.";
        }
        $stmt->close();
    }

    $conn->close();
}
?>