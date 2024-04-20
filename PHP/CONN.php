<?php

$servidor = "ep-wandering-limit-a49gxudm.us-east-1.aws.neon.tech";
$puerto = "5432";
$dbname = "verceldb";
$usuario = "default";
$clave = "IiuFUMp6T1Px";
$sslmode = "require";

try {
    $conexion = new PDO("pgsql:host=$servidor;port=$puerto;dbname=$dbname;user=$usuario;password=$clave;sslmode=$sslmode");

    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $id = 1;
    $stmt = $conexion->prepare("SELECT * FROM tu_tabla WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "ID: " . $row['id'] . ", Columna: " . $row['columna'] . "<br>";
    }

    $conexion = null;

} catch(PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
} 