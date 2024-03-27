<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Material</title>
    <link rel="stylesheet" href="../CSS/CSSCO.css">
    <link rel="stylesheet" href="../CSS/CSS.css">
    <link rel="stylesheet" href="../CSS/responsive.css">
    <link rel="icon" type="image/png" href="../IMG/favicon.png">
</head>
<body>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px 0;
        }

        form {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
            margin-top: 20px;
            background-color: #ccc;
        }

        form label {
            font-weight: bold;
        }

        form select, form input[type="text"], form input[type="number"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
        }
    </style>

    

<div class="navbar">
    <h1>COTIZACIONES</h1>
    <ul>
        <li><a href="COTIZACION.php">Atras</a></li>
    </ul>
</div>



    <form action=../PHP/AGGCO.php" method="POST">
        <label for="material">Material:</label>
        <select name="material" id="material">
            <?php
            require_once "../PHP/CONN.php";

            $consulta = "SELECT id, material FROM agregar_materiales";
            $resultado = mysqli_query($conexion, $consulta);

            while ($fila = mysqli_fetch_assoc($resultado)) {
                echo "<option value='" . $fila['id'] . "'>" . $fila['material'] . "</option>";
            }

            ?>
        </select>
        <label for="descripcion">Descripción:</label>
        <input type="text" name="descripcion" required>
        <label for="unidad_medida">Unidad de medida:</label>
        <input type="text" name="unidad_medida" required>
        <label for="precio">Precio:</label>
        <input type="number" name="precio" required>
        <label for="proveedor">Proveedor:</label>
        <select name="proveedor" id="proveedor" required>
            <?php

            $consulta = "SELECT id, proveedor FROM proveedores";
            $resultado = mysqli_query($conexion, $consulta);

            while ($fila = mysqli_fetch_assoc($resultado)) {
                echo "<option value='" . $fila['id'] . "'>" . $fila['proveedor'] . "</option>";
            }

            ?>
        </select>
        <div class="form-container">
            <button type="button" onclick="agregarProducto()" class="btn">Agregar Producto</button>
        </div>
    </form>
    <br>
    <br>

        <div id="productos" class="product-container">
            <div class="product-item">
                <label for="material">Material:</label>
                <select name="material[]" id="material">
                    <?php

                    $consulta = "SELECT id, material FROM agregar_materiales";
                    $resultado = mysqli_query($conexion, $consulta);

                    while ($fila = mysqli_fetch_assoc($resultado)) {
                        echo "<option value='" . $fila['id'] . "'>" . $fila['material'] . "</option>";
                    }

                    ?>
                </select>
                <label for="descripcion">Descripcion:</label>
                <input type="text" name="descripcion[]">
                <label for="unidad">Unidad de medida:</label>
                <input type="text" name="unidades[]">
                <label for="precio">Precio:</label>
                <input type="number" name="precio[]">
                <label for="proveedor">Proveedor:</label>
                <select name="proveedor[]" id="proveedor">
                    <?php

                    $consulta = "SELECT id, proveedor FROM proveedores";
                    $resultado = mysqli_query($conexion, $consulta);

                    while ($fila = mysqli_fetch_assoc($resultado)) {
                        echo "<option value='" . $fila['id'] . "'>" . $fila['proveedor'] . "</option>";
                    }

                    ?>
                </select>
                <button type="button" onclick="eliminarProducto(this)">Eliminar</button>
            </div>
        </div>

<input type="submit" value="Enviar" class="btn" style="border: 2px solid black;">
       
<div class="vp">
        <a href="cotizacion.php" class="v">Inicio</a>
        <a href="../AGR_MATERIAL.html" class="v">Agregar materiales</a>
        <a href="../AGR_PROVEEDOR.html" class="v">Agregar proveedores</a>
        <a href="modificacion.php" class="v">Modificar precios de los materiales</a>
</div>
<br>
<br>



<!---->

    <script>
        function agregarProducto() {
            var contenedor = document.getElementById("productos");
            var nuevoProducto = document.createElement("div");
            nuevoProducto.classList.add("product-item");
            nuevoProducto.innerHTML = `
                <label for="material">Material:</label>
                <select name="material[]" id="material">
                    <?php

                    $consulta = "SELECT id, material FROM agregar_materiales";
                    $resultado = mysqli_query($conexion, $consulta);

                    while ($fila = mysqli_fetch_assoc($resultado)) {
                        echo "<option value='" . $fila['id'] . "'>" . $fila['material'] . "</option>";
                    }

                    ?>
                </select>
                <label for="descripcion">Descripcion:</label>
                <input type="text" name="descripcion[]" required>
                <label for="unidad">Unidad de medida:</label>
                <input type="text" name="unidades[]" required>
                <label for="precio">Precio:</label>
                <input type="number" name="precio[]" required>
                <label for="proveedor">Proveedor:</label>
                <select name="proveedor[]" id="proveedor">
                    <?php

                    $consulta = "SELECT id, proveedor FROM proveedores";
                    $resultado = mysqli_query($conexion, $consulta);

                    while ($fila = mysqli_fetch_assoc($resultado)) {
                        echo "<option value='" . $fila['id'] . "'>" . $fila['proveedor'] . "</option>";
                    }

                    mysqli_close($conexion);
                    ?>
                </select>
                <button type="button" onclick="eliminarProducto(this)">Eliminar</button>
            `;
            contenedor.appendChild(nuevoProducto);
        }

        function eliminarProducto(elemento) {
            elemento.parentNode.parentNode.removeChild(elemento.parentNode);
        }
    </script>
</body>
</html>
