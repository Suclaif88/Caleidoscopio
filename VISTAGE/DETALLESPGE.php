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
    <title>Detalle de Solicitud de Materiales</title>
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

    .op button.esv {
    -webkit-border-radius: 28;
    -moz-border-radius: 28;
    border-radius: 28px;
    font-family: Arial;
    color: #ffffff;
    font-size: 20px;
    background: #ff9736;
    padding: 10px 20px 10px 20px;
    border: solid #000000 4px;
    text-decoration: none;
    }

    .op button.esv:hover{
        background: #974006;
        text-decoration: none;
    }
    
    </style>
</head>

<script>
        document.addEventListener("DOMContentLoaded", function() {
            var fecha_pedido = "<?php echo isset($_GET['fecha_pedido']) ? $_GET['fecha_pedido'] : ''; ?>";

            function sendRequest(url, action) {
                if (fecha_pedido) {
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", url, true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            alert(xhr.responseText);
                            window.location.href = "PEDIDOSGE.php";
                        }
                    };
                    xhr.send("accion=" + action + "&fecha_pedido=" + encodeURIComponent(fecha_pedido));
                } else {
                    console.error("No se proporcionó la fecha de pedido.");
                }
            }

            document.getElementById("btnAceptarGE")?.addEventListener("click", function() {
                sendRequest("../PHP/ACEPTARGE.php", "aceptar");
            });

            document.getElementById("btnRechazarGE")?.addEventListener("click", function() {
                sendRequest("../PHP/RECHAZARGE.php", "rechazar");
            });

            document.getElementById("btnEnviadoSinVerificacion2")?.addEventListener("click", function() {
                if (confirm("¿Está seguro de que desea enviar sin verificación?")) {
                    sendRequest("../PHP/ENVIADO_SIN_VERIFICACION2.php", "enviado_sin_verificacion");
                }
            });

            document.getElementById("btnAceptarGE2")?.addEventListener("click", function() {
                sendRequest("../PHP/ACEPTARGE2.php", "aceptar");
            });
        });
    </script>

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
                    <a href="PUR.php">
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
<br>
<h2>Detalle de Solicitud de Materiales</h2>


<?php
if (isset($_GET['fecha_pedido'])) {
    $fecha_pedido = $_GET['fecha_pedido'];

    require_once("../PHP/CONN.php");

    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    $sql = "SELECT id, producto, cantidad, unidad, precio, historial, descuento, impuesto, estado, proveedor
            FROM pedidos
            WHERE fecha_pedido = '$fecha_pedido'";
    $resultado = $conexion->query($sql);

    $subtotal = 0;

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
            echo "<td>".$fila['descuento']."</td>";
            echo "<td>".$fila['impuesto']."</td>";
            $precio_total = $fila['cantidad'] * ($fila['precio']-($fila['precio']*($fila['descuento']/100))+(($fila['precio']*($fila['descuento']/100))*($fila['impuesto']/100))) ;
            echo "<td>".$precio_total."</td>";
            echo "<td>".$fila['proveedor']."</td>";
            $subtotal += $precio_total;
            echo "</tr>";

            // Actualizar el estado del pedido
            $estadoPedido = $fila['estado'];
        }
        echo "</table>";
        echo "<br>";
        echo "<h1>Subtotal: <span style='float: right;'>" . number_format($subtotal, 2, '.', ',') . "</span></h1>";
        if ($estadoPedido == 11) {
            echo "
            <div class='op'>
                <button class='aceptar' id='btnAceptarGE2'>ACEPTAR</button>
                <button class='rechazar' id='btnRechazarGE'>RECHAZAR</button>
            </div>
            <div class='op'>
                <button class='esv' id='btnEnviadoSinVerificacion2'>ENVIAR SIN VERIFICACION</button>
            </div>
            ";
        }
        elseif ($estadoPedido == 3){
            echo "
            <div class='op'>
                <button class='aceptar' id='btnAceptarGE'>ACEPTAR</button>
                <button class='rechazar' id='btnRechazarGE'>RECHAZAR</button>
            </div>
            ";
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
    <a href="PEDIDOSGE.php" class="btn">Volver a la lista de solicitudes</a>
</body>
</html>
