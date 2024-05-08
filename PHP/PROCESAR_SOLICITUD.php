<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['materialesSeleccionados']) && is_array($_POST['materialesSeleccionados']) && !empty($_POST['materialesSeleccionados'])) {
        require_once("CONN.php");

        $obra_id = $_POST['obra_id'];
        $proveedor_id = isset($_POST['proveedor']) ? $_POST['proveedor'] : '';

        foreach ($_POST['materialesSeleccionados'] as $material) {
            $verificar_coincidencia = "SELECT COUNT(*) as coincidencia FROM pedidos WHERE producto = '$material' AND obra_id = '$obra_id'";
            $resultado_coincidencia = $conexion->query($verificar_coincidencia);
            $fila_coincidencia = $resultado_coincidencia->fetch_assoc();
            $coincidencia = $fila_coincidencia['coincidencia'];

            if ($coincidencia > 0) {
                $precio_material = obtenerPrecioMaterial($conexion, $proveedor_id, $material);
                if ($precio_material !== false) {
                    $sql_insert = "UPDATE pedidos SET precio = '$precio_material' WHERE producto = '$material' AND obra_id = '$obra_id' AND estado ='1'";
                    if ($conexion->query($sql_insert) !== TRUE) {
                        echo "Error al enviar la solicitud de materiales: " . $conexion->error;
                        exit;
                    }
                } else {
                    echo "No se pudo obtener el precio para el material '$material' y la obra '$obra_id'.";
                    exit;
                }
            } else {
                echo "El material '$material' no coincide con la obra '$obra_id'.";
                exit;
            }
        }

        $conexion->close();

        echo "<script>alert('¡Solicitud de materiales enviada con éxito!');</script>";
        echo "<script>window.location.href = '../VISTADC/COTIZACION.php';</script>";
    } else {
        echo "Error: No se han seleccionado materiales o la lista de materiales seleccionados está vacía.";
    }
} else {
    echo "Error: Acceso no válido.";
}

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
