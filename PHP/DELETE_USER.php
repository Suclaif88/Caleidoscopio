<?php

require_once("CONN.php");


$id=$_GET["id"];

$sql="DELETE FROM usuarios WHERE id='$id'";
$query = mysqli_query($conexion, $sql);

if($query){
    Header("Location: ../ADMIN/ADMIN.php");
}else{

}