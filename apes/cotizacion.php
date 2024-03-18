<?php
$servidor="localhost";
$usuario="vale";
$clave="Salem31ob";
$bd="apes";

$conn = new mysqli($servidor, $usuario, $clave, $bd);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$resultados = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $busqueda = $_POST['busqueda'];

    // precio de menor a mayor
    $sql = "SELECT * FROM cotizaciones WHERE material = '$busqueda' OR proveedor ='$busqueda' or descripcion ='$busqueda' ORDER BY precio ASC"; 

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $resultados .= "<table border='1'>";
        $resultados .= "<tr><th>Material</th><th>Descripción</th><th>Unidad</th><th>Precio</th><th>Proveedor</th></tr>";
        while ($row = $result->fetch_assoc()) {
            $resultados .= "<tr>";
            $resultados .= "<td>" . $row["material"] . "</td>";
            $resultados .= "<td>" . $row["descripcion"] . "</td>";
            $resultados .= "<td>" . $row["unidad"] . "</td>";
            $resultados .= "<td>" . $row["precio"] . "</td>";
            $resultados .= "<td>" . $row["proveedor"] . "</td>";
            $resultados .= "</tr>";
        }
        $resultados .= "</table>";
    } else {
        $resultados = "No se encontró el material que buscas.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cotizaciones</title>
</head>
<body>
    <h1>Busqueda de materiales</h1>
<form action="" method="post" class="input-group">
    <input type="text" name="busqueda" placeholder="búsqueda de materiales" class="form-control">
    <div class="input-group-btn">
        <input type="submit" value="Buscar" class="btn ">
    </div>
    </form>
    <?php
    echo $resultados;
    ?>
<div>
    <a href="agrcot.php">agregar cotizaciones</a>
    <a href="inicio.html">Inicio</a>
</div>
</body>
</html>
