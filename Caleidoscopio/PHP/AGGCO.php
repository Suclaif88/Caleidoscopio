<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    require_once "CONN.php";

    if (!$conexion) {
        die("La conexión a la base de datos falló: " . mysqli_connect_error());
    }

    $material_id = mysqli_real_escape_string($conexion, $_POST['material']);
    $precio = mysqli_real_escape_string($conexion, $_POST['precio']);
    $proveedor_id = mysqli_real_escape_string($conexion, $_POST['proveedor']);
    $unidad_medida = mysqli_real_escape_string($conexion, $_POST['unidad_medida']);
    $descripcion = mysqli_real_escape_string($conexion, $_POST['descripcion']); // Capturar la descripción

    $consulta_material = "SELECT material FROM agregar_materiales WHERE id = '$material_id'";
    $resultado_material = mysqli_query($conexion, $consulta_material);
    $fila_material = mysqli_fetch_assoc($resultado_material);
    $material = $fila_material['material'];

    $consulta_proveedor = "SELECT proveedor FROM proveedores WHERE id = '$proveedor_id'";
    $resultado_proveedor = mysqli_query($conexion, $consulta_proveedor);
    $fila_proveedor = mysqli_fetch_assoc($resultado_proveedor);
    $proveedor = $fila_proveedor['proveedor'];

    $insertar = "INSERT INTO cotizaciones (material, descripcion, unidad, precio, proveedor ) 
                 VALUES ('$material', '$descripcion', '$unidad_medida', '$precio', '$proveedor' )";

    if (mysqli_query($conexion, $insertar)) {

        echo '<script>alert("La cotización se ha agregado correctamente."); window.location.href = "agrcot.php";</script>';
        exit;
    } else {

        echo "Error de registro: " . mysqli_error($conexion);
    }


    mysqli_close($conexion);
} else {

    echo "No se recibieron datos del formulario.";
}