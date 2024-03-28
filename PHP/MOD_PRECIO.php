<?php
require_once "CONN.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $material_id = $_POST['material_id'];
    $proveedor_id = $_POST['proveedor_id'];
    $nuevo_precio = $_POST['nuevo_precio'];

    if (empty($material_id) || empty($proveedor_id) || empty($nuevo_precio)) {
        echo "Por favor, seleccione un material, un proveedor y proporcione un nuevo precio.";
        exit;
    }

    $sql = "UPDATE cotizaciones SET precio = ? WHERE material_id = ? AND proveedor_id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param('dii', $nuevo_precio, $material_id, $proveedor_id);

    if ($stmt->execute()) {
        echo "El precio del material se ha actualizado correctamente.";
    } else {
        echo "Error al actualizar el precio del material: " . $conexion->error;
    }

    $stmt->close();
    $conexion->close();
} else {
    echo "Acceso denegado.";
}
?>
