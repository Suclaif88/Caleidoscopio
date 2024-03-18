<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de Solicitud de Materiales</title>
</head>
<body>
    <h2>Detalle de Solicitud de Materiales</h2>
    <?php
    // Verificar si se reciben los parámetros en la URL
    if (isset($_GET['fecha']) && isset($_GET['usuario']) && isset($_GET['obra'])) {
        // Obtener los parámetros de la solicitud
        $fecha_pedido = $_GET['fecha'];
        $usuario = $_GET['usuario'];
        $obra_nombre = $_GET['obra'];

        $conexion = new mysqli("localhost", "vale", "Salem31ob", "apes");

        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }

        // Consulta SQL para obtener los detalles de la solicitud de materiales
        $sql = "SELECT producto, cantidad, unidad
                FROM pedidos
                WHERE fecha_pedido = '$fecha_pedido' AND usuario = '$usuario' AND obra_id = (SELECT id FROM obras WHERE nombre = '$obra_nombre')";
        $resultado = $conexion->query($sql);

        // Mostrar los detalles de la solicitud de materiales en una tabla HTML
        if ($resultado->num_rows > 0) {
            echo "<table border='1'>";
            echo "<tr><th>Producto</th><th>Cantidad</th><th>Unidad</th></tr>";
            while ($fila = $resultado->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$fila['producto']."</td>";
                echo "<td>".$fila['cantidad']."</td>";
                echo "<td>".$fila['unidad']."</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No se encontraron detalles de la solicitud de materiales para esta solicitud.";
        }

        $conexion->close();
    } else {
        echo "Parámetros de la solicitud de materiales no proporcionados.";
    }
    ?>
    <br>
    <a href="compra_materiales.php">Volver a la lista de solicitudes</a>
</body>
</html>
