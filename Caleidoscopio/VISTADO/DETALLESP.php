<?php   
    
    require_once("../PHP/CONN.php");

    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }
    $id = $_GET['id'];
    $sql = "SELECT * FROM pedidos WHERE id = $id";
    $resultado = $conexion->query($sql);
    $obra = $resultado->fetch_assoc();

    ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de la Obra</title>
    <link rel="stylesheet" href="../CSS/CSSDO.css">
    <link rel="stylesheet" href="../CSS/responsive.css">
    <link rel="stylesheet" href="../CSS/CSSCO.css">
    <link rel="stylesheet" href="../CSS/CSS.css">
    <link rel="icon" type="image/png" href="../IMG/favicon.png">
    <style>
        table {
            border-collapse: collapse;
            width: 60%;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #b1b1b1;
            cursor:default;"
        }

        tr:nth-child(even) {
            background-color: #fff;
        }
    </style>
</head>
<body>

<nav class="main-menu">
            <ul>
                <li>
                    <a href="PEDIDOS.php">
                        <i class="fa fa-envelope fa-2x"></i>
                        <span class="nav-text">
                           Solicitudes
                        </span>
                    </a>
                  
                </li>
                <li>
                    <a href="PEUR">
                        <i class="fa fa-exclamation-triangle fa-2x"></i>
                        <span class="nav-text">
                            Solicitudes Urgentes
                        </span>
                    </a>
                </li>
                <li>
                   <a href="DOU.php">
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

<?php   

    $sql = "SELECT * FROM pedidos WHERE id = $id";
    $resultado = $conexion->query($sql);

    if ($resultado->num_rows > 0) {
        $obra = $resultado->fetch_assoc();
        echo "<table>";

        echo "<tr>";
        echo "<th>Nombre</th>";
        echo "<th>Cantidad</th>";
        echo "<th>Unidad</th>";
        echo "<th>Fecha</th>";
        echo "<th>Obra</th>";
        echo "</tr>";
        
        echo "<tr>";
        echo "<td>".$obra['producto']."</td>";
        echo "<td>".$obra['cantidad']."</td>";
        echo "<td>".$obra['unidad']."</td>";
        echo "<td>".$obra['fecha_pedido']."</td>";
        echo "<td>".$obra['obra_id']."</td>";
        echo "</tr>";
        
        echo "</table>";
        
    } else {
        echo "No se encontró la obra.";
    }

    $conexion->close();
    ?>

    <br>
    <a href="PEDIDOS.php" class="btn">Volver a la lista de pedidos</a>
</body>
</html>
