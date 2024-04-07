<?php
require_once("CONN.php");

if (!isset($_POST['id'])) {
    die("ID no proporcionado");
}

$id = $_POST["id"];

$sql = "DELETE FROM pedidos WHERE id='$id'";

$query = mysqli_query($conexion, $sql);

if ($query) {
    header("Location: ../ADMIN/PEDIDOSAD.php");
    exit();
} else {

    echo "Error al eliminar el pedido: " . mysqli_error($conexion);
}