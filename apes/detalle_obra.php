<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de la Obra</title>
</head>
<body>
    <h2>Detalle de la Obra</h2>
    <?php
    $conexion = new mysqli("localhost", "vale", "Salem31ob", "apes");

    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Obtener el ID de la obra desde la URL
    $id_obra = $_GET['id'];

    // Consulta SQL para obtener los detalles de la obra
    $sql = "SELECT * FROM obras WHERE id = $id_obra";
    $resultado = $conexion->query($sql);

    // Mostrar los detalles de la obra
    if ($resultado->num_rows > 0) {
        $obra = $resultado->fetch_assoc();
        echo "<p><strong>Nombre:</strong> ".$obra['nombre']."</p>";
        echo "<p><strong>Descripción:</strong> ".$obra['descripcion']."</p>";
        echo "<p><strong>Fecha de Inicio:</strong> ".$obra['fecha_inicio']."</p>";
        echo "<p><strong>Presupuesto:</strong> ".$obra['presupuesto']."</p>";
        echo "<p><strong>Director de Obra:</strong> ".$obra['director_de_obra']."</p>";
    } else {
        echo "No se encontró la obra.";
    }

    // Cerrar la conexión a la base de datos
    $conexion->close();
    ?>
    <br>
    <a href="obras.php">Volver a la lista de obras</a>
</body>
</html>
