<?php

$servidor = "ep-wandering-limit-a49gxudm.us-east-1.aws.neon.tech";
$puerto = "5432";
$dbname = "verceldb";
$usuario = "default";
$clave = "IiuFUMp6T1Px";
$sslmode = "require";

try {
    $conexion = new PDO("pgsql:host=$servidor;port=$puerto;dbname=$dbname;user=$usuario;password=$clave;sslmode=$sslmode");

    // Establecer el modo de error de PDO a excepción
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}