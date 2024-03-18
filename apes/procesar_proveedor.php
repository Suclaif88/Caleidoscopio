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
    $proveedor = mysqli_real_escape_string($conexion, $_POST['proveedor']);
    $nit = mysqli_real_escape_string($conexion, $_POST['nit']);
    $correo = mysqli_real_escape_string($conexion, $_POST['correo']);
    $telefono = mysqli_real_escape_string($conexion, $_POST['telefono']);

    // Insertar los datos en la base de datos
    $insertar = "INSERT INTO proveedores (proveedor, nit, correo, telefono) VALUES ('$proveedor', '$nit', '$correo', '$telefono')";

    if (mysqli_query($conexion, $insertar)) {
        // Mostrar alerta de éxito con JavaScript
        echo '<script>alert("Proveedor agregado correctamente.");window.location.href = "agr_proveedor.html";</script>';
    } else {
        // Mostrar mensaje de error en caso de fallo en la inserción
        echo "Error al agregar el proveedor: " . mysqli_error($conexion);
    }

    // Cerrar la conexión a la base de datos
    mysqli_close($conexion);
} else {
    // Si no se recibieron datos del formulario, redirigir a una página de error o mostrar un mensaje adecuado
    echo "No se recibieron datos del formulario.";
}
?>
