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

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Precio de Material</title>
    <link rel="stylesheet" href="../CSS/CSSMP.css">
    <link rel="stylesheet" href="../CSS/CSSCO.css">
    <link rel="stylesheet" href="../CSS/responsive.css">
    <link rel="icon" type="image/png" href="IMG/favicon.png">
</head>
<body>
    <div class="cabeza">
        <header class="navbar">
                <h1>Modificar Precio de Material</h1>
                <ul>
                    <li><a href="COTIZACION.php">Atras</a></li>
                </ul>
        </header>
    </div>

    <form action="../PHP/EDIT_PRECIO.php" method="post">
        <label for="material">Seleccione el material:</label>
        <select name="material" id="material">
            <?php
                require_once "../PHP/CONN.php";
                $consulta = "SELECT id, material FROM agregar_materiales";
                $resultado = mysqli_query($conexion, $consulta);
                while ($fila = mysqli_fetch_assoc($resultado)) {
                    echo "<option value='" . $fila['material'] . "'>" . $fila['material'] . "</option>";
                }
            ?>
        </select><br><br>

        <label for="proveedor">Seleccione el proveedor:</label>
        <select name="proveedor" id="proveedor">
            <?php
                $consulta = "SELECT id, proveedor FROM proveedores";
                $resultado = mysqli_query($conexion, $consulta);
                while ($fila = mysqli_fetch_assoc($resultado)) {
                    echo "<option value='" . $fila['proveedor'] . "'>" . $fila['proveedor'] . "</option>";
                }

                $conexion->close();
            ?>
        </select><br><br>

        <label for="nuevo_precio">Nuevo precio:</label>
        <input type="number" name="nuevo_precio" id="nuevo_precio"><br><br>
        <button type="submit" class="btn">Modificar Precio</button>
    </form>
</body>
</html>
