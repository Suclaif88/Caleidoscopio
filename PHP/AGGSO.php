<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    require_once "CONN.php";


    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    $usuario = $_POST['usuario'];
    $productos = $_POST['productos'];
    $cantidades = $_POST['cantidades'];
    $unidades = $_POST['unidades'];
    $obra_id = $_POST['obra'];

    for ($i = 0; $i < count($productos); $i++) {
        $producto = $conexion->real_escape_string($productos[$i]);
        $cantidad = intval($cantidades[$i]);
        $unidad = $conexion->real_escape_string($unidades[$i]);

        $sql = "INSERT INTO pedidos (usuario, producto, cantidad, unidad, obra_id) VALUES ('$usuario', '$producto', $cantidad, '$unidad', $obra_id)";

        if ($conexion->query($sql) !== TRUE) {
            echo "Error al enviar la solicitud de materiales: " . $conexion->error;
            exit;
        }
    }

    echo "<script>alert('¡Solicitud de materiales enviada con éxito!');</script>";
    echo "<script>window.location.href = '../VISTARE/SOLICITUD.php';</script>";


    $conexion->close();
}