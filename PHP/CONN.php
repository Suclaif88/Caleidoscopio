<?php

include '../CONFIG/CONFIG.php';

$conexion = mysqli_connect($servidor, $usuario, $clave, $db);

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Establecer la codificación de caracteres a UTF-8
mysqli_set_charset($conexion, "utf8");
