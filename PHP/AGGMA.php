<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    require_once "CONN.php";

    if (!$conexion) {
        die("La conexión a la base de datos falló: " . mysqli_connect_error());
    }

    $material = mysqli_real_escape_string($conexion, $_POST['material']);
    $unidad = mysqli_real_escape_string($conexion, $_POST['unidad']);
    $descripcion = mysqli_real_escape_string($conexion, $_POST['descripcion']);

    $insertar = "INSERT INTO agregar_materiales (material, unidad, descripcion) VALUES ('$material', '$unidad', '$descripcion')";

    if (mysqli_query($conexion, $insertar)) {
        echo '<script>alert("Material agregado correctamente.");window.location.href = "../AGR_MATERIAL.html";</script>';
    } else {
        echo "Error al agregar el material: " . mysqli_error($conexion);
    }

    mysqli_close($conexion);
} else {
    echo "No se recibieron datos del formulario.";
}
