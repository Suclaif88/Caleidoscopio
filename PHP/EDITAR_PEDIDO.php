<?php
require_once("CONN.php");

if (!isset($_POST['id'])) {
    die("ID del pedido no proporcionado");
}

$id = $_POST["id"];
$obra_id = $_POST['obra_id'];
$usuario = $_POST['usuario'];
$producto = $_POST['producto'];
$precio = $_POST['precio'];
$cantidad = $_POST['cantidad'];
$unidad = $_POST['unidad'];
$fecha_pedido = $_POST['fecha_pedido'];
$estado = $_POST['estado'];
$historial = $_POST['historial'];


$sql = "UPDATE pedidos SET obra_id='$obra_id', usuario='$usuario', producto='$producto', precio='$precio', cantidad='$cantidad', unidad='$unidad', fecha_pedido='$fecha_pedido', estado='$estado', historial='$historial' WHERE id='$id'";


$query = mysqli_query($conexion, $sql);


if ($query) {
 
    header("Location: ../ADMIN/PEDIDOSAD.php");
    exit();
} else {
    echo "Error al actualizar el pedido: " . mysqli_error($conexion);
}