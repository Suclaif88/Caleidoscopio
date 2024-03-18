<?php
// Conectar a la base de datos
$conexion = new mysqli("localhost", "vale", "Salem31ob", "apes");

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Obtener datos del formulario
$identificacion = $_POST['identificacion'];
$contrasena = $_POST['contrasena'];

// Consultar la base de datos para verificar credenciales
$sql = "SELECT * FROM usuarios WHERE identificacion = '$identificacion' AND contrasena = '$contrasena'";
$resultado = $conexion->query($sql);

// Verificar si se encontró un usuario con esas credenciales
if ($resultado->num_rows > 0) {
    // Usuario autenticado
    session_start();
    $_SESSION['email'] = $email;
    // Redirigir al usuario a la página de cotización
    header("Location: inicio.html");
    exit();
} else {
    // Usuario no autenticado
    echo "Credenciales inválidas. Inténtalo de nuevo.";
}

// Cerrar la conexión a la base de datos
$conexion->close();
?>
