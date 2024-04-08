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


require_once("../PHP/CONN.php");

$resultados = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $busqueda = $conexion->real_escape_string($_POST['busqueda']);

    $sql = "SELECT * FROM cotizaciones WHERE producto LIKE '%$busqueda%' OR proveedor LIKE '%$busqueda%' OR descripcion LIKE '%$busqueda%' ORDER BY precio ASC"; 
    $result = $conexion->query($sql);

    $sql_materiales = "SELECT id FROM cotizaciones";
    $result_materiales = $conexion->query($sql_materiales);

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
    <link rel="stylesheet" href="../CSS/responsive.css">
    <link rel="icon" type="image/png" href="../IMG/favicon.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

</head>
<body>

<div class="navbar">
    <h1 style="cursor:default;">COTIZACIONES</h1>
    <ul>
        <li><a href="COMPRA-MATERIALES.php">Compra de materiales</a></li>
        <li><a href="OBRAS.php">Obras</a></li>
        <li><a href="" style="color:white;">Cotizaciones</a></li>
        <li><a href="DC.php">Inicio</a></li>
    </ul>
</div>

<div class="form-container">
    <h1>Busqueda de materiales</h1>
    <form action="" method="post" class="input-group">
        <input type="text" name="busqueda" placeholder="Búsqueda de materiales" class="form-control">
        <div class="input-group-btn">
            <input type="submit" value="Buscar" class="btn2">
        </div>
    </form>
</div>

<div class="table-container">
    <?php echo $resultados; ?>
</div>

<div class="cont">
    <a href="AGREGARCO.php"  class="div1 btn">Agregar cotizaciones</a>
</div>

<style>
    #formulario-container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100px;
        margin-bottom: 20px;
    }

    form {
        width: 300px;
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
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        background-color: #0056b3;
    }
</style>


<div id="formulario-container">

<form action="" method="post" class="solicitud">
    <input type="hidden" name="usuario" value="<?php echo $_SESSION["nombre"]; ?>">
    <h1 style="text-align: center;">USUARIO: <?php echo $_SESSION["nombre"]; ?></h1><br><br>
    <select id="obra" name="obra_id" required>
        <option value="">Seleccione una Obra</option>
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
    </select><br><br>
    <select id="proveedor" name="proveedor" required>
        <option value="">Seleccione un Proveedor</option>
        <?php
        require_once("../PHP/CONN.php");
        if ($conexion->connect_error) {
            die("Error de conexión: " . $conexion->connect_error);
        }
        $sql = "SELECT id, proveedor FROM proveedores";
        $resultado = $conexion->query($sql);
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_assoc()) {
                echo "<option value='".$fila['id']."'>".$fila['proveedor']."</option>";
            }
        } else {
            echo "<option value=''>No hay proveedores disponibles</option>";
        }
        ?>
    </select><br><br>
    <select id="materiales" name="materiales[]" multiple="multiple" style="width: 100%;">
        <option value="">Seleccione Materiales</option>
    </select><br><br>
    <script>
    $(document).ready(function() {
        $('#materiales').select2({
            placeholder: 'Seleccione Materiales',
            allowClear: true
        });

        function cargarMateriales(proveedorId) {
            $.ajax({
                url: '../PHP/CARGAR_MATERIALES.php',
                type: 'POST',
                data: { proveedor_id: proveedorId },
                dataType: 'html',
                success: function(response) {
                    $('#materiales').html(response);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }

        $('#proveedor').change(function() {
            var proveedorId = $(this).val();
            cargarMateriales(proveedorId);
        });
    });
</script>

    <input type="submit" value="ENVIAR" class="btn2">
</form>



</div>

</body>
</html>
