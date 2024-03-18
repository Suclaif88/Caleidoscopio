<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Solicitud de Materiales</title>
</head>
<body>
    <h2>Nueva Solicitud de Materiales</h2>
    <form action="procesar_solicitud.php" method="post">
        <label for="usuario">Nombre de Usuario:</label><br>
        <input type="text" id="usuario" name="usuario" required><br>
        
        <label for="obra">Obra:</label><br>
        <select id="obra" name="obra" required>
            <option value="">Seleccione una obra</option>
            <?php

            $conexion = new mysqli("localhost", "vale", "Salem31ob", "apes");

            if ($conexion->connect_error) {
                die("Error de conexión: " . $conexion->connect_error);
            }

            $sql = "SELECT id, nombre FROM obras";
            $resultado = $conexion->query($sql);

            // Menú desplegable de obras
            if ($resultado->num_rows > 0) {
                while ($fila = $resultado->fetch_assoc()) {
                    echo "<option value='".$fila['id']."'>".$fila['nombre']."</option>";
                }
            } else {
                echo "<option value=''>No hay obras disponibles</option>";
            }

            $conexion->close();
            ?>
        </select><br><br>
   

        <div id="productos">
            <div>
                <label for="producto">Producto:</label>
                <input type="text" name="productos[]" required>
                <label for="cantidad">Cantidad:</label>
                <input type="number" name="cantidades[]" required>
                <label for="unidad">Unidad:</label>
                <input type="text" name="unidades[]" required>
                <button type="button" onclick="eliminarProducto(this)">Eliminar</button>
            </div>
        </div>
        
        <br><button type="button" onclick="agregarProducto()">Agregar Producto</button><br><br>
        <button type="submit">Enviar Solicitud</button>
        
    </form>
    
    <script>
        function agregarProducto() {
            var contenedor = document.getElementById("productos");
            var nuevoProducto = document.createElement("div");
            nuevoProducto.innerHTML = `
                <div>
                    <label for="producto">Producto:</label>
                    <input type="text" name="productos[]" required>
                    <label for="cantidad">Cantidad:</label>
                    <input type="number" name="cantidades[]" required>
                    <label for="unidad">Unidad:</label>
                    <input type="text" name="unidades[]" required>
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
