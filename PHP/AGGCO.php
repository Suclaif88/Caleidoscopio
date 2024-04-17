<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    require_once "CONN.php";
    
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    $material_ids = $_POST['material_id'];
    $descripciones = $_POST['descripcion'];
    $unidades = $_POST['unidad'];
    $precios = $_POST['precio'];
    $proveedor_ids = $_POST['proveedor_id'];

    for ($i = 0; $i < count($material_ids); $i++) {
        $material_id = $material_ids[$i];
        $descripcion = $descripciones[$i];
        $unidad = $unidades[$i];
        $precio = $precios[$i];
        $proveedor_id = $proveedor_ids[$i];

        $descripcion = $conexion->real_escape_string($descripcion);
        $unidad = $conexion->real_escape_string($unidad);
        $precio = intval($precio);

        $consulta_material = "SELECT material FROM agregar_materiales WHERE id = '$material_id'";
        $resultado_material = mysqli_query($conexion, $consulta_material);
        $fila_material = mysqli_fetch_assoc($resultado_material);
        $material = $fila_material['material'];

        $consulta_proveedor = "SELECT proveedor FROM proveedores WHERE id = '$proveedor_id'";
        $resultado_proveedor = mysqli_query($conexion, $consulta_proveedor);
        $fila_proveedor = mysqli_fetch_assoc($resultado_proveedor);
        $proveedor = $fila_proveedor['proveedor'];

        $sql = "INSERT INTO cotizaciones (material, descripcion, unidad, precio, proveedor) VALUES ('$material', '$descripcion', '$unidad', $precio, '$proveedor')"; // Insertamos el nombre del proveedor en lugar del ID

        if ($conexion->query($sql) !== TRUE) {
            echo "Error al enviar la cotización: " . $conexion->error;
            exit;
        }
    }
  
    echo '<script>alert("La cotización se ha agregado correctamente."); window.location.href = "../VISTADC/AGREGARCO.php";</script>';
        
} 