<?php
if(isset($_POST['fecha_pedido'])) {
    $fecha_pedido = $_POST['fecha_pedido'];
    require_once("CONN.php");
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    $sql = "UPDATE pedidos SET estado = 11 WHERE fecha_pedido = '$fecha_pedido'";

    if ($conexion->query($sql) === TRUE) {
        echo "Se ha actualizado el estado del pedido para la fecha de pedido $fecha_pedido";
    } else {
        echo "Error al cambiar el estado del pedido: " . $conexion->error;
    }

    $conexion->close();
} else {
    echo "Error: No se recibieron los datos necesarios para cambiar el estado del pedido.";
}