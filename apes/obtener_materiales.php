<?php
// Conexión a la base de datos
$conexion = mysqli_connect("localhost", "vale", "Salem31ob", "apes");

if (!$conexion) {
    die("La conexión a la base de datos falló: " . mysqli_connect_error());
}

// Consulta para obtener los materiales y sus precios
$consulta = "SELECT id, material, precio FROM agregar_materiales";
$resultado = mysqli_query($conexion, $consulta);

// Verificar si la consulta tuvo éxito
if ($resultado) {
    // Mostrar los materiales en el formulario
    while ($fila = mysqli_fetch_assoc($resultado)) {
        echo "<option value='" . $fila['id'] . "'>" . $fila['material'] . " (Precio anterior: $" . $fila['precio'] . ")</option>";
    }
} else {
    echo "Error al obtener los materiales: " . mysqli_error($conexion);
}

// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>
