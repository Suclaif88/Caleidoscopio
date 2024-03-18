<?php
$servidor="localhost";
$usuario="vale";
$clave="Salem31ob";
$bd="apes";

$conexion=mysqli_connect($servidor,$usuario,$clave,$bd);
if(!$conexion){
    die("error de conexion: ".mysqli_connect_error());
}
?>