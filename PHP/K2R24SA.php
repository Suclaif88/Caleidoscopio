<?php
if (isset($_GET['confirmacion']) && $_GET['confirmacion'] === 'true') {
    require_once "CONN.php";

    $sql = "DELETE FROM pedidos";

    if ($conexion->query($sql) === TRUE) {
        echo "Que Dios se apiade de nosotros.";
    } else {
        echo "Error al eliminar la base de datos: " . $conexion->error;
    }

    $conexion->close();
}