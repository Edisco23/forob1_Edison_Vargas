"<?php
$host = "localhost";
$db = "usuarios_db";
$user = "root@localhost";
$password = "";
$conn = new mysqli($host, $user, $password, $db);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_usuario = $_POST['nombre_usuario'];
    $correo_electronico = $_POST['correo_electronico'];
    $contrasena = $_POST['contrasena'];

    $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (nombre_usuario, correo_electronico, contrasena) 
            VALUES (?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sss", $nombre_usuario, $correo_electronico, $contrasena_hash);

        if ($stmt->execute()) {
            echo "Registro exitoso. <a href='login.html'>Iniciar sesión</a>";
        } else {
            echo "Error al registrar el usuario: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error al preparar la consulta: " . $conn->error;
    }

    // Cerrar la conexión
    $conn->close();
}
?>