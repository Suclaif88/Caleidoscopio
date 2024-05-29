<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION["nombre"])) {
    header("Location:../INDEX.html");
    exit();
}
if (strval($_SESSION["rol"]) !== "5") {
    header("Location: ../INDEX.html");
    exit();
}

require_once("../PHP/CONN.php");

$nombre = $_SESSION["nombre"];
$query = "SELECT * FROM obras WHERE residente = (SELECT nombre FROM usuarios WHERE nombre = ?)";
$statement = $conexion->prepare($query);
if ($statement === false) {
    die('Error en la preparación de la consulta: ' . $conexion->error);
}
$statement->bind_param("s", $nombre);
$statement->execute();
$result = $statement->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Obras Residente</title>
    <link rel="stylesheet" href="../CSS/CSSCO.css">
    <link rel="stylesheet" href="../CSS/CSS.css">
    <link rel="stylesheet" href="../CSS/responsive.css">
    <link rel="icon" type="image/png" href="../IMG/favicon.png">
</head>
<body>
    <header class="navbar">
        <h1>OBRAS</h1>
        <ul>
            <li><a href="DEVOLUCIONES.php">Devoluciones</a></li>
            <li><a href="" style="color:white;">Obras</a></li>
            <li><a href="SOLICITUD.php">Solicitud de compra</a></li>
            <li><a href="RE.php">Atras</a></li>
        </ul>
    </header>

    <style>
        table {
            border-collapse: collapse;
            width: 60%;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #b1b1b1;
            cursor: default;
        }

        tr:nth-child(even) {
            background-color: #fff;
        }
    </style>

    <?php
    if ($result->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr><th>Nombre</th><th>Descripcion</th><th>Fecha Inicio</th><th>Presupuesto</th><th>Director de Obra</th><th>Residente</th></tr>";
        while ($fila = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($fila['nombre']) . "</td>";
            echo "<td>" . htmlspecialchars($fila['descripcion']) . "</td>";
            echo "<td>" . htmlspecialchars($fila['fecha_inicio']) . "</td>";
            echo "<td>" . htmlspecialchars($fila['presupuesto']) . "</td>";
            echo "<td>" . htmlspecialchars($fila['director_de_obra']) . "</td>";
            echo "<td>" . htmlspecialchars($fila['residente']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No se encontraron obras para este usuario.";
    }

    $statement->close();
    $conexion->close();
    ?>
</body>
</html>
