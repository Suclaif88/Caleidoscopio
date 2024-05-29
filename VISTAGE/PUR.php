<?php
    session_start();
    if(!isset($_SESSION["nombre"])){
        header("Location:../INDEX.html");
        exit();
    }
    if(strval($_SESSION["rol"]) !== "2") {
        header("Location: ../INDEX.html");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GERENTE</title>
    <link rel="stylesheet" href="../CSS/CSSDO.css">
    <link rel="stylesheet" href="../CSS/responsive.css">
    <link rel="stylesheet" href="../CSS/CSSCO.css">
    <link rel="icon" type="image/png" href="../IMG/favicon.png">
</head>
<body>
<div class="area">

</div>
<nav class="main-menu">
            <ul>
                <li>
                    <a href="PEDIDOSGE.php">
                        <i class="fa fa-envelope fa-2x"></i>
                        <span class="nav-text">
                           Solicitudes
                        </span>
                    </a>
                  
                </li>
                <li>
                    <a href="PUR.php">
                        <i class="fa fa-exclamation-triangle fa-2x"></i>
                        <span class="nav-text">
                            Solicitudes Urgentes
                        </span>
                    </a>
                </li>
                <li>
                   <a href="GE.php">
                        <i class="fa fa-user fa-2x"></i>
                        <span class="nav-text">
                            Usuario
                        </span>
                    </a>
                </li>
            </ul>

            <ul class="logout">
                <li>
                   <a href="../PHP/LOGOUT.php">
                         <i class="fa fa-power-off fa-2x"></i>
                        <span class="nav-text">
                            Logout
                        </span>
                    </a>
                </li>  
            </ul>
        </nav>

        <div class="container">
            <center><h1>Solicitudes Urgentes Entrantes</h1></center> <br>
<table border="1">
    <tr>
        <th>Nombre</th>
        <th>Fecha Pedido</th>
        <th>Obra</th>
        <th>Estado</th>
    </tr>
    <?php

require_once("../PHP/CONN.php");

// ESTADOS DE LOS PEDIDOS

$estados = array(
    1 => "Pendiente de Envio",
    2 => "Rechazado",
    3 => "Pendiente de Aprobacion",
    4 => "Aprobado por Gerencia",
    5 => "Rechazado por Gerencia",
    7 => "Urgentes",
    8 => "Urgente",
    9 => "Aprobado por Gerencia",
    10 => "Rechazado por Gerencia",
    11 => "Recibido sin verificacion",
    12 => "Aprobado por Gerencia sin verificar",
    13 => "Aprobado por Gerencia Verificado",
    14 => "Enviado Urgente sin verificacion",
    
);


$sql = "SELECT pedidos.usuario, pedidos.fecha_pedido, pedidos.estado, obras.nombre AS nombre
FROM pedidos
INNER JOIN obras ON pedidos.obra_id = obras.id
WHERE pedidos.estado IN (8, 14)
GROUP BY pedidos.fecha_pedido";







$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {
while ($fila = $resultado->fetch_assoc()) {
echo "<tr>";
echo "<td><a href='DETALLESURGE.php?fecha_pedido=".$fila['fecha_pedido']."'>".$fila['usuario']."</a></td>";
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