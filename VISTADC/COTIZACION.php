<?php

session_start();

if(!isset($_SESSION["nombre"])){
    header("Location:../INDEX.html");
    exit();
}

if(strval($_SESSION["rol"]) !== "3") {
  header("Location: ../INDEX.html");
  exit();
}


require_once("../PHP/CONN.php");

$resultados = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $busqueda = $conexion->real_escape_string($_POST['busqueda']);

    $sql = "SELECT * FROM cotizaciones WHERE producto LIKE '%$busqueda%' OR proveedor LIKE '%$busqueda%' OR descripcion LIKE '%$busqueda%' ORDER BY precio ASC"; 
    $result = $conexion->query($sql);

    $sql_materiales = "SELECT id FROM cotizaciones";
    $result_materiales = $conexion->query($sql_materiales);

    if ($result) {
        if ($result->num_rows > 0) {
            $resultados .= "<table border='1'>";
            $resultados .= "<tr><th>Material</th><th>Descripción</th><th>Unidad</th><th>Precio</th><th>Proveedor</th></tr>";
            while ($row = $result->fetch_assoc()) {
                $resultados .= "<tr>";
                $resultados .= "<td>" . htmlspecialchars($row["producto"]) . "</td>";
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
        <li><a href="OBRAS.php">Obras</a></li>
        <li><a href="" style="color:white;">Cotizaciones</a></li>
        <li><a href="DC.php">inicio</a></li>
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
    <a href="AGREGARCO.php"  class="div1 btn">Agregar cotizaciones</a>
</div>

<style>
    #formulario-container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 400px;
        margin-bottom: 20px;
    }

    form {
        width: 300px;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #f9f9f9;
        margin-left: auto;
        margin-right: auto;
    }

    label {
        display: block;
        margin-bottom: 10px;
    }

    select,
    input[type="number"],
    input[type="text"] {
        width: calc(100% - 24px);
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
    }

    input[type="submit"] {
        width: 100%;
        padding: 10px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        background-color: #0056b3;
    }
</style>


<div id="formulario-container">
<form action="../PHP/AGGMA.php" method="post">
    <?php
    require_once("../PHP/CONN.php");

    $sql = "SELECT `id`, `producto`, `descripcion`, `unidad`, `precio`, `proveedor` FROM `cotizaciones`";

    $result = $conexion->query($sql);

    echo "<label for='cotizacion'>Seleccionar Cotización:</label>";
    echo "<select name='cotizacion' id='cotizacion' required>";
    echo "<option value=''>Selecciona una cotización...</option>"; 
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['id'] . "'>" . $row['producto'] . " - " . $row['proveedor'] . "</option>";
        }
    } else {
        echo "<option value='' disabled>No se encontraron cotizaciones</option>";
    }
    echo "</select><br>";

    ?>

    <label for="cantidad">Cantidad:</label>
    <input type="number" name="cantidad" id="cantidad" required><br>

    <label for="unidad">Unidad:</label>
    <input type="text" name="unidad" id="unidad"><br>

    <label for="selectObra">Selecciona una obra:</label>
    <select name="selectObra" id="selectObra" required>
        <option value="">Selecciona una obra...</option>
        <?php
        require_once("../PHP/CONN.php");

        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }

        $sql = "SELECT DISTINCT pedidos.obra_id, obras.nombre, pedidos.estado
                FROM pedidos 
                LEFT JOIN obras ON pedidos.obra_id = obras.id
                WHERE pedidos.estado = '1'";
        $resultado = $conexion->query($sql);

        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                echo "<option value='" . $fila['obra_id'] . "'>" . $fila['nombre'] . "</option>";
            }
        } else {
            echo "<option value=''>No se encontraron obras.</option>";
        }

        $conexion->close();
        ?>
    </select>
    <input type="submit" value="ENVIAR" class="btn2">
</form>


</div>



</body>
</html>
