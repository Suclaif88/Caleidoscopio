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

    require_once("../PHP/CONN.php");
    if(!isset($_SESSION["nombre"])){
        header("Location:../INDEX.html");
        exit();
    }
    $usuario=$_SESSION["nombre"];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RESIDENTE DE OBRA</title>
    <link rel="stylesheet" href="../CSS/CSSDC.css">
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
        
        <button class="btn1 div1" onclick="window.location.href='SOLICITUD.php'">Solicitud de compra</button>
        <button class="btn1 div2" onclick="window.location.href='DEVOLUCIONES.php'">Solicitudes</button>
        <button class="btn1 div3" onclick="window.location.href='OBRASRE.php'">Obras</button>
        <button class="btn1 div4" onclick="window.location.href='../PHP/LOGOUT.php'">Cerrar Sesion</button>
    </div>
    
</body>
</html>