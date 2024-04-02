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
    
    require_once("../PHP/CONN.php");

    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }
    $obra_id = $_GET['obra_id'];
    $sql = "SELECT * FROM pedidos WHERE obra_id = $obra_id";
    $resultado = $conexion->query($sql);
    $obra = $resultado->fetch_assoc();

    ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de Solicitud de Materiales R</title>
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


<header class="navbar">
    <h1>DEVOLUCIONES</h1>
        <ul>
        <li><a href="DEVOLUCIONES.php" style="color:white;">Devoluciones</a></li>
        <li><a href="OBRASRE.php">Obras</a></li>
        <li><a href="SOLICITUD.php" >Solicitud de compra</a></li>
        <li><a href="RE.php">Atras</a></li>
        </ul>
</header>



<br>
<h2>Detalle de Solicitud de Materiales</h2>


<?php

// ESTADOS DE LOS PEDIDOS

$estados = array(
    1 => "Pendiente de Envio",
    2 => "Rechazado",
    3 => "Pendiente de Aprobacion",
    4 => "Aprobado por Gerencia",
    5 => "Rechazado por Gerencia",
    7 => "Urgentes",
    9 => "Aprobado por Gerencia",
    10 => "Urgente Rechazado ",
    
);

if (isset($_GET['obra_id'])) {
    $obra_id = $_GET['obra_id'];

    require_once("../PHP/CONN.php");

    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    $sql = "SELECT producto, cantidad, unidad, precio, estado
            FROM pedidos
            WHERE obra_id = $obra_id AND estado = 10";
    $resultado = $conexion->query($sql);

    $subtotal = 0;

    if ($resultado->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr><th>Producto</th><th>Cantidad</th><th>Unidad</th><th>Precio Unitario</th><th>Precio Total</th><th>Estado</th></tr>";
        while ($fila = $resultado->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$fila['producto']."</td>";
            echo "<td>".$fila['cantidad']."</td>";
            echo "<td>".$fila['unidad']."</td>";
            echo "<td>".$fila['precio']."</td>";
            $precio_total = $fila['cantidad'] * $fila['precio'];
            echo "<td>".$precio_total."</td>";
            $subtotal += $precio_total;
            echo "<td>".$estados[$fila['estado']]."</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "<br>";
        echo "<h1>Subtotal: <span style='float: right;'>$subtotal</span></h1>";
    } else {
        echo "<br>";
        echo "No se encontraron detalles de la solicitud de materiales para este id de obra.";
    }

    $conexion->close();
} else {
    echo "<br>";
    echo "El parámetro para búsqueda no fue proporcionado.";
}
?>


    <br>
    <br>
    <a href="DEVOLUCIONES.php" class="btn">Volver a la lista de solicitudes</a>
</body>
</html>