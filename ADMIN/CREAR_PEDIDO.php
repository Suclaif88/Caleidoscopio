<?php
session_start();

if(!isset($_SESSION["nombre"])){
    header("Location:../INDEX.html");
    exit();
}

if(strval($_SESSION["rol"]) !== "1") {
  header("Location: ../INDEX.html");
  exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/CSSDC.css">
    <link rel="stylesheet" href="../CSS/CSSAD.css">
    <link rel="stylesheet" href="../CSS/responsive.css">
    <link rel="icon" type="image/png" href="../IMG/favicon.png">
    <title>ADMIN</title>
</head>
<body>

<style>
        .checkbox-select {
            display: inline-block;
            position: relative;
        }

        .checkbox-select select {
            display: none;
        }

        .checkbox-select .options {
            display: none;
            position: absolute;
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 5px;
            overflow-y: auto;
            max-height: 150px;
            width: 100%;
        }

        .checkbox-select label {
            display: block;
            margin-bottom: 5px;
        }

        .checkbox-select .selected-option {
            cursor: pointer;
            padding: 5px;
            border: 1px solid #ccc;
            width: 100%;
        }
    </style>

<div class="users-form">
    <h1>Crear pedido</h1>
    <form action="../PHP/INSERTAR_PEDIDO.php" method="POST">
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
        </select>


        <input type="text" name="usuario" placeholder="Usuario" required>


        <div class="checkbox-select">
        <div class="selected-option" onclick="toggleOptions()">Seleccione Materiales</div>
        <div class="options">
            <?php
            require_once("../PHP/CONN.php");

            if ($conexion->connect_error) {
                die("Error de conexión: " . $conexion->connect_error);
            }

            $sql = "SELECT id, material FROM agregar_materiales";
            $resultado = $conexion->query($sql);

            if ($resultado->num_rows > 0) {
                while ($fila = $resultado->fetch_assoc()) {
                    echo '<label><input type="checkbox" name="materiales[]" value="'.$fila['id'].'">'.$fila['material'].'</label>';
                }
            } else {
                echo "<p>No hay materiales disponibles</p>";
            }
            ?>
        </div>
        </div>

    <script>
        function toggleOptions() {
            var options = document.querySelector('.checkbox-select .options');
            options.style.display = options.style.display === 'block' ? 'none' : 'block';
        }
    </script>






        <input type="text" name="precio" placeholder="Precio" required>
        <input type="text" name="cantidad" placeholder="Cantidad" required>
        <input type="text" name="unidad" placeholder="Unidad" required>
        <input type="hidden" name="fecha_pedido" value="<?= date('Y-m-d H:i:s') ?>">
        <input type="text" name="estado" placeholder="Estado" required>
        <input type="text" name="historial" placeholder="Historial" required>
        <input type="submit" value="Agregar">
    </form>
    <a href="PEDIDOSAD.php">ATRAS</a>
</div>
</body>
</html>