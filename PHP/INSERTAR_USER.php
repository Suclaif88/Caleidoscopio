<?php

require_once("CONN.php");

if (!$conexion) {
    die('Error de conexión: ' . mysqli_connect_error());
}

$identificacion = $_POST['identificacion'];
$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$contrasena = $_POST['contrasena'];
$rol = $_POST['rol'];

$sql = "INSERT INTO usuarios (identificacion, nombre, email, contrasena, rol) 
        VALUES ('$identificacion', '$nombre', '$correo', '$contrasena', '$rol')";

$query = mysqli_query($conexion, $sql);

if($query){
    header("Location: ../ADMIN/ADMIN.php");
} else {
    echo "Error al insertar datos: " . mysqli_error($conexion);
}
