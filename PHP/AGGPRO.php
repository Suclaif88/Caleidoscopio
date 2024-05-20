<?php
$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "CONN.php";

    if (!$conexion) {
        $response['error'] = "La conexión a la base de datos falló: " . mysqli_connect_error();
    } else {
        $proveedor = mysqli_real_escape_string($conexion, $_POST['proveedor']);
        $nit = mysqli_real_escape_string($conexion, $_POST['nit']);
        $correo = mysqli_real_escape_string($conexion, $_POST['correo']);
        $telefono = mysqli_real_escape_string($conexion, $_POST['telefono']);

        $insertar = "INSERT INTO proveedores (proveedor, nit, correo, telefono) VALUES ('$proveedor', '$nit', '$correo', '$telefono')";

        if (mysqli_query($conexion, $insertar)) {
            $response['success'] = "Proveedor agregado correctamente";
        } else {
            $response['error'] = "Error al agregar el proveedor: " . mysqli_error($conexion);
        }

        mysqli_close($conexion);
    }
} else {
    $response['error'] = "No se recibieron datos del formulario.";
}

echo json_encode($response);

