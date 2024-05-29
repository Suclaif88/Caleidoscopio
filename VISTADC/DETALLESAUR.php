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
    
require_once("../PHP/CONN.php");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$fecha_pedido = $_GET['fecha_pedido'];

$sql = "SELECT * FROM pedidos WHERE fecha_pedido = '$fecha_pedido'";
$resultado = $conexion->query($sql);
$pedido = $resultado->fetch_assoc();

    ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de Solicitud de Materiales Aprobados</title>
    <link rel="stylesheet" href="../CSS/CSSDO.css">
    <link rel="stylesheet" href="../CSS/responsive.css">
    <link rel="stylesheet" href="../CSS/CSSCO.css">
    <link rel="stylesheet" href="../CSS/CSS.css">
    <link rel="icon" type="image/png" href="../IMG/favicon.png">
    <style>

            @media print {
            /* Ocultar el navbar */
            .navbar {
                display: none;
            }
            /* Establecer el ancho de la tabla al 100% */
            table {
                width: 100%;
                margin-top: 20px;
            }
            /* Ocultar los botones de imprimir y volver */
            .btn {
                display: none;
            }
        }

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
            cursor:default;
        }

        tr:nth-child(even) {
            background-color: #fff;
        }

    .op {
        margin-top: 20px;
    }
    .op button {
        padding: 10px 20px;
        font-size: 16px;
        cursor: pointer;
        border: none;
        outline: none;
        margin-right: 10px;
    }
    .op button.aceptar {
    -webkit-border-radius: 28;
    -moz-border-radius: 28;
    border-radius: 28px;
    font-family: Arial;
    color: #ffffff;
    font-size: 20px;
    background: #4CAF50;
    padding: 10px 20px 10px 20px;
    border: solid #000000 4px;
    text-decoration: none;
    }

    .op button.aceptar:hover{
        background: #21a631;
        text-decoration: none;
    }

    .op button.rechazar {
    -webkit-border-radius: 28;
    -moz-border-radius: 28;
    border-radius: 28px;
    font-family: Arial;
    color: #ffffff;
    font-size: 20px;
    background: #e33d3d;
    padding: 10px 20px 10px 20px;
    border: solid #000000 4px;
    text-decoration: none;
    }

    .op button.rechazar:hover{
        background: #a62121;
        text-decoration: none;
    }
    
    </style>
</head>
<body>


<div class="navbar">
    <h1 style="cursor:default;">DETALLES</h1>
    <ul>
        <li><a href="" style="color:white;">Solicitudes</a></li>
        <li><a href="COMPRA-SIMPLE.php">Compra simple</a></li>
        <li><a href="OBRAS.php" >Obras</a></li>
        <li><a href="COTIZACION.php">Cotizaciones</a></li>
        <li><a href="DC.php">Atras</a></li>
    </ul>
</div>


<br>
<h2>Detalle de Solicitud de Materiales</h2>


<?php

$estados = array(
    14 => "Aprobado por Gerencia Verificado Urgente",
    15 => "Aprobado por Gerencia sin verificar Urgente",
);

if (isset($_GET['fecha_pedido'])) {
    $fecha_pedido = $_GET['fecha_pedido'];

    require_once("../PHP/CONN.php");

    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    $sql = "SELECT producto, cantidad, unidad, precio, historial, estado, descuento, impuesto, proveedor
            FROM pedidos
            WHERE fecha_pedido = '$fecha_pedido' AND (estado = 9 OR estado = 14 OR estado = 15)";
    $resultado = $conexion->query($sql);

    $subtotal = 0;
    $estadoMostrado = false;

    if ($resultado->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr><th>Producto</th><th>Cantidad</th><th>Unidad</th><th>Precio Unitario</th><th>Descuento</th><th>Impuesto</th><th>Precio Total</th><th>Proveedor</th></tr>";
        while ($fila = $resultado->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$fila['producto']."</td>";
            echo "<td style='position: relative;'>".$fila['cantidad'];
            if ($fila['historial'] == 3) {
                echo "<span class='editado fa fa-exclamation-circle' title='Editado' style='position: absolute; top: 5px; right: -10px;'></span>";
            }
            echo "</td>";
            echo "<td>".$fila['unidad']."</td>";
            echo "<td>".$fila['precio']."</td>";
            echo "<td>".$fila['impuesto']."</td>";
            $precio_total = $fila['cantidad'] * ($fila['precio']-($fila['precio']*($fila['descuento']/100))+(($fila['precio']*($fila['descuento']/100))*($fila['impuesto']/100))) ;
            echo "<td>".$precio_total."</td>";
            echo "<td>".$fila['proveedor']."</td>";
            $subtotal += $precio_total;
            echo "</tr>";
            if ($fila['estado'] == 15 && !$estadoMostrado) {
                $estadoMostrado = true;
            }
        }
        echo "</table>";
        echo "<br>";
        echo "<h1>Subtotal: <span style='float: right;'>" . number_format($subtotal, 2, '.', ',') . "</span></h1>";
        
        if ($estadoMostrado) {
            echo "<h1 style='margin-top: 20px;'>".$estados[15]." <span style='color: red;'>!</span></h1>";
        }
    } else {
        echo "<br>";
        echo "No se encontraron detalles de la solicitud de materiales para esta fecha de pedido.";
    }

    $conexion->close();
} else {
    echo "<br>";
    echo "El parámetro para búsqueda no fue proporcionado.";
}
?>

<br>
<br>
<!-- Botón para imprimir la solicitud -->
<button onclick="window.print();" class="btn">Imprimir Solicitud</button>
<br>
<br>
<!-- Botón para volver a la lista de solicitudes -->
<button onclick="window.location.href = 'SOLICITUDES.php';" class="btn">Volver a la lista de solicitudes</button>
</body>
</html>
