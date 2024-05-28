<?php

include '../CONFIG/CONFIG.php';

$conexion = mysqli_connect($servidor, $usuario, $clave, $db);

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8mb4");