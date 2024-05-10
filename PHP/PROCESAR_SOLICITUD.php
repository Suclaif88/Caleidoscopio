<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['materialesSeleccionados']) && is_array($_POST['materialesSeleccionados']) && !empty($_POST['materialesSeleccionados'])) {
        require_once("CONN.php");

        $obra_id = $_POST['obra_id'];
        $proveedor = isset($_POST['proveedor']) ? $_POST['proveedor'] : '';

            foreach ($_POST['materialesSeleccionados'] as $material) {
                $verificar_coincidencia = $conexion->prepare("SELECT COUNT(*) as coincidencia FROM pedidos WHERE producto = ? AND obra_id = ?");
                $verificar_coincidencia->bind_param("si", $material, $obra_id);
                $verificar_coincidencia->execute();
                $resultado_coincidencia = $verificar_coincidencia->get_result();
                $fila_coincidencia = $resultado_coincidencia->fetch_assoc();
                $coincidencia = $fila_coincidencia['coincidencia'];

                if ($coincidencia > 0) {
                    $precio_material = obtenerPrecioMaterial($conexion, $proveedor, $material, 'precio');
                    $descuento_material = obtenerDescuentoMaterial($conexion, $proveedor, $material, 'descuento');
                    $impuesto_material = obtenerImpuestoMaterial($conexion, $proveedor, $material, 'impuesto');

                    if ($precio_material !== false && $descuento_material !== false && $impuesto_material !== false) {
                        $sql_update = "UPDATE pedidos SET precio = '$precio_material', descuento = '$descuento_material', impuesto = '$impuesto_material' WHERE producto = '$material' AND obra_id = '$obra_id' AND estado ='1'";
                        $actualizar_pedido = $conexion->prepare($sql_update);
                        $actualizar_pedido->bind_param("dddsi", $precio_material, $descuento_material, $impuesto_material, $material, $obra_id);
                        if ($actualizar_pedido->execute() !== TRUE) {
                            $response = array("error" => "Error al enviar la solicitud de materiales.");
                            echo json_encode($response);
                            exit;
                        }
                    } else {
                        $response = array("error" => "No se pudieron obtener los datos necesarios para el material '$material' y el proveedor '$proveedor'.");
                        echo json_encode($response);
                        exit;
                    }
                } else {
                    $response = array("error" => "El material '$material' no coincide con la obra '$obra_id'.");
                    echo json_encode($response);
                    exit;
                }
            }
            $conexion->close();
            $response = array("success" => "¡Solicitud de materiales enviada con éxito!");
            echo json_encode($response);
    } else {
        $response = array("error" => "Error: No se han seleccionado materiales o la lista de materiales seleccionados está vacía.");
        echo json_encode($response);
    }
} else {
    $response = array("error" => "Error: Acceso no válido.");
    echo json_encode($response);
}

function obtenerPrecioMaterial($conexion, $proveedor, $material, $precio) {
    $sql = "SELECT precio FROM cotizaciones WHERE proveedor = '$proveedor' AND material = '$material'";
    $consulta = $conexion->prepare($sql);
    $consulta->bind_param("ss", $proveedor, $material);
    $consulta->execute();
    $resultado = $consulta->get_result();

    if ($resultado && $resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        return $row['precio'];
    } else {
        return false;
    }
}
function obtenerDescuentoMaterial($conexion, $proveedor, $material, $descuento) {
    $sql = "SELECT descuento FROM cotizaciones WHERE proveedor = '$proveedor' AND material = '$material'";
    $consulta = $conexion->prepare($sql);
    $consulta->bind_param("ss", $proveedor, $material);
    $consulta->execute();
    $resultado = $consulta->get_result();

    if ($resultado && $resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        return $row['descuento'];
    } else {
        return false;
    }
}
function obtenerImpuestoMaterial($conexion, $proveedor, $material, $impuesto) {
    $sql = "SELECT impuesto FROM cotizaciones WHERE proveedor = '$proveedor' AND material = '$material'";
    $consulta = $conexion->prepare($sql);
    $consulta->bind_param("ss", $proveedor, $material);
    $consulta->execute();
    $resultado = $consulta->get_result();

    if ($resultado && $resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        return $row['impuesto'];
    } else {
        return false;
    }
}

