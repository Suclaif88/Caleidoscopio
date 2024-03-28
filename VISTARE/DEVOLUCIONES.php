<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DEVOLUCIONES</title>
    <link rel="stylesheet" href="../CSS/CSSCO.css">
    <link rel="stylesheet" href="../CSS/CSS.css">
    <link rel="stylesheet" href="../CSS/responsive.css">
    <link rel="icon" type="image/png" href="../IMG/favicon.png">
</head>
<body>




<header class="navbar">
    <h1>DEVOLUCIONES</h1>
        <ul>
        <li><a href="DEVOLUCIONES.php" style="color:white;">Devoluciones</a></li>
        <li><a href="OBRASRE.php">Obras</a></li>
        <li><a href="SOLICITUD.php" >Solicitud de compra</a></li>
        <li><a href="RE.php">Atras</a></li>
        </ul>
</header>


<div class="container">

<table border="1">
    <center>
    <h1>DEVOLUCION DE SOLICITUDES</h1>
    </center>
    <tr>
        <th>Nombre</th>
        <th>Fecha Pedido</th>
        <th>Obra</th>
        <th>Estado</th>
    </tr>


    
    <?php
  
    require_once("../PHP/CONN.php");

    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }


// ESTADOS DE LOS PEDIDOS

    $estados = array(
            1 => "Pendiente de Envio",
            2 => "Rechazado",
            3 => "Pendiente de Aprovacion",
            4 => "Aprobado por Gerencia",
            
        );



        $sql = "SELECT DISTINCT pedidos.obra_id, pedidos.usuario, pedidos.fecha_pedido, pedidos.estado, obras.nombre AS nombre_obra
        FROM pedidos
        INNER JOIN obras ON pedidos.obra_id = obras.id
        WHERE pedidos.estado = 2";
    $resultado = $conexion->query($sql);

    if ($resultado->num_rows > 0) {
        while ($fila = $resultado->fetch_assoc()) {
            echo "<tr>";
            echo "<td><a href='DEVOLUCIONESDE.php?obra_id=".$fila['obra_id']."'>".$fila['usuario']."</a></td>"; 
            echo "<td>".$fila['fecha_pedido']."</td>";
            echo "<td>".$fila['nombre_obra']."</td>";
            echo "<td>".$estados[$fila['estado']]."</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='5'>No se encontraron obras.</td></tr>";

 
    }?>

</div>

</body>
</html>