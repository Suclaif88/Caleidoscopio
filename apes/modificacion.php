<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Precio de Material</title>
</head>
<body>
    <header>
        <h1>Modificar Precio de Material</h1>
    </header>
    <form action="procesar_modificacion.php" method="POST">
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
        </select><br>
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
        </select><br>
        <label for="nuevo_precio">Nuevo Precio:</label>
        <input type="number" name="nuevo_precio" required><br>
        <input type="submit" value="Modificar Precio">
    </form>
    <a href="agrcot.php">cotizaciones</a>
</body>
</html>
