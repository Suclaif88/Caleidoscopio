<?php
    require_once("../PHP/CONN.php");
    session_start();//inicie la sesion
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
        
        <button class="btn div1" onclick="window.location.href='SOLICITUD.php'">Solicitud de compra</button>
        <button class="btn div2" onclick="window.location.href='#'">devoluciones</button>
        <button class="btn div3" onclick="window.location.href='#'">Obras</button>
        <button class="btn div4" onclick="window.location.href='../PHP/LOGOUT.php'">Inicio</button>
    </div>
    
</body>
</html>