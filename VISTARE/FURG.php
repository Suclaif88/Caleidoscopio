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
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Solicitud de Materiales</title>
    <link rel="stylesheet" href="../CSS/CSSCO.css">
    <link rel="stylesheet" href="../CSS/CSS.css">
    <link rel="stylesheet" href="../CSS/responsive.css">
    <link rel="icon" type="image/png" href="../IMG/favicon.png">
</head>
<body>
<style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px 0;
        }

        form {
            max-width: 600px;
            margin: 5vh;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
            margin-top: 20px;
            background-color: #ccc;
        }

        form label {
            font-weight: bold;
        }

        form select, form input[type="text"], form input[type="number"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
        }
        h3{
            text-align:center;
        }
    </style>
    <header class="navbar">
        <h1>Solicitud de Emergencia</h1>
        <ul>
            <li><a href="SOLICITUD.php">Atras</a></li>
        </ul>
    </header>
    
    <form action="../PHP/AGGSOUR.php" method="post">
        <label for="usuario">Nombre de Usuario:</label>
        <input type="text" id="usuario" name="usuario" required>
        
        <label for="obra">Obra:</label>
        <select id="obra" name="obra_id" required>
            <option value="">Seleccione una obra</option>
            <?php

            require_once("../PHP/CONN.php");

            if ($conexion->connect_error) {
                die("Error de conexión: " . $conexion->connect_error);
            }

            $sql = "SELECT id, nombre FROM obras";
            $resultado = $conexion->query($sql);

            if ($resultado->num_rows > 0) {
                while ($fila = $resultado->fetch_assoc()) {
                    echo "<option value='".$fila['id']."'>".$fila['nombre']."</option>";
                }
            } else {
                echo "<option value=''>No hay obras disponibles</option>";
            }

            ?>
        </select><br><br>
        <div id="productos">
            <div>
            <h3>Material 1</h3>
                <label for="producto">Material:</label>
                <select name="material_id[]" required>
            <?php
            $consulta = "SELECT id, material FROM agregar_materiales";
            $resultado = mysqli_query($conexion, $consulta);
            while ($fila = mysqli_fetch_assoc($resultado)) {
                echo "<option value='" . $fila['id'] . "'>" . $fila['material'] . "</option>";
            }
            
            ?>
                </select>
                <label for="cantidad">Cantidad:</label>
                <input type="number" name="cantidad[]" required>
                <label for="unidad">Unidad:</label>
                <input type="text" name="unidad[]" required>
            </div>
        </div>
        <div id="productos">
            <div>
                <h3>Material 2</h3>
                <label for="producto">Material:</label>
                <select name="material_id[]" required>
            <?php
            $consulta = "SELECT id, material FROM agregar_materiales";
            $resultado = mysqli_query($conexion, $consulta);
            while ($fila = mysqli_fetch_assoc($resultado)) {
                echo "<option value='" . $fila['id'] . "'>" . $fila['material'] . "</option>";
            }
            
            ?>
                </select>
                <label for="cantidad">Cantidad:</label>
                <input type="number" name="cantidad[]" required>
                <label for="unidad">Unidad:</label>
                <input type="text" name="unidad[]" required>
            </div>
            <button style="background-color: #d6941a; border-radius: 15px; cursor:pointer;" type="button" onclick="eliminarProducto(this)">Eliminar material</button>
        </div>
        <div id="productos">
            <h3>Material 3</h3>
            <div>

                <label for="producto">Material:</label>
                <select name="material_id[]" required>
            <?php
            $consulta = "SELECT id, material FROM agregar_materiales";
            $resultado = mysqli_query($conexion, $consulta);
            while ($fila = mysqli_fetch_assoc($resultado)) {
                echo "<option value='" . $fila['id'] . "'>" . $fila['material'] . "</option>";
            }
            
            ?>
                </select>
                <label for="cantidad">Cantidad:</label>
                <input type="number" name="cantidad[]" required>
                <label for="unidad">Unidad:</label>
                <input type="text" name="unidad[]" required>
            </div>
            <button style="background-color: #d6941a; border-radius: 15px; cursor:pointer;" type="button" onclick="eliminarProducto(this)">Eliminar material</button>
        </div>
        <br>
        <div style="margin: 5vh;">
            <button class="btn" style="background-color: #d6941a; border-radius: 15px; width: 100%; cursor:pointer;" type="submit">Enviar Solicitud</button>
        </div>   
   </form>

    
    <script>

        function eliminarProducto(elemento) {
            elemento.parentNode.parentNode.removeChild(elemento.parentNode);
        }
    </script>
</body>
</html>
