<?php
$conexion = new mysqli("localhost", "vale", "Salem31ob", "apes");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$fecha_inicio = $_POST['fecha_inicio'];
$presupuesto = $_POST['presupuesto'];
$director_de_obra= $_POST['director_de_obra'];

// consulta
$sql = "INSERT INTO obras (nombre, descripcion, fecha_inicio, presupuesto, director_de_obra) VALUES ('$nombre', '$descripcion', '$fecha_inicio', '$presupuesto', '$director_de_obra')";

// Ejecutar consulta, alerta y redirección
if ($conexion->query($sql) === TRUE) {
    echo "<script>alert('La obra se ha agregado correctamente');</script>";
    echo "<meta http-equiv='refresh' content='1;url=nueva_obra.html'>";
} else {
    echo "Error al agregar la obra: " . $conexion->error;
}

$conexion->close();
?>
