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
    
    $usuario=$_SESSION["nombre"];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DIRECTOR-COMPRAS</title>
    <link rel="stylesheet" href="../CSS/CSSDC.css">
    <link rel="stylesheet" href="../CSS/responsive.css">
    <link rel="icon" type="image/png" href="../IMG/favicon.png">
</head>
<header class="cabeza"><h1>BIENVENIDO, <?php echo $usuario?></h1></header>
<body>
    <div class="title">
       <h1>¿En que trabajaremos hoy?</h1>
    </div>
    <br>
    <div class="botones">
        <button class="btn1 div1" onclick="window.location.href='COMPRA-MATERIALES.php'">Compra de Materiales</button>
        <button class="btn1 div2" onclick="window.location.href='OBRAS.php'">Obras</button>
        <button class="btn1 div3" onclick="window.location.href='COTIZACION.php'">Cotizaciones</button>
        <button class="btn1 div4" onclick="window.location.href='../PHP/LOGOUT.php'">Cerrar Sesion</button>
    </div>

<br>
<br>
<br>
<br>
<br>
<br>

    






</body>
</html>