<?php
session_start();

if (!isset($_SESSION["nombre"]) || strval($_SESSION["rol"]) !== "3") {
    header("Location: ../INDEX.html");
    exit();
}

require_once("../PHP/CONN.php");

$response = [];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['busqueda'])) {
    $busqueda = $conexion->real_escape_string($_POST['busqueda']);
    $sql = "SELECT * FROM cotizaciones WHERE material LIKE '%$busqueda%' OR descripcion LIKE '%$busqueda%' ORDER BY precio ASC";
    $result = $conexion->query($sql);

    if ($result && $result->num_rows > 0) {
        $resultados = "<table border='1'>";
        $resultados .= "<h1>RESULTADOS DE BUSQUEDA</h1>";
        $resultados .= "<tr><th>Material</th><th>Descripción</th><th>Unidad</th><th>Precio</th><th>Descuento</th><th>Impuesto</th><th>Proveedor</th><th>Accion</th></tr>";
        while ($row = $result->fetch_assoc()) {
            $resultados .= "<tr>";
            $resultados .= "<td>" . htmlspecialchars($row["material"]) . "</td>";
            $resultados .= "<td>" . htmlspecialchars($row["descripcion"]) . "</td>";
            $resultados .= "<td>" . htmlspecialchars($row["unidad"]) . "</td>";
            $resultados .= "<td>" . htmlspecialchars($row["precio"]) . "</td>";
            $resultados .= "<td>" . htmlspecialchars($row["descuento"]) . "</td>";
            $resultados .= "<td>" . htmlspecialchars($row["impuesto"]) . "</td>";
            $resultados .= "<td>" . htmlspecialchars($row["proveedor"]) . "</td>";
            $resultados .= "<td><button class='seleccionar' onclick='seleccionar(this, " . htmlspecialchars($row["id"]) . ", " . json_encode($row["proveedor"]) . ")' style='color:#000000; border:2px solid black; box-sizing: border-box; background: #f0c760; background-image: -webkit-linear-gradient(top, #f0c760, #d6941a); background-image: -moz-linear-gradient(top, #f0c760, #d6941a); background-image: -ms-linear-gradient(top, #f0c760, #d6941a); background-image: -o-linear-gradient(top, #f0c760, #d6941a); background-image: linear-gradient(to bottom, #f0c760, #d6941a); transition: background-color 0.3s, border-color 0.3s, color 0.3s;' onmouseover='this.style.backgroundColor=\"#777777\"; this.style.borderColor=\"#000000\"; this.style.color=\"#fff\";' onmouseout='this.style.backgroundColor=\"#f0c760\"; this.style.borderColor=\"#000000\"; this.style.color=\"#000000\";'>Seleccionar</button></td>";
            $resultados .= "</tr>";
        }
        $resultados .= "</table>";

        $response['resultados'] = $resultados;

    } else {
        $response['mensaje'] = "Sin resultados";
    }

    echo json_encode($response);
}

$cotizacion = "<table border='1' id='cotizacion' class='styled-table'>
                        <thead>
                            <tr>
                                <th style='background-color: #E6BA49;'>Material</th>
                                <th style='background-color: #E6BA49;'>Descripción</th>
                                <th style='background-color: #E6BA49;'>Unidad</th>
                                <th style='background-color: #E6BA49;'>Precio</th>
                                <th style='background-color: #E6BA49;'>Descuento</th>
                                <th style='background-color: #E6BA49;'>Impuesto</th>
                                <th style='background-color: #E6BA49;'>Proveedor</th>
                                <th style='background-color: #E6BA49;'>Acción</th>
                            </tr>
                        </thead>
                        <tbody>";


                        