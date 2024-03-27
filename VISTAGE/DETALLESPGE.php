<?php   
    
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
<br>
<h2>Detalle de Solicitud de Materiales</h2>


<?php
if (isset($_GET['obra_id'])) {
    $obra_id = $_GET['obra_id'];

    require_once("../PHP/CONN.php");

    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    $sql = "SELECT producto, cantidad, unidad
            FROM pedidos
            WHERE obra_id = $obra_id";
    $resultado = $conexion->query($sql);

    if ($resultado->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr><th>Producto</th><th>Cantidad</th><th>Unidad</th></tr>";
        while ($fila = $resultado->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$fila['producto']."</td>";
            echo "<td>".$fila['cantidad']."</td>";
            echo "<td>".$fila['unidad']."</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<br>";
        echo "No se encontraron detalles de la solicitud de materiales para este id de obra.";
    }

    $conexion->close();
} else {
    echo "<br>";
    echo "El parámetro para busqueda no fue proporcionado.";
}


?>



<div class="op">
    <button class="aceptar" id="btnAceptarGE">ACEPTAR</button>
    <button class="rechazar" id="btnRechazarGE">RECHAZAR</button>
</div>

<script>
    document.getElementById("btnAceptarGE").addEventListener("click", function() {
        var obra_id = <?php echo isset($_GET['obra_id']) ? $_GET['obra_id'] : 'null'; ?>;
        
        if (obra_id) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "../PHP/ACEPTARGE.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    alert(xhr.responseText);
                    window.location.href = "PEDIDOSGE.php";
                }
            };
            xhr.send("accion=aceptar&obra_id=" + obra_id);
        } else {
            console.error("No se proporcionó el ID de la obra.");
        }
    });




    document.getElementById("btnRechazarGE").addEventListener("click", function() {
    var obra_id = <?php echo isset($_GET['obra_id']) ? $_GET['obra_id'] : 'null'; ?>;
    
    if (obra_id) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "../PHP/RECHAZARGE.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                alert(xhr.responseText);
                window.location.href = "PEDIDOSGE.php";
            }
        };
        xhr.send("accion=rechazar&obra_id=" + obra_id);
    } else {
        console.error("No se proporcionó el ID de la obra.");
    }
});




</script>


    <br>
    <br>
    <a href="PEDIDOSGE.php" class="btn">Volver a la lista de solicitudes</a>
</body>
</html>
