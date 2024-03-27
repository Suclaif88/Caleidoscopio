<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['accion']) && $_POST['accion'] === 'aceptar' && isset($_POST['obra_id'])) {

        $obra_id = $_POST['obra_id'];

        require_once("CONN.php");

        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }
        $sql = "UPDATE pedidos SET estado = 4 WHERE obra_id = $obra_id";

        if ($conexion->query($sql) === TRUE) {
            echo "Se ha aceptado el pedido para el ID de obra $obra_id.";
        } else {
            echo "Error al asignar el valor estado" . $conexion->error;
        }
        $conexion->close();
    } else {
        echo "Parámetros de solicitud no válidos.";
    }
} else {
    echo "Acceso no autorizado.";
}