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
    <title>Agregar Material</title>
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
                <li><a href="AGG_MA.php" style="color:white;">Materiales</a></li>
                <li><b>/</b></li>
                <li><a href="AGG_PRO.php">Proveedores</a></li>
            </ul>
           
        </div>
        
    </header>

    <form action="../PHP/AGGMA.php" method="POST">
        <label for="material">Material:</label>
        <input type="text" id="material" name="material" required><br>
        <label for="unidad">Unidad de medida:</label>
        <input type="text" id="nombre" name="unidad" required><br>
        <label for="descripcion">Descripción:</label>
        <input type="text" id="descripcion" name="descripcion" required><br>
        <input type="submit" class="btn" value="Agregar material" style="width: 100%;"><br>
    </form>
</body>
</html>