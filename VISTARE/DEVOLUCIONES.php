<?php
    session_start();
    if(!isset($_SESSION["nombre"])){
        header("Location:../INDEX.html");
        exit();
    }
    if(strval($_SESSION["rol"]) !== "5") {
        header("Location: ../INDEX.html");
        exit();
    }
?>

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
    <h1>Proceso de cotizacion</h1>
    </center>
    <tr>
        <th>Nombre</th>
        <th>Fecha Pedido</th>
        <th>Obra</th>
        <th>Estado</th>
        
    </tr>


    
<?php
// ESTADOS DE LOS PEDIDOS
  $estados = array(
    0 => "Pendiente de aprobacion por director de obra",
    1 => "Aprobado por director de obra",
    2 => "Rechazado por director de obra",
    3 => "Pendiente de aprobacion por gerente",
    4 => "Aprobado por gerencia",
    5 => "Rechazado por gerencia",
    6 => "Urgente, pendiente de aprobacion por director de obra",
    7 => "Urgente, aprobado por director de obra",
    8 => "Urgente, pendiente de aprobacion por gerente",
    9 => "Urgente, aprobado por gerencia",
    10 => "Urgente Rechazado ",
    11 => "Aprobado por director de obra sin verificar",
    12 => "Aprobado por director de obra y gerente sin verificar",
    13 => "Aprobado y verificado por gerente",
    14 => "Urgente, Aprobado por director de obra sin verificar",
    15 => "Urgente, Aprobado por director de obra y gerente sin verificar",
    16 => "Urgente, Aprobado y verificado por gerente",
    
);

    require_once("../PHP/CONN.php");

    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }


        $sql = "SELECT pedidos.usuario, pedidos.fecha_pedido, pedidos.estado, obras.nombre AS nombre
        FROM pedidos
        INNER JOIN obras ON pedidos.obra_id = obras.id
        WHERE pedidos.estado IN (0, 1, 3, 11, 12, 13)
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
    <h1>Aprobados</h1>
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
    WHERE pedidos.estado IN (2, 5)
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
    <h1>Urgentes en proceso de cotizacion</h1>
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
   WHERE pedidos.estado IN (6, 7, 8, 14, 15, 16)
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