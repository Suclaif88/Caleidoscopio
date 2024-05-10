<?php

session_start();
    if(!isset($_SESSION["nombre"])){
        header("Location:../INDEX.html");
        exit();
    }
    if(strval($_SESSION["rol"]) !== "4") {
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
                    <a href="PEUR.php">
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
<h2>Detalle de Solicitud de Materiales Urgentes</h2>


<?php
if (isset($_GET['fecha_pedido'])) {
    $fecha_pedido = $_GET['fecha_pedido'];

    require_once("../PHP/CONN.php");

    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    $sql = "SELECT producto, cantidad, unidad, precio, historial, descuento, impuesto
            FROM pedidos
            WHERE fecha_pedido = '$fecha_pedido' AND estado = 6";
    $resultado = $conexion->query($sql);

    $subtotal = 0;

    if ($resultado->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr><th>Producto</th><th>Cantidad</th><th>Unidad</th><th>Precio Unitario</th><th>Descuento</th><th>Impuesto</th><th>Precio Total</th></tr>";
        while ($fila = $resultado->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$fila['producto']."</td>";
            echo "<td style='position: relative;'>".$fila['cantidad'];
            if ($fila['historial'] == 3) {
                echo "<span class='editado fa fa-exclamation-circle' title='Editado' style='position: absolute; top: 15px; right: -10px;'></span>";
            }
            echo "</td>";
            echo "<td>".$fila['unidad']."</td>";
            echo "<td>".$fila['precio']."</td>";
            echo "<td>".$fila['descuento']."</td>";
            echo "<td>".$fila['impuesto']."</td>";
            $precio_total = $fila['cantidad'] * ($fila['precio']-($fila['precio']*($fila['descuento']/100))+(($fila['precio']*($fila['descuento']/100))*($fila['impuesto']/100))) ;
            echo "<td>".$precio_total."</td>";
            $subtotal += $precio_total;
            echo "<td><button class='editar fa fa-pencil-square-o fa-2x' data-id='".$fila['id']."' style='background-color:#d6941a; cursor:pointer;'></button></td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "<br>";
        echo "<h1>Subtotal: <span style='float: right;'>" . number_format($subtotal, 2, '.', ',') . "</span></h1>";
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



<div class="op">
    <button class="aceptar" id="btnAceptar">ACEPTAR</button>
    <button class="rechazar" id="btnRechazar">RECHAZAR</button>
</div>
<div class="op">
<button class="esv" id="btnEnviadoSinVerificacion">ENVIAR SIN VERIFICACION</button>
</div>

<script>
    document.getElementById("btnAceptar").addEventListener("click", function() {
        var fecha_pedido = "<?php echo isset($_GET['fecha_pedido']) ? $_GET['fecha_pedido'] : ''; ?>";
        
        if (fecha_pedido) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "../PHP/ACEPTARUR.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    alert(xhr.responseText);
                    window.location.href = "PEUR.php";
                }
            };
            xhr.send("accion=aceptar&fecha_pedido=" + fecha_pedido);
        } else {
            console.error("No se proporcionó la fecha de pedido.");
        }
    });

    document.getElementById("btnRechazar").addEventListener("click", function() {
        var fecha_pedido = "<?php echo isset($_GET['fecha_pedido']) ? $_GET['fecha_pedido'] : ''; ?>";
        
        if (fecha_pedido) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "../PHP/RECHAZARUR.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    alert(xhr.responseText);
                    window.location.href = "PEUR.php";
                }
            };
            xhr.send("accion=rechazar&fecha_pedido=" + fecha_pedido);
        } else {
            console.error("No se proporcionó la fecha de pedido.");
        }
    });

    document.getElementById("btnEnviadoSinVerificacion").addEventListener("click", function() {
    if (confirm("¿Está seguro de que desea enviar sin verificacion?")) {
        var fecha_pedido = "<?php echo isset($_GET['fecha_pedido']) ? $_GET['fecha_pedido'] : ''; ?>";
        if (fecha_pedido) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "../PHP/ENVIADO_SIN_VERIFICACION3.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    alert(xhr.responseText);
                    window.location.href = "PEUR.php";
                }
            };
            xhr.send("accion=enviado_sin_verificacion&fecha_pedido=" + fecha_pedido);
        } else {
            console.error("No se proporcionó la fecha de pedido.");
        }
    }
});



    document.querySelectorAll('.editar').forEach(button => {
    button.addEventListener('click', function() {
        const pedidoId = this.dataset.id;
        const nuevaCantidad = prompt("Introduce la nueva cantidad:");

        if (nuevaCantidad !== null && nuevaCantidad !== '') {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "../PHP/EDITAR_CANTIDAD.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    alert(response.message);
                    if (response.success) {
                        location.reload();
                    }
                }
            };
            xhr.send("pedido_id=" + pedidoId + "&nueva_cantidad=" + nuevaCantidad);
        }
    });
});
</script>

    <br>
    <br>
    <a href="PEUR.php" class="btn">Volver a la lista de solicitudes</a>
</body>
</html>
