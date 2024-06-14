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

    $id_obra = $_GET['id'];

    $sql = "SELECT * FROM obras WHERE id = $id_obra";
    $resultado = $conexion->query($sql);
    $obra = $resultado->fetch_assoc();

    $estados = array(
        0 => "Pendiente de aprobacion por director de obra",
        1 => "Pendiente de envio a gerente",
        2 => "Rechazado por director de obra",
        3 => "Pendiente de aprobacion por gerencia",
        4 => "Aprobado por gerencia",
        5 => "Rechazado por Gerencia",
        6 => "Urgente, Pendiente por aprobacion de director de obra",
        7 => "Urgente, Aceptado por director de obra",
        8 => "Urgente, Pendiente de aprobacion por gerencia", 
        9 => "Urgente, Aprobado por gerencia",
        10 => "Urgente, Rechazado",
        11 => "Aprobado por director de obra sin verificar",
        12 => "Aprobado por sin verificar por director de obra y gerente",
        13 => "Aprobado y verificado por gerencia",
        14 => "Urgente, Aprobado sin verificar por director de obra",
        15 => "Urgente, Aprobado sin verificar por director de obra y gerente",
        16 => "Urgente, Aprobado y verificado por gerente",
    );

?>

<!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Detalle de la Obra</title>
        <link rel="stylesheet" href="../CSS/CSSCO.css">
        <link rel="stylesheet" href="../CSS/CSS.css">
        <link rel="stylesheet" href="../CSS/responsive.css">
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
        </style>
    </head>
    <body>
        
        <div class="navbar">
            <ul>
                <p style="font-size: 60px; cursor:default;"> <?php echo $obra['nombre']?></p>
            </ul>
            <br>
            <h3 style="cursor:default;">Detalles de la Obra</h3>
        </div>

        <?php   

            $sql = "SELECT * FROM obras WHERE id = $id_obra";
            $resultado = $conexion->query($sql);

            if ($resultado->num_rows > 0) {
                $obra = $resultado->fetch_assoc();
                echo "<table>";
                echo "<tr><th>Nombre</th><td>".$obra['nombre']."</td></tr>";
                echo "<tr><th>Descripción</th><td>".$obra['descripcion']."</td></tr>";
                echo "<tr><th>Fecha de Inicio</th><td>".$obra['fecha_inicio']."</td></tr>";
                echo "<tr><th>Presupuesto</th><td>".$obra['presupuesto']."</td></tr>";
                echo "<tr><th>Director de Obra</th><td>".$obra['director_de_obra']."</td></tr>";
                echo "</table>";
            } else {
                echo "No se encontró la obra.";
            }


        ?>
        <h1>Solicitudes</h1>
        <table>
            <tr>
                <th>Nombre</th>
                <th>Fecha Pedido</th>
                <th>Estado</th>
            </tr>

            <?php
        
                require_once("../PHP/CONN.php");

                if ($conexion->connect_error) {
                    die("Error de conexión: " . $conexion->connect_error);
                }

                    $sql2 = "SELECT id, usuario, fecha_pedido, estado, obra_id
                        FROM pedidos
                        WHERE obra_id = $id_obra
                        ORDER BY fecha_pedido;";


                    $resultado2 = $conexion->query($sql2);

                    if ($resultado2->num_rows > 0) {
                    while ($fila = $resultado2->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td><a href='DETALLESSO.php?fecha_pedido=".$fila['fecha_pedido']."'>".$fila['usuario']."</a></td>";
                        echo "<td>".$fila['fecha_pedido']."</td>";
                        echo "<td>".$estados[$fila['estado']]."</td>";
                        echo "</tr>";
                    }
                    } else {
                    echo "<tr><td colspan='4'>No se encontraron pedidos.</td></tr>";
                    }

            ?>
        </table>
        <br>
        <a href="OBRAS.php" class="btn">Volver a la lista de obras</a>
    </body>
</html>
