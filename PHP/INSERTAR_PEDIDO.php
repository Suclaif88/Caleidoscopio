<?php
require_once("CONN.php");

$obra_id = $_POST['obra_id'];
$usuario = $_POST['usuario'];
$producto = $_POST['material'];
$precio = $_POST['precio'];
$cantidad = $_POST['cantidad'];
$unidad = $_POST['unidad'];
$fecha_pedido = $_POST['fecha_pedido'];
$estado = $_POST['estado'];
$historial = $_POST['historial'];

$sql = "INSERT INTO pedidos (obra_id, usuario, producto, precio, cantidad, unidad, fecha_pedido, estado, historial) 
        VALUES ('$obra_id', '$usuario', '$producto', '$precio', '$cantidad', '$unidad', '$fecha_pedido', '$estado', '$historial')";

$query = mysqli_query($conexion, $sql);

if ($query) {
    header("Location: ../ADMIN/PEDIDOSAD.php");
    exit();
} else {
    echo "Error al agregar el pedido: " . mysqli_error($conexion);
}
