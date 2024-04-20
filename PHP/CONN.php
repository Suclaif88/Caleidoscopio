<?php

$servidor="localhost";
$usuario="root";
$clave="";
$db="apes";

$conexion=mysqli_connect($servidor,$usuario,$clave,$db);

if(!$conexion){
    die("error de conexion: ".mysqli_connect_error());
}