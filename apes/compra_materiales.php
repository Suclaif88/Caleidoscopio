<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitudes de Materiales</title>
</head>
<body>
    <h2>Solicitudes de Materiales</h2>
    <table border="1">
        <tr>
            <th>Fecha de Solicitud</th>
            <th>Usuario</th>
            <th>Obra</th>
        </tr>
        <?php

        $conexion = new mysqli("localhost", "vale", "Salem31ob", "apes");

        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }

        // obtener las slicitudes de materiales
        $sql = "SELECT MIN(pedidos.fecha_pedido) AS fecha_pedido, pedidos.usuario, obras.nombre AS obra_nombre
                FROM pedidos
                INNER JOIN obras ON pedidos.obra_id = obras.id
                GROUP BY pedidos.id, pedidos.usuario, obras.nombre
                ORDER BY MIN(pedidos.fecha_pedido) DESC";
        $resultado = $conexion->query($sql);

        // tabla HTML de solicitudes
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$fila['fecha_pedido']."</td>";
                echo "<td>".$fila['usuario']."</td>";
                echo "<td>".$fila['obra_nombre']."</td>";
                echo "<td><a href='detalle_solicitud.php?fecha=".$fila['fecha_pedido']."&usuario=".$fila['usuario']."&obra=".$fila['obra_nombre']."'>Ver Detalles</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No se encontraron solicitudes de materiales.</td></tr>";
        }

        $conexion->close();
        ?>
    </table>
    <br>
    <a href="inicio.html">Volver a la página de inicio</a>
</body>
</html>
