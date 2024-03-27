<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compra-Materiales</title>
    <link rel="stylesheet" href="../CSS/CSSCO.css">
    <link rel="stylesheet" href="../CSS/CSS.css">
    <link rel="stylesheet" href="../CSS/responsive.css">
    <link rel="icon" type="image/png" href="../IMG/favicon.png">
</head>
<body>




<div class="navbar">
    <h1 style="cursor:default;">COMPRA DE MATERIALES</h1>
    <ul>
        <li><a href="" style="color:white;">Compra de materiales</a></li>
        <li><a href="COMPRA-SIMPLE.php">Compra simple</a></li>
        <li><a href="OBRAS.php" >Obras</a></li>
        <li><a href="COTIZACION.php">Cotizaciones</a></li>
        <li><a href="DC.php">Atras</a></li>
    </ul>
</div>


<div class="container">

<table border="1">
    <center>
    <h1>Pendientes de Envio</h1>
    </center>
    <tr>
        <th>Nombre</th>
        <th>Fecha Pedido</th>
        <th>Estado</th>
    </tr>
    <?php

    require_once("../PHP/CONN.php");

    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    $sql = "SELECT DISTINCT obra_id, usuario, fecha_pedido, estado FROM pedidos WHERE estado = 1";
    $resultado = $conexion->query($sql);

    if ($resultado->num_rows > 0) {
        while ($fila = $resultado->fetch_assoc()) {
            echo "<tr>";
            echo "<td><a href='DETALLESMA.php?obra_id=".$fila['obra_id']."'>".$fila['usuario']."</a></td>"; 
            echo "<td>".$fila['fecha_pedido']."</td>";
            echo "<td>".$fila['estado']."</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='5'>No se encontraron obras.</td></tr>";
    }?>









<table border="1">
    <center>
    <h1>Aprobados por Gerencia</h1>
    </center>
    <tr>
        <th>Nombre</th>
        <th>Fecha Pedido</th>
        <th>Estado</th>
    </tr>



<?php

 if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    $sql = "SELECT DISTINCT obra_id, usuario, fecha_pedido, estado FROM pedidos WHERE estado = 4";
    $resultado = $conexion->query($sql);

    if ($resultado->num_rows > 0) {
        while ($fila = $resultado->fetch_assoc()) {
            echo "<tr>";
            echo "<td><a href='DETALLESMAA.php?obra_id=".$fila['obra_id']."'>".$fila['usuario']."</a></td>"; 
            echo "<td>".$fila['fecha_pedido']."</td>";
            echo "<td>".$fila['estado']."</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='5'>No se encontraron obras aprobadas por gerente.</td></tr>";
    }





    $conexion->close();











   

    ?>
</table>
</div>




</body>
</html>