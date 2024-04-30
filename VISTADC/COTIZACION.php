<?php
session_start();

if (!isset($_SESSION["nombre"]) || strval($_SESSION["rol"]) !== "3") {
    header("Location: ../INDEX.html");
    exit();
}

require_once("../PHP/CONN.php");

$resultados = "";
$seleccionados = []; // Array para almacenar los elementos seleccionados

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['busqueda'])) {
    $busqueda = $conexion->real_escape_string($_POST['busqueda']);
    $sql = "SELECT * FROM cotizaciones WHERE material LIKE '%$busqueda%' OR descripcion LIKE '%$busqueda%' ORDER BY precio ASC";
    $result = $conexion->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
            $resultados .= "<table border='1'>";
            $resultados .= "<tr><th>Material</th><th>Descripción</th><th>Unidad</th><th>Precio</th><th>Descuento</th><th>Impuesto</th><th>Proveedor</th><th>Accion</th></tr>";
            while ($row = $result->fetch_assoc()) {
                $resultados .= "<tr>";
                $resultados .= "<td>" . htmlspecialchars($row["material"]) . "</td>";
                $resultados .= "<td>" . htmlspecialchars($row["descripcion"]) . "</td>";
                $resultados .= "<td>" . htmlspecialchars($row["unidad"]) . "</td>";
                $resultados .= "<td>" . htmlspecialchars($row["precio"]) . "</td>";
                $resultados .= "<td>" . htmlspecialchars($row["descuento"]) . "</td>";
                $resultados .= "<td>" . htmlspecialchars($row["impuestos"]) . "</td>";
                $resultados .= "<td>" . htmlspecialchars($row["proveedor"]) . "</td>";
                $resultados .= "<td><button class='seleccionar' onclick='seleccionar(this)' style='
                color:#000000; 
                border:2px solid black;
                box-sizing: border-box;
                background: #f0c760;
                background-image: -webkit-linear-gradient(top, #f0c760, #d6941a);
                background-image: -moz-linear-gradient(top, #f0c760, #d6941a);
                background-image: -ms-linear-gradient(top, #f0c760, #d6941a);
                background-image: -o-linear-gradient(top, #f0c760, #d6941a);
                background-image: linear-gradient(to bottom, #f0c760, #d6941a);
                transition: background-color 0.3s, border-color 0.3s, color 0.3s;
                ' 
                onmouseover='this.style.backgroundColor=\"#777777\"; this.style.borderColor=\"#000000\"; this.style.color=\"#fff\";' 
                onmouseout='this.style.backgroundColor=\"#f0c760\"; this.style.borderColor=\"#000000\"; this.style.color=\"#000000\";'>Seleccionar</button></td>";


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

$tablaSeleccionados = "<table border='1' id='tablaSeleccionados' class='styled-table'>
                        <thead>
                            <tr>
                                <th>Material</th>
                                <th>Descripción</th>
                                <th>Unidad</th>
                                <th>Precio</th>
                                <th>Descuento</th>
                                <th>Impuesto</th>
                                <th>Proveedor</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>";

$tablaSeleccionados .= "</tbody></table>";

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cotizaciones</title>
    <link rel="stylesheet" href="../CSS/CSSCO.css">
    <link rel="stylesheet" href="../CSS/CSS.css">
    <link rel="stylesheet" href="../CSS/COT.css">
    <link rel="stylesheet" href="../CSS/responsive.css">
    <link rel="icon" type="image/png" href="../IMG/favicon.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    
    <style>
        #formulario-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100px;
            margin-bottom: 20px;
        }

        form {
            width: 99%;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
            margin-left: auto;
            margin-right: auto;
        }
        .parent{
            display: flex;
            gap: 10px;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        select,
        input[type="number"],
        input[type="text"] {
            width: calc(100% - 0px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            color: black;
            border: black 2px solid;
            border-radius: 5px;
            cursor: pointer;
            background: #f0c760;
            background-image: -webkit-linear-gradient(top, #f0c760, #d6941a);
            background-image: -moz-linear-gradient(top, #f0c760, #d6941a);
            background-image: -ms-linear-gradient(top, #f0c760, #d6941a);
            background-image: -o-linear-gradient(top, #f0c760, #d6941a);
            background-image: linear-gradient(to bottom, #f0c760, #d6941a);
        }

        input[type="submit"]:hover {
            background: #777777;
            background-image: -webkit-linear-gradient(top, #777777, #000000);
            background-image: -moz-linear-gradient(top, #777777, #000000);
            background-image: -ms-linear-gradient(top, #777777, #000000);
            background-image: -o-linear-gradient(top, #777777, #000000);
            background-image: linear-gradient(to bottom, #777777, #000000);
            text-decoration: none;
        }
        .container {
            width: 100%; 
            max-width: 900px; 
            margin: 0 auto; 
            display: grid;
            grid-template-columns: 1fr;
            grid-gap: 20px;
            margin-top: 20px;
        }

        .container form {
            width: 100%; 
        }

        .container form table {
            width: 100%; 
            max-width: 800px; 
            margin: 0 auto; 
            table-layout: auto;
        }

        .container form table th,
        .container form table td {
            padding: 8px; 
            white-space: nowrap; 
            overflow: hidden; 
            text-overflow: ellipsis;
        }

        .container form table th {
            background-color: #f0f0f0; 
        }
        .t{
            width: 100%;
            margin-top:5vh;
        }

        .input-group-item textarea[name="descripcion[]"] {
        width: calc(100% - 20px);
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
        overflow: auto;
        }

    </style>
</head>

<body>
    <div class="navbar">
        <h1 style="cursor:default;">COTIZACIONES</h1>
        <ul>
            <li><a href="SOLICITUDES.php">Solicitud</a></li>
            <li><a href="OBRAS.php">Obras</a></li>
            <li><a href="" style="color:white;">Cotizaciones</a></li>
            <li><a href="DC.php">Inicio</a></li>
        </ul>
    </div>
<!-- busqueda de materiales -->
<div class="form-container">
    <h1>Búsqueda de materiales</h1>
    <form action="" method="post" class="input-group">
        <input type="text" name="busqueda" placeholder="Búsqueda de materiales" class="form-control">
        <div class="input-group-btn">
            <input type="submit" value="Buscar" class="btn2">
        </div>
    </form>
</div>

<div class="table-container">
    <?php if (!empty($resultados)) : ?>
        <?php echo $resultados; ?>
        <!-- Agregar el botón para borrar los resultados -->
        <form action="" method="post" class="input-group">
            <input type="submit" name="borrar_resultados" value="Borrar resultados" class="btn2">
        </form>
    <?php else : ?>
        
    <?php endif; ?>
</div>



<!--COTIZACION-->



<div class="container">
    <h1>Agregar cotización</h1>
    <form action="../PHP/AGGCO.php" method="post" id="formulario">
        <!-- Campos de Material, Unidad, Precio, Descuento, Impuesto, Proveedor -->
        <div class="input-group">
            <!-- Campo de Material -->
            <div class="input-group-item">
                <label for="material">Material:</label>
                <select name="material_id[]" required>
                    <option value="">Seleccione un material</option>
                    <?php
                    $consulta = "SELECT id, material FROM agregar_materiales";
                    $resultado = mysqli_query($conexion, $consulta);
                        while ($fila = mysqli_fetch_assoc($resultado)) {
                        echo "<option value='" . $fila['material'] . "'>" . $fila['material'] . "</option>";
                    }
                    ?>
                </select>


            </div>
            <!-- Campo de Unidad -->
            <div class="input-group-item">
                <label for="unidad">Unidad:</label>
                <input type="text" name="unidad[]" required>
            </div>
            <!-- Campo de Precio -->
            <div class="input-group-item">
                <label for="precio">Precio:</label>
                <input type="number" name="precio[]" required>
            </div>
            <!-- Campo de Descuento -->
            <div class="input-group-item">
                <label for="descuento">Descuento:</label>
                <input type="number" name="descuento[]" required>
            </div>
            <!-- Campo de Impuesto -->
            <div class="input-group-item">
                <label for="impuesto">Impuesto:</label>
                <input type="number" name="impuesto[]" required>
            </div>
            <!-- Campo de Proveedor -->
            <div class="input-group-item">
                <label for="proveedor">Proveedor:</label>
                <select name="proveedor_id[]" required>
                <option value="">Seleccione un proveedor</option>
                <?php
                    $consulta = "SELECT id, proveedor FROM proveedores";
                    $resultado = mysqli_query($conexion, $consulta);
                        while ($fila = mysqli_fetch_assoc($resultado)) {
                        echo "<option value='" . $fila['proveedor'] . "'>" . $fila['proveedor'] . "</option>";
                    }
                ?>
                </select>

            </div>
        </div>

        <!-- Campo de Descripción -->
        <div class="input-group">
            <div class="input-group-item">
                <label for="descripcion">Descripción:</label>
                <textarea name="descripcion[]" rows="4" cols="50" required></textarea>
            </div>
        </div><br>
        <div class="contt">
        <button type="button" onclick="limpiarCampos()" class="btneliminarcot">Limpiar campos</button>
        </div><br>
        <!-- Botón para agregar -->
        <div class="contt">
            <button type="button" class="btneliminarcot" onclick="seleccionar2(this)">Agregar</button><br>
        </div>
     <!-- Tabla de elementos seleccionados -->
        <div class="input-group">
            <?php echo $tablaSeleccionados; ?>
        </div>
        </form>
    <div class="input-group">
            <input type="submit" onclick="validarEnvioCotizacion()">
    </div>
    <!-- Botones adicionales -->
    <br><br>
    <div class="parent">
        <button type="button" onclick="window.location.href='AGG_MA.php'" class="v t">Agregar material</button>
        <button type="button" onclick="window.location.href='AGG_PRO.php'" class="v t">Agregar proveedor</button>
        <button type="button" onclick="window.location.href='MOD_PRECIO.php'" class="v t">Editar precios</button>
    </div>
</div>




    <!-- Seleccionar el proveedor comentado
    <div class="container">
    <h1>SELECCIONE PROVEEDOR</h1>
    <form action="OBTENER_MA.php" method="get">
        <label for="obra">Obra:</label>
        <select id="obra" name="obra_id" required>
            <option value="">Seleccione una obra</option>
            <?php
            require_once("../PHP/CONN.php");

            if ($conexion->connect_error) {
                die("Error de conexión: " . $conexion->connect_error);
            }

            $sql = "SELECT id, nombre FROM obras";
            $resultado = $conexion->query($sql);

            if ($resultado->num_rows > 0) {
                while ($fila = $resultado->fetch_assoc()) {
                    echo "<option value='".$fila['id']."'>".$fila['nombre']."</option>";
                }
            } else {
                echo "<option value=''>No hay obras disponibles</option>";
            }
            ?>
        </select>

        <label for="proveedor">Seleccione un proveedor:</label>
        <select name="proveedor" id="proveedor">
            <option value="">Seleccione un proveedor</option>
            <?php
            $consulta = "SELECT proveedor FROM proveedores";
            $resultados = mysqli_query($conexion, $consulta);

            while ($fila = mysqli_fetch_array($resultados)) {
                echo "<option value='" . $fila['proveedor'] . "'>" . $fila['proveedor'] . "</option>";
            }
            ?>
        </select>
        
        <button type="submit" class="v">Mostrar Materiales</button>
    </form>
</div>-->






<br><br>
</body>
<script src="../JS/app.js"></script>
</html>
