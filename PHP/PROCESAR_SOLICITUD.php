<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['materialesSeleccionados']) && is_array($_POST['materialesSeleccionados']) && !empty($_POST['materialesSeleccionados'])) {
        require_once("CONN.php");

        $obra_id = $_POST['obra_id'];
        $proveedor_id = isset($_POST['proveedor']) ? $_POST['proveedor'] : '';
        $proveedor_nombre = obtenerNombreProveedor($conexion, $proveedor_id);

        if ($proveedor_nombre !== false){

        foreach ($_POST['materialesSeleccionados'] as $material) {
            $verificar_coincidencia = $conexion->prepare("SELECT COUNT(*) as coincidencia FROM pedidos WHERE producto = ? AND obra_id = ?");
            $verificar_coincidencia->bind_param("si", $material, $obra_id);
            $verificar_coincidencia->execute();
            $resultado_coincidencia = $verificar_coincidencia->get_result();
            $fila_coincidencia = $resultado_coincidencia->fetch_assoc();
            $coincidencia = $fila_coincidencia['coincidencia'];

            if ($coincidencia > 0) {
                $precio_material = obtenerDatoMaterial($conexion, $proveedor_id, $material, 'precio');
                $descuento_material = obtenerDatoMaterial($conexion, $proveedor_id, $material, 'descuento');
                $impuesto_material = obtenerDatoMaterial($conexion, $proveedor_id, $material, 'impuesto');

                if ($precio_material !== false && $descuento_material !== false && $impuesto_material !== false) {
                    $sql_update = "UPDATE pedidos SET precio = ?, descuento = ?, impuesto = ? WHERE producto = ? AND obra_id = ? AND estado ='1'";
                    $actualizar_pedido = $conexion->prepare($sql_update);
                    $actualizar_pedido->bind_param("dddsi", $precio_material, $descuento_material, $impuesto_material, $material, $obra_id);
                    if ($actualizar_pedido->execute() !== TRUE) {
                        echo "Error al enviar la solicitud de materiales.";
                        exit;
                    }
                } else {
                    echo "No se pudieron obtener los datos necesarios para el material '$material' y el proveedor '$proveedor_id'.";
                    exit;
                }
            } else {
                echo "El material '$material' no coincide con la obra '$obra_id'.";
                exit;
            }
        }}else {
            echo "No se pudo obtener el nombre del proveedor.";
            exit;
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
function obtenerNombreProveedor($conexion, $proveedor_id) {
    $sql = "SELECT proveedor FROM proveedores WHERE id = 'proveedor_id'";
    $consulta = $conexion->prepare($sql);
    $consulta->bind_param("s", $proveedor_id);
    $consulta->execute();
    $resultado = $consulta->get_result();

    if ($resultado && $resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        return $row['proveedor'];
    } else {
        return false;
    }
}
function obtenerPrecioMaterial($conexion, $proveedor, $material, $precio) {
    $sql = "SELECT $dato FROM cotizaciones WHERE proveedor = '$proveedor' AND material = '$material'";
    $consulta = $conexion->prepare($sql);
    $consulta->bind_param("ss", $proveedor, $material);
    $consulta->execute();
    $resultado = $consulta->get_result();

    if ($resultado && $resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        return $row[$precio];
    } else {
        return false;
    }
}
function obtenerDescuentoMaterial($conexion, $proveedor, $material, $descuento) {
    $sql = "SELECT $dato FROM cotizaciones WHERE proveedor = '$proveedor' AND material = '$material'";
    $consulta = $conexion->prepare($sql);
    $consulta->bind_param("ss", $proveedor, $material);
    $consulta->execute();
    $resultado = $consulta->get_result();

    if ($resultado && $resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        return $row[$descuento];
    } else {
        return false;
    }
}
function obtenerImpuestoMaterial($conexion, $proveedor, $material, $impuesto) {
    $sql = "SELECT $dato FROM cotizaciones WHERE proveedor = '$proveedor' AND material = '$material'";
    $consulta = $conexion->prepare($sql);
    $consulta->bind_param("ss", $proveedor, $material);
    $consulta->execute();
    $resultado = $consulta->get_result();

    if ($resultado && $resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        return $row[$impuesto];
    } else {
        return false;
    }
}

?>
