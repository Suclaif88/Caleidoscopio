<?php
    require_once("../PHP/CONN.php");
    session_start();
    if(!isset($_SESSION["nombre"])){
        header("Location:../INDEX.html");
        exit();
    }

    if(strval($_SESSION["rol"]) !== "3") {
        header("Location: ../INDEX.html");
        exit();
    }
    
    $usuario=$_SESSION["nombre"];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Solicitud de Materiales</title>
    <link rel="stylesheet" href="../CSS/CSSCO.css">
    <link rel="stylesheet" href="../CSS/CSSDC.css">
    <link rel="stylesheet" href="../CSS/COT.css">
    <link rel="stylesheet" href="../CSS/responsive.css">
    <link rel="icon" type="image/png" href="../IMG/favicon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</head>
<body>
<br>




<div class="contobtenerma">
    <h1>Solicitud de Materiales</h1>
    <form action="../PHP/PROCESAR_SOLICITUD.php" method="post" class="solicitud">
        <?php
        $proveedor = '';
        $obra_id = '';
        $usuario = ''; // Asegúrate de obtener este valor de alguna manera
        if (isset($_GET['proveedor'])) {
            $proveedor = $_GET['proveedor'];
        }
        if (isset($_GET['obra_id'])) {
            $obra_id = $_GET['obra_id'];
        }
        ?>
        <input type="hidden" name="proveedor" value="<?php echo htmlspecialchars($proveedor); ?>">
        <input type="hidden" name="obra_id" value="<?php echo htmlspecialchars($obra_id); ?>">
        <input type="hidden" name="usuario" value="<?php echo htmlspecialchars($usuario); ?>">
        <input type="hidden" name="precios_seleccionados" id="precios_seleccionados" value="">

        <div class="multiselect">
            <div class="selectBox" onclick="showCheckboxes()">
                <select>
                    <option>Selecciona Materiales</option>
                    <?php
                    if ($conexion->connect_error) {
                        die("Error de conexión: " . $conexion->connect_error);
                    }

                    $sql = "SELECT id, material, descripcion, precio FROM cotizaciones WHERE proveedor = '$proveedor'";
                    $resultado = $conexion->query($sql);

                    if ($resultado->num_rows > 0) {
                        while ($row = $resultado->fetch_assoc()) {
                            echo '<option value="' . $row["id"] . '">' . $row["material"] . ' - ' . $row["precio"] . '</option>';
                        }
                    } else {
                        echo "<option>Sin resultados</option>";
                    }

                    $conexion->close();
                    ?>
                </select>
                <div class="overSelect"></div>
            </div>
            <div id="checkboxes" class="hide"></div>
        </div>

        <button class="btn1 div2" type="submit"><em>Enviar Solicitud</em></button><br>
        <button class="btn1 div2"><em><a href="COTIZACION.php">Volver</a></em></button>
    </form>
</div>

<script>
var expanded = false;

function showCheckboxes() {
  var checkboxes = document.getElementById("checkboxes");
  if (!expanded) {
    checkboxes.style.display = "block";
    expanded = true;
  } else {
    checkboxes.style.display = "none";
    expanded = false;
  }
}
</script>


</body>
</html>
