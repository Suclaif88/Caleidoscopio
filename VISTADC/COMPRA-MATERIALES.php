<?php
session_start();

if(!isset($_SESSION["nombre"])){
    header("Location:../INDEX.html");
    exit();
}

if(strval($_SESSION["rol"]) !== "3") {
  header("Location: ../INDEX.html");
  exit();
}
?>

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
        <li><a href="OBRAS.php" >Obras</a></li>
        <li><a href="COTIZACION.php">Cotizaciones</a></li>
        <li><a href="DC.php">Inicio</a></li>
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
            3 => "Pendiente de Aprobacion",
            4 => "Aprobado por Gerencia",
            5 => "Rechazado por Gerencia",
            7 => "Urgentes",
            9 => "Aprobado por Gerencia",
            10 => "Rechazado por Gerencia",
            12 => "Aprobado por Gerencia sin verificar",
            13 => "Aprobado por Gerencia Verificado",
        );



        $sql = "SELECT pedidos.usuario, pedidos.fecha_pedido, pedidos.estado, obras.nombre AS nombre
        FROM pedidos
        INNER JOIN obras ON pedidos.obra_id = obras.id
        WHERE pedidos.estado = 1
        GROUP BY pedidos.fecha_pedido";







$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        echo "<tr>";
        echo "<td><a href='DETALLESMA.php?fecha_pedido=".$fila['fecha_pedido']."'>".$fila['usuario']."</a></td>";
        echo "<td>".$fila['fecha_pedido']."</td>";
        echo "<td>".$fila['nombre']."</td>";
        echo "<td>".$estados[$fila['estado']]."</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='4'>No se encontraron pedidos.</td></tr>";
}


 
?>









<table border="1">
    <center>
    <h1>Aprobados por Gerencia</h1>
    </center>
    <tr>
        <th>Nombre</th>
        <th>Fecha Pedido</th>
        <th>Obra</th>
        <th>Estado</th>
    </tr>



<?php

 if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    $sql = "SELECT pedidos.usuario, pedidos.fecha_pedido, pedidos.estado, obras.nombre AS nombre
    FROM pedidos
    INNER JOIN obras ON pedidos.obra_id = obras.id
    WHERE pedidos.estado IN (4, 12, 13)
    GROUP BY pedidos.fecha_pedido";







$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {
while ($fila = $resultado->fetch_assoc()) {
    echo "<tr>";
    echo "<td><a href='DETALLESMAA.php?fecha_pedido=".$fila['fecha_pedido']."'>".$fila['usuario']."</a></td>";
    echo "<td>".$fila['fecha_pedido']."</td>";
    echo "<td>".$fila['nombre']."</td>";
    echo "<td>".$estados[$fila['estado']]."</td>";
    echo "</tr>";
}
} else {
echo "<tr><td colspan='4'>No se encontraron pedidos.</td></tr>";
}





    ?>
</table>






<table border="1">
    <center>
    <h1>Rechazados por Gerencia</h1>
    </center>
    <tr>
        <th>Nombre</th>
        <th>Fecha Pedido</th>
        <th>Obra</th>
        <th>Estado</th>
    </tr>



<?php

 if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    $sql = "SELECT pedidos.usuario, pedidos.fecha_pedido, pedidos.estado, obras.nombre AS nombre
    FROM pedidos
    INNER JOIN obras ON pedidos.obra_id = obras.id
    WHERE pedidos.estado = 5
    GROUP BY pedidos.fecha_pedido";







$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {
while ($fila = $resultado->fetch_assoc()) {
    echo "<tr>";
    echo "<td><a href='RE.php?fecha_pedido=".$fila['fecha_pedido']."'>".$fila['usuario']."</a></td>";
    echo "<td>".$fila['fecha_pedido']."</td>";
    echo "<td>".$fila['nombre']."</td>";
    echo "<td>".$estados[$fila['estado']]."</td>";
    echo "</tr>";
}
} else {
echo "<tr><td colspan='4'>No se encontraron pedidos.</td></tr>";
}

    ?>
</table>





<table border="1">
    <center>
    <h1>Urgentes Pendientes</h1>
    </center>
    <tr>
        <th>Nombre</th>
        <th>Fecha Pedido</th>
        <th>Obra</th>
        <th>Estado</th>
    </tr>



    <?php

if ($conexion->connect_error) {
       die("Error de conexión: " . $conexion->connect_error);
   }

   $sql = "SELECT pedidos.usuario, pedidos.fecha_pedido, pedidos.estado, obras.nombre AS nombre
   FROM pedidos
   INNER JOIN obras ON pedidos.obra_id = obras.id
   WHERE pedidos.estado = 7
   GROUP BY pedidos.fecha_pedido";







$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {
while ($fila = $resultado->fetch_assoc()) {
   echo "<tr>";
   echo "<td><a href='DETALLESURDC.php?fecha_pedido=".$fila['fecha_pedido']."'>".$fila['usuario']."</a></td>";
   echo "<td>".$fila['fecha_pedido']."</td>";
   echo "<td>".$fila['nombre']."</td>";
   echo "<td>".$estados[$fila['estado']]."</td>";
   echo "</tr>";
}
} else {
echo "<tr><td colspan='4'>No se encontraron pedidos.</td></tr>";
}






   ?>
</table>






<table border="1">
    <center>
    <h1>Urgentes Aprobados</h1>
    </center>
    <tr>
        <th>Nombre</th>
        <th>Fecha Pedido</th>
        <th>Obra</th>
        <th>Estado</th>
    </tr>



    <?php

if ($conexion->connect_error) {
       die("Error de conexión: " . $conexion->connect_error);
   }

   $sql = "SELECT pedidos.usuario, pedidos.fecha_pedido, pedidos.estado, obras.nombre AS nombre
   FROM pedidos
   INNER JOIN obras ON pedidos.obra_id = obras.id
   WHERE pedidos.estado = 9
   GROUP BY pedidos.fecha_pedido";







$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {
while ($fila = $resultado->fetch_assoc()) {
   echo "<tr>";
   echo "<td><a href='DETALLESAUR.php?fecha_pedido=".$fila['fecha_pedido']."'>".$fila['usuario']."</a></td>";
   echo "<td>".$fila['fecha_pedido']."</td>";
   echo "<td>".$fila['nombre']."</td>";
   echo "<td>".$estados[$fila['estado']]."</td>";
   echo "</tr>";
}
} else {
echo "<tr><td colspan='4'>No se encontraron pedidos.</td></tr>";
}




   ?>
</table>

<table border="1">
    <center>
    <h1>Urgentes Rechazados</h1>
    </center>
    <tr>
        <th>Nombre</th>
        <th>Fecha Pedido</th>
        <th>Obra</th>
        <th>Estado</th>
    </tr>



    <?php

if ($conexion->connect_error) {
       die("Error de conexión: " . $conexion->connect_error);
   }

   $sql = "SELECT pedidos.usuario, pedidos.fecha_pedido, pedidos.estado, obras.nombre AS nombre
   FROM pedidos
   INNER JOIN obras ON pedidos.obra_id = obras.id
   WHERE pedidos.estado = 10
   GROUP BY pedidos.fecha_pedido";







$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {
while ($fila = $resultado->fetch_assoc()) {
   echo "<tr>";
   echo "<td><a href='REUR.php?fecha_pedido=".$fila['fecha_pedido']."'>".$fila['usuario']."</a></td>";
   echo "<td>".$fila['fecha_pedido']."</td>";
   echo "<td>".$fila['nombre']."</td>";
   echo "<td>".$estados[$fila['estado']]."</td>";
   echo "</tr>";
}
} else {
echo "<tr><td colspan='4'>No se encontraron pedidos.</td></tr>";
}




$conexion->close();


   ?>
</table>
</div>
</body>
</html>