<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['material']) && isset($_POST['proveedor']) && isset($_POST['nuevo_precio'])) {
        $material = $_POST['material'];
        $proveedor = $_POST['proveedor'];
        $nuevo_precio = $_POST['nuevo_precio'];
        
        require_once("CONN.php");

        if ($conexion->connect_error) {
            echo json_encode(array('success' => false, 'message' => 'Error de conexión: ' . $conexion->connect_error));
            exit();
        }

        $stmt = $conexion->prepare("UPDATE cotizaciones SET precio = ? WHERE proveedor = ? AND material = ?");
        if ($stmt === false) {
            echo json_encode(array('success' => false, 'message' => 'Error al preparar la consulta: ' . $conexion->error));
            exit();
        }

        $stmt->bind_param("dss", $nuevo_precio, $proveedor, $material);

        if ($stmt->execute()) {
            echo '<script>alert("Se edito el precio correctamente."); window.location.href = "../VISTADC/MOD_PRECIO.php";</script>';
        } else {
            echo "Error al actualizar el precio: " . $stmt->error . "";
        }

        $stmt->close();
        $conexion->close();
    } else {
        echo json_encode(array('success' => false, 'message' => 'Error: No se recibieron los datos necesarios para actualizar el precio.'));
    }
}
?>
