<?php
if (isset($_POST['proveedor'])) {
    require_once "CONN.php";

    $proveedorNombre = $_POST['proveedor'];
    $proveedorNombre = $conexion->real_escape_string($proveedorNombre);

    $sql_proveedor = "SELECT id FROM proveedores WHERE proveedor = '$proveedorNombre'";
    $resultado_proveedor = $conexion->query($sql_proveedor);

    if ($resultado_proveedor->num_rows > 0) {
        $fila_proveedor = $resultado_proveedor->fetch_assoc();
        $proveedorId = $fila_proveedor['id'];

        $sql_materiales = "SELECT id, producto FROM cotizaciones WHERE proveedor_id = $proveedorId";
        $resultado_materiales = $conexion->query($sql_materiales);
        
        $opcionesHTML = '';
        if ($resultado_materiales->num_rows > 0) {
            while ($fila_material = $resultado_materiales->fetch_assoc()) {
                $opcionesHTML .= '<option value="' . $fila_material['id'] . '">' . $fila_material['producto'] . '</option>';
            }
        } else {
            $opcionesHTML = '<option value="">No hay materiales disponibles para este proveedor</option>';
        }

        echo $opcionesHTML;
    } else {
        echo '<option value="">No se encontró el proveedor seleccionado</option>';
    }

    $conexion->close();
} else {
    echo '<option value="">Error: No se proporcionó el nombre del proveedor</option>';
}