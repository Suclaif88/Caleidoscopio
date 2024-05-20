<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['materialesSeleccionados']) && is_array($_POST['materialesSeleccionados']) && !empty($_POST['materialesSeleccionados'])) {

        require_once("CONN.php");

        $obra_id = isset($_POST['obra_id']) ? intval($_POST['obra_id']) : 0;
        $materialesSeleccionados = array_map('intval', $_POST['materialesSeleccionados']);
        
        $update_query = "UPDATE pedidos SET precio = ?, descuento = ?, impuesto = ?, proveedor = ? WHERE producto = ? AND obra_id = ?";
        $stmt_update = $conexion->prepare($update_query);
        
        foreach ($materialesSeleccionados as $material_id) {
            $material = obtenerNombreMaterial($conexion, $material_id);
            if ($material !== false) {
                $cotizacion = obtenerCotizacion($conexion, $material_id);
                if ($cotizacion !== false) {
                    $proveedor = obtenerProveedorMaterial($conexion, $material_id);
                    if ($proveedor !== false) {
                        $stmt_update->bind_param("dddssi", $cotizacion['precio'], $cotizacion['descuento'], $cotizacion['impuesto'], $proveedor, $material, $obra_id);
                        if (!$stmt_update->execute()) {
                            $response = array("error" => "Error al actualizar la solicitud de materiales.");
                            echo json_encode($response);
                            exit;
                        }
                    } else {
                        $response = array("error" => "No se encontró el proveedor para el material '$material_id'.");
                        echo json_encode($response);
                        exit;
                    }
                } else {
                    $response = array("error" => "No se encontró cotización para el material '$material_id'.");
                    echo json_encode($response);
                    exit;
                }
            } else {
                $response = array("error" => "No se encontró el material con ID '$material_id'.");
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

function obtenerNombreMaterial($conexion, $material_id) {
    $sql = "SELECT material FROM cotizaciones WHERE id = ?";
    $consulta = $conexion->prepare($sql);
    $consulta->bind_param("i", $material_id);
    if ($consulta->execute()) {
        $resultado = $consulta->get_result();
        if ($row = $resultado->fetch_assoc()) {
            return $row['material'];
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function obtenerCotizacion($conexion, $material_id) {
    $sql = "SELECT precio, descuento, impuesto FROM cotizaciones WHERE id = ?";
    $consulta = $conexion->prepare($sql);
    $consulta->bind_param("i", $material_id);
    if ($consulta->execute()) {
        $resultado = $consulta->get_result();
        if ($row = $resultado->fetch_assoc()) {
            return $row;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function obtenerProveedorMaterial($conexion, $material_id) {
    $sql = "SELECT proveedor FROM cotizaciones WHERE id = ?";
    $consulta = $conexion->prepare($sql);
    $consulta->bind_param("i", $material_id);
    if ($consulta->execute()) {
        $resultado = $consulta->get_result();
        if ($row = $resultado->fetch_assoc()) {
            return $row['proveedor'];
        } else {
            return false;
        }
    } else {
        return false;
    }
}
?>
