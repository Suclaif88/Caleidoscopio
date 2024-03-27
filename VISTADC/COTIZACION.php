<?php
require_once("../PHP/CONN.php");

$resultados = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $busqueda = $conexion->real_escape_string($_POST['busqueda']);

    $sql = "SELECT * FROM cotizaciones WHERE material LIKE '%$busqueda%' OR proveedor LIKE '%$busqueda%' OR descripcion LIKE '%$busqueda%' ORDER BY precio ASC"; 

    $result = $conexion->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
            $resultados .= "<table border='1'>";
            $resultados .= "<tr><th>Material</th><th>Descripción</th><th>Unidad</th><th>Precio</th><th>Proveedor</th></tr>";
            while ($row = $result->fetch_assoc()) {
                $resultados .= "<tr>";
                $resultados .= "<td>" . htmlspecialchars($row["material"]) . "</td>";
                $resultados .= "<td>" . htmlspecialchars($row["descripcion"]) . "</td>";
                $resultados .= "<td>" . htmlspecialchars($row["unidad"]) . "</td>";
                $resultados .= "<td>" . htmlspecialchars($row["precio"]) . "</td>";
                $resultados .= "<td>" . htmlspecialchars($row["proveedor"]) . "</td>";
                $resultados .= "</tr>";
            }
            $resultados .= "</table>";
        } else {
            $resultados = "No se encontraron resultados para la búsqueda.";
        }
    } else {
        $resultados = "Error al ejecutar la consulta.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cotizaciones</title>
    <link rel="stylesheet" href="../CSS/CSSCO.css">
    <link rel="stylesheet" href="../CSS/CSS.css">
    <link rel="stylesheet" href="../CSS/responsive.css">
    <link rel="icon" type="image/png" href="../IMG/favicon.png">
</head>

<body>

<div class="navbar">
    <h1 style="cursor:default;">COTIZACIONES</h1>
    <ul>
        <li><a href="COMPRA-MATERIALES.php">Compra de materiales</a></li>
        <li><a href="COMPRA-SIMPLE.php">Compra simple</a></li>
        <li><a href="OBRAS.php">Obras</a></li>
        <li><a href="" style="color:white;">Cotizaciones</a></li>
        <li><a href="DC.php">Atras</a></li>
    </ul>
</div>

<div class="form-container">
    <h1>Busqueda de materiales</h1>
    <form action="" method="post" class="input-group">
        <input type="text" name="busqueda" placeholder="Búsqueda de materiales" class="form-control">
        <div class="input-group-btn">
            <input type="submit" value="Buscar" class="btn2">
        </div>
    </form>
</div>

<div class="table-container">
    <?php echo $resultados; ?>
</div>

<div class="cont">
    <a href="AGREGARCO.php" class="div1 btn">Agregar cotizaciones</a>
</div>

</body>
</html>
