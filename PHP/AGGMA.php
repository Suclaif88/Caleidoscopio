<?php
require_once("../PHP/CONN.php");

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['cotizacion']) && isset($_POST['selectObra']) && isset($_POST['cantidad']) && isset($_POST['unidad'])) {
        $cotizacion_id = $_POST['cotizacion'];
        $obra_id = $_POST['selectObra'];
        $cantidad = $_POST['cantidad'];
        $unidad_personalizada = $_POST['unidad'];

        $sql_cotizacion = "SELECT `producto`, `unidad`, `precio` FROM `cotizaciones` WHERE `id` = $cotizacion_id";
        $result_cotizacion = $conexion->query($sql_cotizacion);

        if ($result_cotizacion && $result_cotizacion->num_rows > 0) {
            $row_cotizacion = $result_cotizacion->fetch_assoc();
            $producto = $row_cotizacion['producto'];
            $unidad_default = $row_cotizacion['unidad'];
            $precio = $row_cotizacion['precio'];

            $unidad = !empty($unidad_personalizada) ? $unidad_personalizada : $unidad_default;

            $sql_insert = "INSERT INTO `pedidos` (`obra_id`, `producto`, `cantidad`, `unidad`, `precio`) VALUES ('$obra_id', '$producto', '$cantidad', '$unidad', '$precio')";

            if ($conexion->query($sql_insert) === TRUE) {
                $mensaje = "La cotización se agregó correctamente a la obra seleccionada.";
            } else {
                $mensaje = "Error al agregar la cotización: " . $conexion->error;
            }
        } else {
            $mensaje = "No se encontraron datos de la cotización seleccionada.";
        }
    } else {
        $mensaje = "No se recibieron todos los datos necesarios del formulario.";
    }
}

echo "<script>alert('" . $mensaje . "'); window.location.href = '../VISTADC/COTIZACION.php';</script>";