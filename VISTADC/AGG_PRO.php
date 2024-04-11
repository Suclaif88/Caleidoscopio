<?php
    require_once("../PHP/CONN.php");
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
    <title>Agregar Proveedores</title>
    <link rel="stylesheet" href="../CSS/CSSMP.css">
    <link rel="stylesheet" href="../CSS/CSSCO.css">
    <link rel="stylesheet" href="../CSS/responsive.css">
    <link rel="icon" type="image/png" href="../IMG/favicon.png">
</head>
<body>
    <header class="cabeza"> 
        <div class="navbar">
            <h1>AGREGAR</h1>
             <ul>
                <li><a href="COTIZACION.php">Atras</a></li>
            </ul>
            <ul>
                <li><a href="AGG_MA.php">Materiales</a></li>
                <li><b>/</b></li>
                <li><a href="AGG_PRO.php" style="color:white;">Proveedores</a></li>
            </ul>
           
        </div>
        
    </header>
    <form action="../PHP/AGGPRO.php" method="POST">
        <label for="nombre">Proveedor:</label>
        <input type="text" id="proveedor" name="proveedor" required><br>
        <label for="nit">Nit:</label>
        <input type="number" id="nit" name="nit" required><br>
        <label for="correo">Correo:</label>
        <input type="email" id="correo" name="correo" required><br>
        <label for="telefono">Telefono:</label>
        <input type="number" id="telefono" name="telefono" required><br>
        <input type="submit" class="btn" value="Agregar proveedor" style="width: 100%;">
    </form>
</body>
</html>