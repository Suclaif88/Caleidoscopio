<?php
session_start();

if (!isset($_SESSION["nombre"]) || strval($_SESSION["rol"]) !== "3") {
    header("Location: ../INDEX.html");
    exit();
}

require_once("../PHP/CONN.php");

$resultados = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['busqueda'])) {
    $busqueda = $conexion->real_escape_string($_POST['busqueda']);
    $sql = "SELECT * FROM cotizaciones WHERE producto LIKE '%$busqueda%' OR descripcion LIKE '%$busqueda%' ORDER BY precio ASC";
    $result = $conexion->query($sql);

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
            width: 120vh;
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
            width: calc(100% - 0px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
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
     <!--busqueda de materiales-->
    <div class="form-container">
        <h1>Busqueda de materiales</h1>
        <form action="" method="post" class="input-group">
            <input type="text" name="busqueda" placeholder="Búsqueda de materiales" class="form-control"    >
            <div class="input-group-btn">
                <input type="submit" value="Buscar" class="btn2">
            </div>
        </form>
    </div>

    <div class="table-container">
        <?php echo $resultados; ?>
    </div>

    <!-- Seleccionar el proveedor-->
    <div class="container">
        <h1>SELECCIONE PROVEEDOR</h1>

            
        <form action="OBTENER_MA.php" method="post">
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
                if (mysqli_connect_errno()) {
                    echo "Error de conexión a MySQL: " . mysqli_connect_error();
                    exit();
                }

                $consulta = "SELECT proveedor FROM proveedores";
                $resultados = mysqli_query($conexion, $consulta);

                while ($fila = mysqli_fetch_array($resultados)) {
                    echo "<option value='" . $fila['proveedor'] . "'>" . $fila['proveedor'] . "</option>";
                }

                ?>
            </select>
            <button type="submit" class="v">Mostrar Materiales</button>
        </form>
    </div>
    <!--Agregar cotizaciones-->
    
    <div class="container">
    <h1>Agregar cotización</h1>
    <form action="../PHP/AGGCO.php" method="post">
        <table id="cotizaciones">
            <thead>
                <tr>
                    <th>Material</th>
                    <th>Descripción</th>
                    <th>Unidad</th>
                    <th>Precio</th>
                    <th>Proveedor</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <select name="material_id[]" required>
                            <option value="">Seleccione un material</option>
                            <?php
                            $consulta = "SELECT id, material FROM agregar_materiales";
                            $resultado = mysqli_query($conexion, $consulta);
                            while ($fila = mysqli_fetch_assoc($resultado)) {
                                echo "<option value='" . $fila['id'] . "'>" . $fila['material'] . "</option>";
                            }
                            ?>
                        </select>
                    </td>
                    <td><input type="text" name="descripcion[]" required></td>
                    <td><input type="text" name="unidad[]" required></td>
                    <td><input type="number" name="precio[]" required></td>
                    <td>
                        <select name="proveedor_id[]" required>
                            <option value="">Seleccione un proveedor</option>
                            <?php
                            $consulta = "SELECT id, proveedor FROM proveedores";
                            $resultado = mysqli_query($conexion, $consulta);
                            while ($fila = mysqli_fetch_assoc($resultado)) {
                                echo "<option value='" . $fila['id'] . "'>" . $fila['proveedor'] . "</option>";
                            }
                            ?>
                        </select>
                    </td>
                    <td><button type="button" onclick="eliminarCotizacion(this)">Eliminar</button></td>
                </tr>
            </tbody>
        </table>
        <button type="button" onclick="agregarCotizacion()">Agregar cotización</button><br><br>
        <input type="submit" value="Enviar cotización">
    </form>
    <br>
    <br>
    <div class="parent">
        <button type="button" class="v divb1" onclick="window.location.href='AGG_MA.php'" style="cursor:pointer;">Agregar material</button>
        <button type="button" class="v divb3" onclick="window.location.href='AGG_PRO.php'" style="cursor:pointer;">Agregar proveedor</button>
        <button type="button" class="v divb2" onclick="window.location.href='MOD_PRECIO.php'" style="cursor:pointer;">Editar precios</button>
    </div>

    <script>
        function agregarCotizacion() {
            var tabla = document.getElementById("cotizaciones").getElementsByTagName('tbody')[0];
            var nuevaFila = tabla.insertRow(-1);
            nuevaFila.innerHTML = `
                <td>
                    <select name="material_id[]" required>
                    
                        <?php
                        $consulta = "SELECT id, material FROM agregar_materiales";
                        $resultado = mysqli_query($conexion, $consulta);
                        while ($fila = mysqli_fetch_assoc($resultado)) {
                            echo "<option value='" . $fila['id'] . "'>" . $fila['material'] . "</option>";
                        }
                        ?>
                    </select>
                </td>
                <td><input type="text" name="descripcion[]" required></td>
                <td><input type="text" name="unidad[]" required></td>
                <td><input type="number" name="precio[]" required></td>
                <td>
                    <select name="proveedor_id[]" required>
                    <option value="">Seleccione un proveedor</option>
                        <?php
                        $consulta = "SELECT id, proveedor FROM proveedores";
                        $resultado = mysqli_query($conexion, $consulta);
                        while ($fila = mysqli_fetch_assoc($resultado)) {
                            echo "<option value='" . $fila['id'] . "'>" . $fila['proveedor'] . "</option>";
                        }
                        ?>
                    </select>
                </td>
                <td><button type="button" onclick="eliminarCotizacion(this)">Eliminar</button></td>
            `;
        }

        function eliminarCotizacion(btn) {
            var fila = btn.parentNode.parentNode;
            fila.parentNode.removeChild(fila);
        }
    </script>
</div>


</body>

</html>
