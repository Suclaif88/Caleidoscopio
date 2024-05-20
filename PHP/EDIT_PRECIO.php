<?php
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST['material']) && isset($_POST['proveedor'])&& isset($_POST['nuevo_precio'])) {
        $mterial = $_POST['material'];
        $proveedor = $_POST['provedor'];
        $nuevo_precio = $_POST['nuevo_precio'];
        require_once("CONN.php");
    
        if ($conexion->connect_error) {
            echo json_encode(array('success' => false, 'message' => 'Error de conexión: ' . $conexion->connect_error));
            exit();
        }
        $sql = "UPDATE cotizaciones SET precio = '$nuevo_precio'  WHERE provedor = '$proveedor' AND material = '$material''";
    
        if ($conexion->query($sql) === TRUE) {
            echo json_encode(array('success' => true, 'message' => 'el precio ha sido actualizada correctamente.'));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Error al actualizar el precio: ' . $conexion->error));
        }
    
        $conexion->close();
    } else {
        echo json_encode(array('success' => false, 'message' => 'Error: No se recibieron los datos necesarios para actualizar el precio.'));
    }  
}