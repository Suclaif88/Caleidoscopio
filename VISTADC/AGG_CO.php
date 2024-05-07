<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AGREGAR PRODUCTOS</title>
    <link rel="stylesheet" href="../CSS/CSSCO.css">
    <link rel="stylesheet" href="../CSS/CSS.css">
    <link rel="stylesheet" href="../CSS/COT.css">
    <link rel="stylesheet" href="../CSS/responsive.css">
    <link rel="icon" type="image/png" href="../IMG/favicon.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
</head>
<body>
<div>
<div class="navbar">
        <h1 style="cursor:default;">Agregar Productos</h1>
        <ul>
            <li><a href="SOLICITUDES.php">Solicitudes</a></li>
            <li><a href="OBRAS.php">Obras</a></li>
            <li><a href="COTIZACION.php" style="color:white;">Cotizaciones</a></li>
            <li><a href="DC.php">Inicio</a></li>
        </ul>
    </div>
    <form action="../PHP/AGGCO.php" method="post">
        <h2 id="title"style="text-align: center;margin: 5vh;">Agregar productos</h2>
        <table id="cotizaciones">
            <thead>
                <tr>
                    <th>Material</th>
                    <th>Descripción</th>
                    <th>Unidad</th>
                    <th>Precio</th>
                    <th>descuento</th>
                    <th>impuesto</th>
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
                    require_once("../PHP/CONN.php");

                    if ($conexion->connect_error) {
                        die("Error de conexión: " . $conexion->connect_error);
                    }
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
                    <td><input type="number" name="descuento[]" required></td>
                    <td><input type="number" name="impuesto[]" required></td>
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
        <div class="table-container">
                <button type="button" class="v t" onclick="agregarCotizacion()">Agregar producto</button><br><br>
            <input type="submit" value="Enviar productos" class="v t">
        </form>
   <script>
        function agregarCotizacion() {
            var tabla = document.getElementById("cotizaciones").getElementsByTagName('tbody')[0];
            var nuevaFila = tabla.insertRow(-1);
            nuevaFila.innerHTML = `
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
                <td><input type="text" name="descuento[]"></td>
                <td><input type="number" name="impuestos[]"></td>
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
</body>
</html>