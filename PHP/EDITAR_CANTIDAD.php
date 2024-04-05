<?php
header('Content-Type: application/json');
if(isset($_POST['pedido_id']) && isset($_POST['nueva_cantidad'])) {
    $pedido_id = $_POST['pedido_id'];
    $nueva_cantidad = $_POST['nueva_cantidad'];
    require_once("CONN.php");

    if ($conexion->connect_error) {
        echo json_encode(array('success' => false, 'message' => 'Error de conexión: ' . $conexion->connect_error));
        exit();
    }
    $sql = "UPDATE pedidos SET historial = 3, cantidad = '$nueva_cantidad'  WHERE id = '$pedido_id'";

    if ($conexion->query($sql) === TRUE) {
        echo json_encode(array('success' => true, 'message' => 'La cantidad ha sido actualizada correctamente.'));
    } else {
        echo json_encode(array('success' => false, 'message' => 'Error al actualizar la cantidad: ' . $conexion->error));
    }

    $conexion->close();
} else {
    echo json_encode(array('success' => false, 'message' => 'Error: No se recibieron los datos necesarios para actualizar la cantidad.'));
}