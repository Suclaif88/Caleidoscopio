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
        <select id="material" name="material" required>
        <option value="">Seleccione un material</option>
            <?php

            require_once("../PHP/CONN.php");

            if ($conexion->connect_error) {
                die("Error de conexión: " . $conexion->connect_error);
            }

            $sql = "SELECT id, material FROM agregar_materiales";
            $resultado = $conexion->query($sql);

            if ($resultado->num_rows > 0) {
                while ($fila = $resultado->fetch_assoc()) {
                    echo "<option value='".$fila['id']."'>".$fila['material']."</option>";
                }
            } else {
                echo "<option value=''>No hay obras disponibles</option>";
            }

            ?>
        </select>
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