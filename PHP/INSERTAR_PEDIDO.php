<?php
require_once("CONN.php");

$obra_id = $_POST['obra_id'];
$usuario = $_POST['usuario'];
$precios = $_POST['precio'];
$cantidades = $_POST['cantidad'];
$unidades = $_POST['unidad'];
$fecha_pedido = $_POST['fecha_pedido'];
$estado = $_POST['estado'];
$historial = $_POST['historial'];

$materiales_seleccionados = $_POST['materiales'];
$inserts_exitosos = array();

foreach ($materiales_seleccionados as $material_id) {
    $obra_id = $conexion->real_escape_string($obra_id);
    $usuario = $conexion->real_escape_string($usuario);
    $precio = $conexion->real_escape_string($precios);
    $cantidad = $conexion->real_escape_string($cantidades);
    $unidad = $conexion->real_escape_string($unidades);
    $fecha_pedido = $conexion->real_escape_string($fecha_pedido);
    $estado = $conexion->real_escape_string($estado);
    $historial = $conexion->real_escape_string($historial);
    $material_id = $conexion->real_escape_string($material_id);

    $sql_nombre_material = "SELECT material FROM agregar_materiales WHERE id = '$material_id'";
    $resultado_nombre_material = $conexion->query($sql_nombre_material);

    if ($resultado_nombre_material->num_rows > 0) {
        $fila_nombre_material = $resultado_nombre_material->fetch_assoc();
        $nombre_material = $fila_nombre_material['material'];

        $sql = "INSERT INTO pedidos (obra_id, usuario, producto, precio, cantidad, unidad, fecha_pedido, estado, historial) 
                VALUES ('$obra_id', '$usuario', '$nombre_material', '$precio', '$cantidad', '$unidad', '$fecha_pedido', '$estado', '$historial')";

        $query = mysqli_query($conexion, $sql);
        
        if ($query) {
            $inserts_exitosos[] = $nombre_material;
        } else {
            echo "Error al agregar el pedido: " . mysqli_error($conexion);
        }
    } else {
        echo "Error: Material no encontrado.";
    }
}

if (!empty($inserts_exitosos)) {
    header("Location: ../ADMIN/PEDIDOSAD.php");
    exit();
} else {
    echo "Error al agregar el pedido.";
}