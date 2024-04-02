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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Solicitud de Materiales</title>
    <link rel="stylesheet" href="../CSS/CSSCO.css">
    <link rel="stylesheet" href="../CSS/CSSDC.css">
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

        form{
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
        h3{
            text-align: center;
            margin: 2vh;
        }
    </style>
    <header class="navbar">
        <h1>Agregar Cotización</h1>
        <ul>
        <li><a href="COTIZACION.php">Atras</a></li>
        </ul>
    </header>
    
    <form action="../PHP/AGGCO.php" method="post">
    <div id="cotizaciones">
    <h3>Cotización</h3>
    <div>
        <label for="material">Material:</label>
        <select name="material_id[]" required>
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
        <input type="text" name="descripcion[]" required>
        <label for="unidad">Unidad:</label>
        <input type="text" name="unidad[]" required>
        <label for="precio">Precio:</label>
        <input type="number" name="precio[]" required>
        <label for="proveedor">Proveedor:</label>
        <select name="proveedor_id[]" required>
            <?php
            $consulta = "SELECT id, proveedor FROM proveedores";
            $resultado = mysqli_query($conexion, $consulta);
            while ($fila = mysqli_fetch_assoc($resultado)) {
                echo "<option value='" . $fila['id'] . "'>" . $fila['proveedor'] . "</option>";
            }
            ?>
        </select>
    </div>
    </div>
    <button type="button" class="btn1" onclick="agregarCotizacion()">Agregar cotización</button><br><br>

   </form>
   <br>
   <button type="submit" class="btn2">Enviar cotizaciones</button>
   <br>
   <div class="parent">
        <button type="button" class="btn2 divb1" onclick="window.location.href='AGG_MA.php'" style="cursor:pointer;">Agregar material</button>
        <button type="button" class="btn2 divb2" onclick="window.location.href='AGG_PRO.php'" style="cursor:pointer;">Agregar proveedor</button>
        <button type="button" class="btn2 divb3" onclick="window.location.href='MOD_PRECIO.php'" style="cursor:pointer;">Editar precios</button>
   </div>
    
    <script>
        function agregarCotizacion() {
            var contenedor = document.getElementById("cotizaciones");
            var nuevaCotizacion = document.createElement("div");
            nuevaCotizacion.innerHTML = `
                <div>
                <h3>Cotización</h3><br>
                <label for="material">Material:</label>
                <select name="material_id[]" require>
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
                <input type="text" name="descripcion[]" required>
                <label for="unidad">Unidad:</label>
                <input type="text" name="unidad[]" required>
                <label for="precio">Precio:</label>
                <input type="number" name="precio[]" required>
                <label for="proveedor">Proveedor:</label>
                <select name="proveedor_id[]" require>
                    <?php
                    $consulta = "SELECT id, proveedor FROM proveedores";
                    $resultado = mysqli_query($conexion, $consulta);
                    while ($fila = mysqli_fetch_assoc($resultado)) {
                        echo "<option value='" . $fila['id'] . "'>" . $fila['proveedor'] . "</option>";
                    }
                    ?>
                </select>
                <button type="button" onclick="eliminarCotizacion(this)">Eliminar</button>
                </div>
            `;
            contenedor.appendChild(nuevaCotizacion);
        }

        function eliminarCotizacion(elemento) {
            elemento.parentNode.parentNode.removeChild(elemento.parentNode);
        }
    </script>
</body>
</html>


