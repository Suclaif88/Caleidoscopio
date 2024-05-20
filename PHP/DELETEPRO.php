<?php

require_once("CONN.php");


$id=$_GET["id"];

$sql="DELETE FROM proveedores WHERE id='$id'";
$query = mysqli_query($conexion, $sql);

if($query){
    Header("Location: ../VISTADC/MOD_PROVEEDOR.php");
}else{

}