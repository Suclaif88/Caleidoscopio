<?php
// Verificar si se recibieron datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conexión a la base de datos
    $conexion = mysqli_connect("localhost", "vale", "Salem31ob", "apes");

    // Verificar la conexión
    if (!$conexion) {
        die("La conexión a la base de datos falló: " . mysqli_connect_error());
    }

    // Recibir y sanitizar los datos del formulario
    $material_id = mysqli_real_escape_string($conexion, $_POST['material']);
    $precio = mysqli_real_escape_string($conexion, $_POST['precio']);
    $proveedor_id = mysqli_real_escape_string($conexion, $_POST['proveedor']);
    $unidad_medida = mysqli_real_escape_string($conexion, $_POST['unidad_medida']);
    $descripcion = mysqli_real_escape_string($conexion, $_POST['descripcion']); // Capturar la descripción

    // Obtener el nombre del material seleccionado
    $consulta_material = "SELECT material FROM agregar_materiales WHERE id = '$material_id'";
    $resultado_material = mysqli_query($conexion, $consulta_material);
    $fila_material = mysqli_fetch_assoc($resultado_material);
    $material = $fila_material['material'];

    // Obtener el nombre del proveedor seleccionado
    $consulta_proveedor = "SELECT proveedor FROM proveedores WHERE id = '$proveedor_id'";
    $resultado_proveedor = mysqli_query($conexion, $consulta_proveedor);
    $fila_proveedor = mysqli_fetch_assoc($resultado_proveedor);
    $proveedor = $fila_proveedor['proveedor'];

    // Insertar los datos en la base de datos
    $insertar = "INSERT INTO cotizaciones (material, descripcion, unidad, precio, proveedor ) 
                 VALUES ('$material', '$descripcion', '$unidad_medida', '$precio', '$proveedor' )";

    if (mysqli_query($conexion, $insertar)) {
        // Mostrar alerta y redireccionar después de una inserción exitosa
        echo '<script>alert("La cotización se ha agregado correctamente."); window.location.href = "agrcot.php";</script>';
        exit;
    } else {
        // Mostrar mensaje de error en caso de fallo en la inserción
        echo "Error de registro: " . mysqli_error($conexion);
    }

    // Cerrar la conexión a la base de datos
    mysqli_close($conexion);
} else {
    // Si no se recibieron datos del formulario, redirigir a una página de error o mostrar un mensaje adecuado
    echo "No se recibieron datos del formulario.";
}
?>
