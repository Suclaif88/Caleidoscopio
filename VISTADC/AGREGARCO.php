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
<style> 
     form {
         margin:5vh;
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    table, th, td {
        border: 1px solid black;
        padding: 8px;
        text-align: left;
    }
    th {
        background-color: #f2f2f2;
    }
</style>
<script>   
function agregarFila(materialesOptions, proveedoresOptions) {
    var table = document.getElementById("tabla-materiales");
    var row = table.insertRow(-1);

    var colCount = table.rows[0].cells.length;
    for (var i = 0; i < colCount; i++) {
        var newCell = row.insertCell(i);
        if (i == 0) { 
            newCell.innerHTML = materialesOptions;
        } else if (i == 4) {
            newCell.innerHTML = proveedoresOptions;
        } else if (i == 1) {
            newCell.innerHTML = "<input type='text' name='descripcion[]'>";
        } else if (i == 2) {
            newCell.innerHTML = "<input type='text' name='unidad_medida[]'>";
        } else {
            newCell.innerHTML = "<input type='number' name='precio[]' step='0.01'>";
        }
    }
}

function eliminarFila() {
    var table = document.getElementById("tabla-materiales");
    if (table.rows.length > 2) {
        table.deleteRow(-1);
    } else {
        alert("No se puede eliminar más filas.");
    }
}

function actualizarOpcionesMateriales() {
    var materialesOptions = "<?php
        require_once "../PHP/CONN.php";
        $consultaMateriales = "SELECT id, material FROM agregar_materiales";
        $resultadoMateriales = mysqli_query($conexion, $consultaMateriales);
        $optionsMateriales = "<option value=''>Seleccione...</option>";
        while ($filaMaterial = mysqli_fetch_assoc($resultadoMateriales)) {
            $optionsMateriales .= "<option value='" . $filaMaterial['id'] . "'>" . $filaMaterial['material'] . "</option>";
        }
        echo $optionsMateriales;
    ?>";

    var selectMateriales = document.querySelectorAll("[name='material_id']");
    selectMateriales.forEach(function(select) {
        select.innerHTML = materialesOptions;
    });
}

function actualizarOpcionesProveedores() {
    var proveedoresOptions = "<?php
        $consultaProveedores = "SELECT id, proveedor FROM proveedores";
        $resultadoProveedores = mysqli_query($conexion, $consultaProveedores);
        $optionsProveedores = "<option value=''>Seleccione...</option>";
        while ($filaProveedor = mysqli_fetch_assoc($resultadoProveedores)) {
            $optionsProveedores .= "<option value='" . $filaProveedor['id'] . "'>" . $filaProveedor['proveedor'] . "</option>";
        }
        echo $optionsProveedores;
    ?>";

    var selectProveedores = document.querySelectorAll("[name='proveedor_id']");
    selectProveedores.forEach(function(select) {
        select.innerHTML = proveedoresOptions;
    });
}

</script>
</head>
<body>

<div class="navbar">
    <h1>COTIZACIONES</h1>
    <ul>
        <li><a href="COTIZACION.php">Atras</a></li>
    </ul>
</div>

<form action="../PHP/AGGCO.php" method="post">
    <table id="tabla-materiales">
        <thead>
            <tr>
                <th>Material</th>
                <th>Descripción</th>
                <th>Unidad de Medida</th>
                <th>Precio</th>
                <th>Proveedor</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <select name="material_id">
                        <?php echo $optionsMateriales; ?>
                    </select>
                </td>
                <td><input type="text" name="descripcion"></td>
                <td><input type="text" name="unidad_medida"></td>
                <td><input type="number" name="precio[]" step="0.01"></td>
                <td>
                    <select name="proveedor_id">
                        <?php echo $optionsProveedores; ?>
                    </select>
                </td>
            </tr>
        </tbody>
    </table>
    <br>
    <input type="button" value="Agregar fila" onclick="agregarFila('<?php echo $optionsMateriales; ?>', '<?php echo $optionsProveedores; ?>')">
    <input type="button" value="Eliminar última fila" onclick="eliminarFila()">
    <input type="submit" value="Enviar">
</form>

</body>
</html>
