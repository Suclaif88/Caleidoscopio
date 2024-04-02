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
        <h1>Solicitudes Urgentes Entrantes</h1> <br>
<table border="1">
    <tr>
        <th>Nombre</th>
        <th>Fecha Pedido</th>
    </tr>
    <?php

    require_once("../PHP/CONN.php");

    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    $sql = "SELECT DISTINCT obra_id, usuario, fecha_pedido FROM pedidos WHERE estado = 8";
    $resultado = $conexion->query($sql);

    if ($resultado->num_rows > 0) {
        while ($fila = $resultado->fetch_assoc()) {
            echo "<tr>";
            echo "<td><a href='DETALLESURGE.php?obra_id=".$fila['obra_id']."'>".$fila['usuario']."</a></td>"; 
            echo "<td>".$fila['fecha_pedido']."</td>";
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