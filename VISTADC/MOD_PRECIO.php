<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Precio de Material</title>
</head>
<body>
    <h2>Modificar Precio de Material</h2>
    <form action="procesar_modificacion.php" method="post">
        <label for="material_id">Seleccione el material:</label>
        <select name="material_id" id="material_id">
            <?php
                require_once "../PHP/CONN.php";
                $consulta = "SELECT id, material FROM agregar_materiales";
                $resultado = mysqli_query($conexion, $consulta);
                while ($fila = mysqli_fetch_assoc($resultado)) {
                    echo "<option value='" . $fila['id'] . "'>" . $fila['material'] . "</option>";
                }
            ?>
        </select><br><br>

        <label for="proveedor_id">Seleccione el proveedor:</label>
        <select name="proveedor_id" id="proveedor_id">
            <?php
                $consulta = "SELECT id, proveedor FROM proveedores";
                $resultado = mysqli_query($conexion, $consulta);
                while ($fila = mysqli_fetch_assoc($resultado)) {
                    echo "<option value='" . $fila['id'] . "'>" . $fila['proveedor'] . "</option>";
                }

                $conexion->close();
            ?>
        </select><br><br>

        <label for="nuevo_precio">Nuevo precio:</label>
        <input type="text" name="nuevo_precio" id="nuevo_precio"><br><br>
        <button type="submit">Modificar Precio</button>
    </form>
</body>
</html>
