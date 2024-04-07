<?php
if(isset($_POST['fecha_pedido'])) {
    $fecha_pedido = $_POST['fecha_pedido'];
    require_once("CONN.php");
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    $sql_estado_actual = "SELECT estado FROM pedidos WHERE fecha_pedido = '$fecha_pedido'";
    $resultado_estado = $conexion->query($sql_estado_actual);

    if ($resultado_estado->num_rows > 0) {
        $fila_estado = $resultado_estado->fetch_assoc();
        $estado_actual = $fila_estado['estado'];

        if ($estado_actual == 11) {
            $nuevo_estado = 12;
        } else {
            $nuevo_estado = 13;
        }

        $sql_actualizar_estado = "UPDATE pedidos SET estado = $nuevo_estado WHERE fecha_pedido = '$fecha_pedido'";
        
        if ($conexion->query($sql_actualizar_estado) === TRUE) {
            echo "Se ha actualizado el estado del pedido para la fecha de pedido $fecha_pedido";
        } else {
            echo "Error al cambiar el estado del pedido: " . $conexion->error;
        }
    } else {
        echo "No se encontró el pedido para la fecha especificada.";
    }

    $conexion->close();
} else {
    echo "Error: No se recibieron los datos necesarios para cambiar el estado del pedido.";
}