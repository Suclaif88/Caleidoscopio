<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "CONN.php";

    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    $usuario = $conexion->real_escape_string($_POST['usuario']);
    $obra_id = intval($_POST['obra_id']);
    $material_ids = $_POST['material_id'];
    $cantidades = $_POST['cantidad'];
    $unidades = $_POST['unidad'];
    $material_nombres = $_POST['material_nombre'];

    for ($i = 0; $i < count($material_ids); $i++) {
        // Recuperar datos específicos del material
        $material_id = intval($material_ids[$i]);
        $cantidad = intval($cantidades[$i]);
        $unidad = $conexion->real_escape_string($unidades[$i]);
        $material_nombre = $conexion->real_escape_string($material_nombres[$i]);

                $sql_insert = "INSERT INTO pedidos (usuario, obra_id, producto, cantidad, unidad, estado)
                               VALUES ('$usuario', $obra_id, '$material_nombre', $cantidad, '$unidad', 1)";

                if ($conexion->query($sql_insert) !== TRUE) {
                    echo "Error al enviar la solicitud de materiales: " . $conexion->error;
                    exit;
                }
    }
    
    echo "<script>alert('¡Solicitud de materiales enviada con éxito!');</script>";
    echo "<script>window.location.href = '../VISTADC/COTIZACION.php';</script>";

    $conexion->close();
}