<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['accion']) && $_POST['accion'] === 'aceptar' && isset($_POST['fecha_pedido'])) {

        $fecha_pedido = $_POST['fecha_pedido'];

        require_once("CONN.php");

        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }
        $sql = "UPDATE pedidos SET estado = 8 WHERE fecha_pedido = '$fecha_pedido'";

        if ($conexion->query($sql) === TRUE) {
            echo "Se ha actualizado el estado del pedido para la fecha de pedido $fecha_pedido";
        } else {
            echo "Error al asignar el valor estado: " . $conexion->error;
        }
        $conexion->close();
    } else {
        echo "Parámetros de solicitud no válidos.";
    }
} else {
    echo "Acceso no autorizado.";
}