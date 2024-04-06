<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    require_once "CONN.php";

    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    $usuario = $_POST['usuario'];
    $obra_id = $_POST['obra_id'];
    $material_ids = $_POST['material_id'];
    $cantidades = $_POST['cantidad'];
    $unidades = $_POST['unidad'];
    $material_nombres = $_POST['material_nombre'];

    for ($i = 0; $i < count($material_ids); $i++) {
        $usuario = $usuario;
        $obra_id = $obra_id;
        $material_id = $material_ids[$i];
        $cantidad = $cantidades[$i];
        $unidad = $unidades[$i];
        $material_nombre = $material_nombres[$i];

        $usuario = $conexion->real_escape_string($usuario);
        $obra_id= intval($obra_id);
        $cantidad = intval($cantidad);
        $unidad = $conexion->real_escape_string($unidad);
        $material_nombre = $conexion->real_escape_string($material_nombre);


        $sql = "INSERT INTO pedidos (usuario, obra_id, producto, cantidad, unidad) VALUES ('$usuario', '$obra_id', '$material_nombre', '$cantidad', '$unidad')";
        
        if ($conexion->query($sql) !== TRUE) {
            echo "Error al enviar la solicitud de materiales: " . $conexion->error;
            exit;
        }
    }

    echo "<script>alert('¡Solicitud de materiales enviada con éxito!');</script>";
    echo "<script>window.location.href = '../VISTARE/SOLICITUD.php';</script>";

    $conexion->close();
}