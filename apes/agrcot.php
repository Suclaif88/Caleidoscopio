<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar cotización</title>
</head>
<body>
    <header>
        <h1>Agregar cotización</h1>
    </header>
    <form action="procesar.php" method="POST">
        <label for="material">Material:</label>
        <select name="material" id="material">
            <?php
            $conexion = mysqli_connect("localhost", "vale", "Salem31ob", "apes");

            $consulta = "SELECT id, material FROM agregar_materiales";
            $resultado = mysqli_query($conexion, $consulta);

            while ($fila = mysqli_fetch_assoc($resultado)) {
                echo "<option value='" . $fila['id'] . "'>" . $fila['material'] . "</option>";
            }

            mysqli_close($conexion);
            ?>
        </select>
        <label for="descripcion">Descripción:</label>
        <input type="text" name="descripcion">
        <label for="unidad_medida">Unidad de medida:</label>
        <input type="text" name="unidad_medida">
        <label for="precio">Precio:</label>
        <input type="number" name="precio">
        <label for="proveedor">Proveedor:</label>
        <select name="proveedor" id="proveedor">
            <?php
            $conexion = mysqli_connect("localhost", "vale", "Salem31ob", "apes");

            $consulta = "SELECT id, proveedor FROM proveedores";
            $resultado = mysqli_query($conexion, $consulta);

            while ($fila = mysqli_fetch_assoc($resultado)) {
                echo "<option value='" . $fila['id'] . "'>" . $fila['proveedor'] . "</option>";
            }

            mysqli_close($conexion);
            ?>
        </select>

        <!-- Aquí agregamos el código JavaScript al final del formulario -->
        <div id="productos">
            <div>
                <label for="material">Material:</label>
                <select name="material[]" id="material">
                    <?php
                    $conexion = mysqli_connect("localhost", "vale", "Salem31ob", "apes");

                    $consulta = "SELECT id, material FROM agregar_materiales";
                    $resultado = mysqli_query($conexion, $consulta);

                    while ($fila = mysqli_fetch_assoc($resultado)) {
                        echo "<option value='" . $fila['id'] . "'>" . $fila['material'] . "</option>";
                    }

                    mysqli_close($conexion);
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
                    $conexion = mysqli_connect("localhost", "vale", "Salem31ob", "apes");

                    $consulta = "SELECT id, proveedor FROM proveedores";
                    $resultado = mysqli_query($conexion, $consulta);

                    while ($fila = mysqli_fetch_assoc($resultado)) {
                        echo "<option value='" . $fila['id'] . "'>" . $fila['proveedor'] . "</option>";
                    }

                    mysqli_close($conexion);
                    ?>
                </select>
                <button type="button" onclick="eliminarProducto(this)">Eliminar</button>
            </div>
        </div>
        
        <button type="button" onclick="agregarProducto()">Agregar Producto</button><br>

        <input type="submit" value="Enviar"><br>
        
        <a href="cotizacion.php">Inicio</a><br>
        <a href="agr_material.html">Agregar materiales</a><br>
        <a href="agr_proveedor.html">Agregar proveedores</a><br>
        <a href="modificacion.php">Modificar precios de los materiales</a>
    </form>

    <script>
        function agregarProducto() {
            var contenedor = document.getElementById("productos");
            var nuevoProducto = document.createElement("div");
            nuevoProducto.innerHTML = `
                <div>
                <label for="material">Material:</label>
                <select name="material[]" id="material">
                    <?php
                    $conexion = mysqli_connect("localhost", "vale", "Salem31ob", "apes");

                    $consulta = "SELECT id, material FROM agregar_materiales";
                    $resultado = mysqli_query($conexion, $consulta);

                    while ($fila = mysqli_fetch_assoc($resultado)) {
                        echo "<option value='" . $fila['id'] . "'>" . $fila['material'] . "</option>";
                    }

                    mysqli_close($conexion);
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
                    $conexion = mysqli_connect("localhost", "vale", "Salem31ob", "apes");

                    $consulta = "SELECT id, proveedor FROM proveedores";
                    $resultado = mysqli_query($conexion, $consulta);

                    while ($fila = mysqli_fetch_assoc($resultado)) {
                        echo "<option value='" . $fila['id'] . "'>" . $fila['proveedor'] . "</option>";
                    }

                    mysqli_close($conexion);
                    ?>
                </select>
                <button type="button" onclick="eliminarProducto(this)">Eliminar</button>
                </div>
            `;
            contenedor.appendChild(nuevoProducto);
        }

        function eliminarProducto(elemento) {
            elemento.parentNode.parentNode.removeChild(elemento.parentNode);
        }
    </script>
</body>
</html>
