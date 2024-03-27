<?php
require_once("CONN.php");

$id=$_POST["id"];
$identificacion = $_POST['identificacion'];
$nombre = $_POST['nombre'];
$correo = $_POST['email'];
$contrasena = $_POST['contrasena'];
$rol = $_POST['rol'];

$sql="UPDATE usuarios SET identificacion='$identificacion', nombre='$nombre',email='$correo',contrasena='$contrasena', rol='$rol' WHERE id='$id'";


$query = mysqli_query($conexion, $sql);

if($query){
    Header("Location: ../ADMIN/ADMIN.php");
}else{
    echo "<script>alert('Error en la consulta preparada');</script>";
    echo "<script>window.location.href='update.php';</script>";
}