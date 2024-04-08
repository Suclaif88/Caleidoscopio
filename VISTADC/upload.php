<?php
require_once("../PHP/CONN.php");

// Verificar la conexión a la base de datos
if ($conexion->connect_error) {
    die("Connection failed: " . $conexion->connect_error);
}

// Manejar la carga del archivo
if ($_FILES["file"]["error"] == UPLOAD_ERR_OK) {
    // Obtener el contenido del archivo
    $file_content = file_get_contents($_FILES["file"]["tmp_name"]);
    
    // Preparar la consulta SQL
    $sql = "INSERT INTO archivos (contenido) VALUES (?)";
    $stmt = $conexion->prepare($sql);

    // Verificar si la consulta se preparó correctamente
    if ($stmt === false) {
        die("Error preparing statement: " . $conexion->error);
    }
    
    // Enlazar los parámetros y ejecutar la consulta
    $stmt->bind_param("s", $file_content);
    if ($stmt->execute()) {
        echo "File uploaded successfully and data inserted into database";
    } else {
        echo "Error inserting data into database: " . $stmt->error;
    }
} else {
    echo "Error uploading file". $_FILES["file"]["error"];
}

// Cerrar la conexión
$conexion->close();