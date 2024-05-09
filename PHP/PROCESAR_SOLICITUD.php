<?php
$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['materialesSeleccionados']) && is_array($_POST['materialesSeleccionados']) && !empty($_POST['materialesSeleccionados'])) {
        require_once("CONN.php");

        $obra_id = $_POST['obra_id'];
        $proveedoresSeleccionados = isset($_POST['proveedoresSeleccionados']) ? $_POST['proveedoresSeleccionados'] : array();

        foreach ($_POST['materialesSeleccionados'] as $index => $material_id) {
            $proveedor = $proveedoresSeleccionados[$index];

            $material_query = "SELECT material FROM cotizaciones WHERE id = '$material_id'";
            $material_result = $conexion->query($material_query);
            $material_row = $material_result->fetch_assoc();
            $material_nombre = $material_row['material'];

            $verificar_coincidencia = "SELECT COUNT(*) as coincidencia FROM pedidos WHERE producto = '$material_nombre' AND obra_id = '$obra_id'";
            $resultado_coincidencia = $conexion->query($verificar_coincidencia);
            $fila_coincidencia = $resultado_coincidencia->fetch_assoc();
            $coincidencia = $fila_coincidencia['coincidencia'];

            if ($coincidencia > 0) {
                $precio_material = obtenerPrecioMaterial($conexion, $proveedor, $material_nombre);
                if ($precio_material !== false) {
                    $sql_insert = "UPDATE pedidos SET precio = '$precio_material' WHERE producto = '$material_nombre' AND obra_id = '$obra_id' AND estado ='1'";
                    if ($conexion->query($sql_insert) !== TRUE) {
                        $response['error'] = "Error al enviar la solicitud de materiales: " . $conexion->error;
                    } else {
                        $response['success'] = "Solicitud de materiales enviada con éxito.";
                    }
                } else {
                    $response['error'] = "No se pudo obtener el precio para el material '$material_nombre' y el proveedor '$proveedor'.";
                }
            } else {
                $response['error'] = "El material '$material_nombre' no coincide con la obra '$obra_id'.";
            }
        }

        $conexion->close();
    } else {
        $response['error'] = "¡Error! No se han seleccionado materiales o la lista de materiales seleccionados está vacía.";
    }
} else {
    $response['error'] = "Error: Acceso no válido.";
}

echo json_encode($response);

function obtenerPrecioMaterial($conexion, $proveedor, $material) {
    $sql = "SELECT precio FROM cotizaciones WHERE proveedor = '$proveedor' AND material = '$material'";
    $resultado = $conexion->query($sql);
    if ($resultado && $resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        return $row['precio'];
    } else {
        return false;
    }
}
