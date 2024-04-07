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

require_once("../PHP/CONN.php");

$id = $_POST['id'];

$sql = "SELECT * FROM pedidos WHERE id = '$id'";
$query = mysqli_query($conexion, $sql);

if($query) {
    $row = mysqli_fetch_array($query);
    
} else {
    echo "Error al obtener el pedido: " . mysqli_error($conexion);
}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../CSS/CSSDC.css">
        <link rel="stylesheet" href="../CSS/CSSAD.css">
        <link rel="stylesheet" href="../CSS/responsive.css">
        <link rel="icon" type="image/png" href="../IMG/favicon.png">
        <title>EDITAR USUARIO</title>
        <link rel="shortcut icon" href="../images/favicon.png" type="image/x-icon">
    </head>
    <style>
        * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

html {
    font-family: 'Segoe UI', sans-serif;
    text-align: center;
}

a{
    text-decoration: none;
}

.users-form form{
    display: flex;
    flex-direction: column;
    gap: 24px;
    width: 30%;
    margin: 20px auto;
    text-align: center;
}

.users-form form input{
    font-family: 'Segoe UI', sans-serif;
}

.users-form form input[type=text],
.users-form form input[type=password],
.users-form form input[type=email]{
    padding: 8px;
    border:2px solid #aaa;
    border-radius:4px;
    outline:none;
    transition:.3s;
}

.users-form form input[type=text]:focus,
.users-form form input[type=password]:focus,
.users-form form input[type=password]:focus{
    border-color:dodgerBlue;
    box-shadow:0 0 6px 0 dodgerBlue;
}

.users-form form input[type=submit]{
    border: none;
    padding: 12px 50px;
    text-decoration: none;
    transition-duration: 0.4s;
    cursor: pointer;
    border-radius: 5px;
    background-color: white; 
    color: black; 
    border: 2px solid #60a100;
}

.users-form form input[type=submit]:hover {
    background-color: #60a100;
    color: white;
}

.users-table table{
    border: 1px solid #ccc;
    border-collapse: collapse;
    margin: 0;
    padding: 0;
    width: 100%;
    table-layout: fixed;
}

table tr {
    background-color: #f8f8f8;
    border: 1px solid #ddd;
    padding: 4px;
}

table th{
    padding: 16px;
    text-align: center;
    font-size: .85em;
}

.users-table--edit{
    background: #009688;
    padding: 6px;
    color: #fff;
    text-align: center;
    font-weight: bold;
}
.users-table--delete{
    background: #b11e1e;
    padding: 6px;
    color: #fff;
    text-align: center;
    font-weight: bold;
}
</style>
    <body>
        <div class="users-form">

        <form action="../PHP/EDITAR_PEDIDO.php" method="POST">
    <input type="hidden" name="id" value="<?= $row['id'] ?>">
    
    <label for="obra_id">ID de la Obra:</label>
    <input type="text" id="obra_id" name="obra_id" placeholder="ID de la Obra" value="<?= $row['obra_id'] ?>" required>
    
    <label for="usuario">Usuario:</label>
    <input type="text" id="usuario" name="usuario" placeholder="Usuario" value="<?= $row['usuario'] ?>" required>
    
    <label for="producto">Producto:</label>
    <input type="text" id="producto" name="producto" placeholder="Producto" value="<?= $row['producto'] ?>" required>
    
    <label for="precio">Precio:</label>
    <input type="text" id="precio" name="precio" placeholder="Precio" value="<?= $row['precio'] ?>" required>
    
    <label for="cantidad">Cantidad:</label>
    <input type="text" id="cantidad" name="cantidad" placeholder="Cantidad" value="<?= $row['cantidad'] ?>" required>
    
    <label for="unidad">Unidad:</label>
    <input type="text" id="unidad" name="unidad" placeholder="Unidad" value="<?= $row['unidad'] ?>" required>
    
    <label for="fecha_pedido">Fecha del Pedido:</label>
    <input type="text" id="fecha_pedido" name="fecha_pedido" placeholder="Fecha del Pedido" value="<?= $row['fecha_pedido'] ?>" required>
    
    <label for="estado">Estado:</label>
    <input type="text" id="estado" name="estado" placeholder="Estado" value="<?= $row['estado'] ?>" required>
    
    <label for="historial">Historial:</label>
    <input type="text" id="historial" name="historial" placeholder="Historial" value="<?= $row['historial'] ?>" required>
    
    <input type="submit" value="ACTUALIZAR">
    <a href="PEDIDOSAD.php">ATRAS</a>
</form>


        </div>
    </body>
</html>