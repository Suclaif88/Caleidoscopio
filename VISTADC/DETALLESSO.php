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
            cursor: default;
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

        .op button.aceptar:hover {
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

        .op button.rechazar:hover {
            background: #a62121;
            text-decoration: none;
        }

        @media print {
            .non-printable {
                display: none;
            }

            .printable-table {
                display: table;
            }
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var btnEnviarge = document.getElementById("btnEnviarge");
            var btnEnviarge2 = document.getElementById("btnEnviarge2");
            var btnImprimir = document.getElementById("btnImprimir");

            function sendRequest(url, fecha_pedido) {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", url, true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {
                            alert(xhr.responseText);
                            window.location.href = "SOLICITUDES.php";
                        } else {
                            console.error("Error: " + xhr.status + " " + xhr.statusText);
                            alert("There was an error processing your request. Please try again.");
                        }
                    }
                };
                xhr.onerror = function() {
                    console.error("Request failed");
                    alert("Request failed. Please check your network connection and try again.");
                };
                xhr.send("accion=aceptar&fecha_pedido=" + encodeURIComponent(fecha_pedido));
            }

            if (btnEnviarge) {
                btnEnviarge.addEventListener("click", function() {
                    var fecha_pedido = "<?php echo isset($_GET['fecha_pedido']) ? $_GET['fecha_pedido'] : ''; ?>";
                    if (fecha_pedido) {
                        sendRequest("../PHP/ENVIARAGE.php", fecha_pedido);
                    } else {
                        console.error("No se proporcionó la fecha de pedido.");
                        alert("No se proporcionó la fecha de pedido.");
                    }
                });
            }

            if (btnEnviarge2) {
                btnEnviarge2.addEventListener("click", function() {
                    var fecha_pedido = "<?php echo isset($_GET['fecha_pedido']) ? $_GET['fecha_pedido'] : ''; ?>";
                    if (fecha_pedido) {
                        sendRequest("../PHP/ENVIARAGE2.php", fecha_pedido);
                    } else {
                        console.error("No se proporcionó la fecha de pedido.");
                        alert("No se proporcionó la fecha de pedido.");
                    }
                });
            }

            if (btnImprimir) {
                btnImprimir.addEventListener("click", function() {
                    window.print();
                });
            }
        });
    </script>
</head>
<body>
    <?php include '../HEADERS/NavBarMenuDETALLES.php'; ?>
    <br>
    <h2>Detalle de Solicitud de Materiales</h2>
    <?php
    if (isset($_GET['fecha_pedido'])) {
        $fecha_pedido = $_GET['fecha_pedido'];

        require_once("../PHP/CONN.php");

        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }

        $sql = "SELECT producto, cantidad, unidad, precio, historial, descuento, impuesto, estado, proveedor, fecha_pedido
                FROM pedidos
                WHERE fecha_pedido = '$fecha_pedido'";
        $resultado = $conexion->query($sql);

        $subtotal = 0;
        $estadoPedido = 0; // Estado inicial del pedido

        if ($resultado->num_rows > 0) {
            echo "<table class='printable-table'>";
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
            echo "<h1 class='printable-table'>Subtotal: <span style='float: right;'>" . number_format($subtotal, 2, '.', ',') . "</span></h1>";

            // Mostrar el botón según el estado del pedido
            if ($estadoPedido == 1) {
                echo "<div class='op non-printable'>";
                echo "<button class='aceptar' id='btnEnviarge'>ENVIAR A GERENTE</button>";
                echo "</div>";
            } elseif ($estadoPedido == 7) {
                echo "<div class='op non-printable'>";
                echo "<button class='aceptar' id='btnEnviarge2'>ENVIAR A GERENTE</button>";
                echo "</div>";
            } elseif ($estadoPedido == 3 || $estadoPedido == 8) {
                echo "<div class='op non-printable'>";
                echo "<h3 style='color:red;'>ESTA SOLICITUD AUN NO SE HA APROBADO</h3>";
                echo "</div>";
            } elseif ($estadoPedido == 4 || $estadoPedido == 9) {
                echo "<div class='op non-printable'>";
                echo "<button class='aceptar' id='btnImprimir'>IMPRIMIR</button>";
                echo "</div>";
            } elseif ($estadoPedido == 13) {
                echo "<div class='op non-printable'>";
                echo "<button class='aceptar' id='btnEnviarge'>ENVIAR A GERENTE</button>";
                echo "</div>";
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
    <a href="SOLICITUDES.php" class="btn non-printable">Volver a la lista de solicitudes</a>
</body>
</html>
