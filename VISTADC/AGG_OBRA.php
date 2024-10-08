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
    <title>Nueva Obra</title>
    <link rel="stylesheet" href="../CSS/CSSMP.css">
    <link rel="stylesheet" href="../CSS/CSSCO.css">
    <link rel="stylesheet" href="../CSS/responsive.css">
    <link rel="icon" type="image/png" href="../IMG/favicon.png">
</head>
<body>
    <header class="cabeza">
        <div class="navbar">
            <h1>Nueva Obra</h1>
            <ul>
                <li><a href="OBRAS.php">Atras</a></li>
            </ul>
        </div>
    </header>

    <div class="form">
        <form action="../PHP/AGGOBRA.php" method="post">
            <label for="nombre">Nombre:</label><br>
            <input type="text" id="nombre" name="nombre" required><br>
            <label for="descripcion">Descripción:</label><br>
            <input type="text" id="descripcion" name="descripcion" required><br>
            <label for="fecha_inicio">Fecha de Inicio:</label><br>
            <input type="date" id="fecha_inicio" name="fecha_inicio" required><br>
            <label for="presupuesto">Presupuesto:</label><br>
            <input type="number" id="presupuesto" name="presupuesto" step="0.01" required><br>
            <label for="nombre">Director de obra:</label><br>
            <input type="text" id="director_obra" name="director_de_obra" required><br>
            <button type="submit" class="btn" style="border: none;">Agregar Obra</button>
        </form>
    </div>
</body>
</html>
