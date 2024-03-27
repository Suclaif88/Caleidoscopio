<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Obras</title>
    <link rel="stylesheet" href="../CSS/CSSCO.css">
    <link rel="stylesheet" href="../CSS/CSS.css">
    <link rel="stylesheet" href="../CSS/responsive.css">
    <link rel="icon" type="image/png" href="../IMG/favicon.png">
</head>
<body>

<div class="navbar">
    <h1 style="cursor:default;">OBRAS</h1>
    <ul>
        <li><a href="COMPRA-MATERIALES.php">Compra de materiales</a></li>
        <li><a href="COMPRA-SIMPLE.php">Compra simple</a></li>
        <li><a href="" style="color:white;">Obras</a></li>
        <li><a href="COTIZACION.php">Cotizaciones</a></li>
        <li><a href="DC.php">Atras</a></li>
    </ul>
</div>



<div class="cont2">
    <a href="../agr_obra.html" class="div1 btn">Agregar nueva obra</a>
</div>
    

<div class="container">

    <table border="1">
        <tr>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Fecha de Inicio</th>
            <th>Presupuesto</th>
        </tr>
        <?php

        require_once("../PHP/CONN.php");

        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }

        $sql = "SELECT * FROM obras";
        $resultado = $conexion->query($sql);

        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                echo "<tr>";
                echo "<td><a href='DETALLESOB.php?id=".$fila['id']."'>".$fila['nombre']."</a></td>";
                echo "<td>".$fila['descripcion']."</td>";
                echo "<td>".$fila['fecha_inicio']."</td>";
                echo "<td>".$fila['presupuesto']."</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No se encontraron obras.</td></tr>";
        }

        $conexion->close();
        ?>
    </table>
</div>

    
    
</body>
</html>