<?php
    require_once("../PHP/CONN.php");
    session_start();
    if(!isset($_SESSION["nombre"])){
        header("Location:../DC.php");
        exit();
    }
    $usuario=$_SESSION["nombre"];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DIRECTOR-COMPRAS</title>
    <link rel="stylesheet" href="../CSS/CSS.css">
    <link rel="stylesheet" href="../CSS/responsive.css">
    <link rel="icon" type="image/png" href="../IMG/favicon.png">
</head>
<header class="cabeza"><h1>BIENVENIDO, <?php echo $usuario?></h1></header>
<body>
    <center>
       <h1>¿En que trabajaremos hoy?</h1>
    </center>
    <br>
    <div class="botones">
        
        <button class="btn div1" onclick="window.location.href='compra_simple.php'">Compra Simple</button>
        <button class="btn div2" onclick="window.location.href='compra_materiales.php'">Compra de Materiales</button>
        <button class="btn div3" onclick="window.location.href='obras.php'">Obras</button>
        <button class="btn div4" onclick="window.location.href='COTIZACION.php'">Cotizaciones</button>
    </div>
    
</body>
</html>