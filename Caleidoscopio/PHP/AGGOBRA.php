<?php
    require_once "CONN.php";

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$fecha_inicio = $_POST['fecha_inicio'];
$presupuesto = $_POST['presupuesto'];
$director_de_obra= $_POST['director_de_obra'];


$sql = "INSERT INTO obras (nombre, descripcion, fecha_inicio, presupuesto, director_de_obra) VALUES ('$nombre', '$descripcion', '$fecha_inicio', '$presupuesto', '$director_de_obra')";


if ($conexion->query($sql) === TRUE) {
    echo "<script>alert('La obra se ha agregado correctamente');</script>";
    echo "<meta http-equiv='refresh' content='1;url=../agr_obra.html'>";
} else {
    echo "Error al agregar la obra: " . $conexion->error;
}

$conexion->close();
?>
