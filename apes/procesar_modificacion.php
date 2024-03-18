<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conexion = mysqli_connect("localhost", "vale", "Salem31ob", "apes");
    if (!$conexion) {
        die("La conexión a la base de datos falló: " . mysqli_connect_error());
    }

    $material_id = $_POST['material'];
    $proveedor_id = $_POST['proveedor'];
    $nuevo_precio = $_POST['nuevo_precio'];

    $actualizar_precio = "UPDATE cotizaciones SET precio = '$nuevo_precio' WHERE material_id = '$material_id' AND proveedor_id = '$proveedor_id'";

    if (mysqli_query($conexion, $actualizar_precio)) {
        echo "Precio actualizado correctamente.";
    } else {
        echo "Error al actualizar el precio: " . mysqli_error($conexion);
    }

    mysqli_close($conexion);
} else {
    echo "No se recibieron datos del formulario.";
}
?>
