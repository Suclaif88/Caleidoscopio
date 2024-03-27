<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['accion']) && $_POST['accion'] == 'rechazar' && isset($_POST['obra_id'])) {
    $obra_id = $_POST['obra_id'];

    require_once("CONN.php");

    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    $sql = "UPDATE pedidos SET estado = 5 WHERE obra_id = $obra_id";

    if ($conexion->query($sql) === TRUE) {
        echo "Se ha rechazado el pedido para el ID de obra $obra_id.";
    } else {
        echo "Error al rechazar la solicitud: " . $conexion->error;
    }

    $conexion->close();
} else {
    echo "No se proporcionaron todos los parámetros necesarios.";
}