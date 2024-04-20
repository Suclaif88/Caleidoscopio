<?php

try {
    // Cadena de conexión URI para PostgreSQL
    $dsn = "pgsql:host=ep-wandering-limit-a49gxudm.us-east-1.aws.neon.tech;port=5432;dbname=verceldb;user=default;password=IiuFUMp6T1Px;sslmode=require";

    // Crear una nueva instancia de PDO
    $conexion = new PDO($dsn);

    // Establecer el modo de error de PDO a excepción
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Conexión exitosa";
} catch(PDOException $e) {
    // Manejo de errores
    die("Error de conexión: " . $e->getMessage());
}
