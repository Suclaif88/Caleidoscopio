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
    <title>Detalle de Solicitud de Materiales A</title>
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
        <li><a href="OBRAS.php" >Obras</a></li>
        <li><a href="COTIZACION.php">Cotizaciones</a></li>
        <li><a href="DC.php">Atras</a></li>
    </ul>
</div>


<br>
<h2>Detalle de Solicitud de Materiales</h2>


<?php

require_once("../PHP/CONN.php");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$fecha_pedido = $_GET['fecha_pedido'] ?? '';

if ($fecha_pedido) {
    $sql = "SELECT producto, cantidad, unidad, precio, historial, descuento, impuesto, proveedor
            FROM pedidos
            WHERE fecha_pedido = ? AND estado = 10";
    $statement = $conexion->prepare($sql);
    if ($statement === false) {
        die("Error de preparación de la declaración: " . $conexion->error);
    }
    $statement->bind_param("s", $fecha_pedido);
    $statement->execute();
    $resultado = $statement->get_result();

    $subtotal = 0;
    if ($resultado->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr><th>Producto</th><th>Cantidad</th><th>Unidad</th><th>Precio Unitario</th><th>Descuento</th><th>Impuesto</th><th>Precio Total</th><th>Proveedor</th></tr>";
        while ($fila = $resultado->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($fila['producto']) . "</td>";
            echo "<td style='position: relative;'>" . htmlspecialchars($fila['cantidad']);
            if ($fila['historial'] == 3) {
                echo "<span class='editado fa fa-exclamation-circle' title='Editado' style='position: absolute; top: 15px; right: -10px;'></span>";
            }
            echo "</td>";
            echo "<td>" . htmlspecialchars($fila['unidad']) . "</td>";
            echo "<td>" . htmlspecialchars($fila['precio']) . "</td>";
            echo "<td>" . htmlspecialchars($fila['descuento']) . "</td>";
            echo "<td>" . htmlspecialchars($fila['impuesto']) . "</td>";
            $precio_total = $fila['cantidad'] * ($fila['precio'] - ($fila['precio'] * ($fila['descuento'] / 100)) + ($fila['precio'] * ($fila['impuesto'] / 100)));
            echo "<td>" . htmlspecialchars($precio_total) . "</td>";
            echo "<td>" . htmlspecialchars($fila['proveedor']) . "</td>";
            $subtotal += $precio_total;
            echo "</tr>";
        }
        echo "</table>";
        echo "<br>";
        echo "<h1>Subtotal: <span style='float: right;'>" . number_format($subtotal, 2, '.', ',') . "</span></h1>";
    } else {
        echo "<br>";
        echo "No se encontraron detalles de la solicitud de materiales para esta fecha de pedido.";
    }

    $statement->close();
} else {
    echo "<br>";
    echo "El parámetro para búsqueda no fue proporcionado.";
}

$conexion->close();
?>

    <br>
    <br>
    <a href="SOLICITUDES.php" class="btn">Volver a la lista de solicitudes</a>
</body>
</html>