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

// ESTADOS DE LOS PEDIDOS

    $estados = array(
            0 => "Pendiente de aprobacion por director de obra",
            1 => "Pendiente de envio a gerente",
            2 => "Rechazado por director de obra",
            3 => "Pendiente de aprobacion por gerencia",
            4 => "Aprobado por gerencia",
            5 => "Rechazado por Gerencia",
            6 => "Urgente, Pendiente por aprobacion de director de obra",
            7 => "Urgente, Aceptado por director de obra",
            8 => "Urgente, Pendiente de aprobacion por gerencia", 
            9 => "Urgente, Aprobado por gerencia",
            10 => "Urgente, Rechazado",
            11 => "Aprobado por director de obra sin verificar",
            12 => "Aprobado por sin verificar por director de obra y gerente",
            13 => "Aprobado y verificado por gerencia",
            14 => "Urgente, Aprobado sin verificar por director de obra",
            15 => "Urgente, Aprobado sin verificar por director de obra y gerente",
            16 => "Urgente, Aprobado y verificado por gerente",
        );

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
    <h1 style="cursor:default;">SOLICITUDES</h1>
    <ul>
        <li><a href="" style="color:white;">Solicitudes</a></li>
        <li><a href="OBRAS.php" >Obras</a></li>
        <li><a href="COTIZACION.php">Cotizaciones</a></li>
        <li><a href="DC.php">Inicio</a></li>
    </ul>
</div>


<div class="container">

<table border="1">
    <center>
    <h1>Pendientes</h1>
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

        $sql = "SELECT pedidos.usuario, pedidos.fecha_pedido, pedidos.estado, obras.nombre AS nombre
        FROM pedidos
        INNER JOIN obras ON pedidos.obra_id = obras.id
        WHERE pedidos.estado IN (1, 3, 12, 13)
        GROUP BY pedidos.fecha_pedido";


$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        echo "<tr>";
        echo "<td><a href='DETALLESSO.php?fecha_pedido=".$fila['fecha_pedido']."'>".$fila['usuario']."</a></td>";
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
    WHERE pedidos.estado IN (4)
    GROUP BY pedidos.fecha_pedido";







$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {
while ($fila = $resultado->fetch_assoc()) {
    echo "<tr>";
    echo "<td><a href='DETALLESSO.php?fecha_pedido=".$fila['fecha_pedido']."'>".$fila['usuario']."</a></td>";
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
    <h1>Rechazados</h1>
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
    WHERE pedidos.estado IN (5)
    GROUP BY pedidos.fecha_pedido";







$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {
while ($fila = $resultado->fetch_assoc()) {
    echo "<tr>";
    echo "<td><a href='DETALLESSO.php?fecha_pedido=".$fila['fecha_pedido']."'>".$fila['usuario']."</a></td>";
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
   WHERE pedidos.estado IN (7, 8, 15, 16)
   GROUP BY pedidos.fecha_pedido";



$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {
while ($fila = $resultado->fetch_assoc()) {
   echo "<tr>";
   echo "<td><a href='DETALLESSO.php?fecha_pedido=".$fila['fecha_pedido']."'>".$fila['usuario']."</a></td>";
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
   WHERE pedidos.estado IN (9)
   GROUP BY pedidos.fecha_pedido";







$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {
while ($fila = $resultado->fetch_assoc()) {
   echo "<tr>";
   echo "<td><a href='DETALLESSO.php?fecha_pedido=".$fila['fecha_pedido']."'>".$fila['usuario']."</a></td>";
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
   WHERE pedidos.estado IN (10)
   GROUP BY pedidos.fecha_pedido";







$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {
while ($fila = $resultado->fetch_assoc()) {
   echo "<tr>";
   echo "<td><a href='DETALLESSO?fecha_pedido=".$fila['fecha_pedido']."'>".$fila['usuario']."</a></td>";
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