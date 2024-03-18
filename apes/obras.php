<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Obras</title>
</head>
<body>
    <h2>Obras</h2>
    <table border="1">
        <tr>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Fecha de Inicio</th>
            <th>Presupuesto</th>
        </tr>
        <?php
        // Conexión a la base de datos
        $conexion = new mysqli("localhost", "vale", "Salem31ob", "apes");

        // Verificar conexión
        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }

        // Consulta SQL para obtener las obras
        $sql = "SELECT * FROM obras";
        $resultado = $conexion->query($sql);

        // Mostrar las obras en una tabla HTML
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                echo "<tr>";
                // Hacer que el nombre de la obra sea un enlace
                echo "<td><a href='detalle_obra.php?id=".$fila['id']."'>".$fila['nombre']."</a></td>";
                echo "<td>".$fila['descripcion']."</td>";
                echo "<td>".$fila['fecha_inicio']."</td>";
                echo "<td>".$fila['presupuesto']."</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No se encontraron obras.</td></tr>";
        }

        // Cerrar la conexión a la base de datos
        $conexion->close();
        ?>
    </table>
    <br>
    <a href="inicio.html">Volver a la página de inicio</a><br>
    <a href="nueva_obra.html">Agregar nueva obra</a>
</body>
</html>
