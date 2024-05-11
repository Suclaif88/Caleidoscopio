<?php
if (isset($_POST['proveedor'])) {
    require_once "CONN.php";
    
    $proveedorId = $_POST['proveedor'];
    $proveedorId = $conexion->real_escape_string($proveedorId);

    $sql_materiales = "SELECT id, nombre, precio FROM materiales WHERE proveedor_id = $proveedorId";
    $resultado_materiales = $conexion->query($sql_materiales);
    
    if ($resultado_materiales->num_rows > 0) {
        $materiales = array();
        while ($fila_material = $resultado_materiales->fetch_assoc()) {
            $materiales[] = array(
                "id" => $fila_material['id'],
                "nombre" => $fila_material['nombre'],
                "precio" => $fila_material['precio']
            );
        }
        echo json_encode(array("success" => true, "materiales" => $materiales));
    } else {
        echo json_encode(array("success" => false, "message" => "No hay materiales disponibles para este proveedor"));
    }

    $conexion->close();
} else {
    echo json_encode(array("success" => false, "message" => "Error: No se proporcionó el ID del proveedor"));
}

