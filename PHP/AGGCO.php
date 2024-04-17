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
    $descuentos = $_POST['descuento'];
    $impuestos = $_POST['impuesto'];
    $proveedor_ids = $_POST['proveedor_id'];

    for ($i = 0; $i < count($material_ids); $i++) {
        $material_id = $material_ids[$i];
        $descripcion = $descripciones[$i];
        $unidad = $unidades[$i];
        $precio = $precios[$i];
        $descuento = $descuentos[$i];
        $impuesto = $impuestos[$i];
        $proveedor_id = $proveedor_ids[$i];

        $descripcion = $conexion->real_escape_string($descripcion);
        $unidad = $conexion->real_escape_string($unidad);
        $descuento = $conexion->real_escape_string($descuento);
        $impuesto = $conexion->real_escape_string($impuesto);
        $precio = intval($precio);

        $consulta_material = "SELECT material FROM agregar_materiales WHERE id = '$material_id'";
        $resultado_material = $conexion->query($consulta_material);
        $fila_material = $resultado_material->fetch_assoc();
        $material = $fila_material['material'];

        $consulta_proveedor = "SELECT proveedor FROM proveedores WHERE id = '$proveedor_id'";
        $resultado_proveedor = mysqli_query($conexion, $consulta_proveedor);
        $fila_proveedor = mysqli_fetch_assoc($resultado_proveedor);
        $proveedor = $fila_proveedor['proveedor'];

        $sql = "INSERT INTO cotizaciones (material, descripcion, unidad, precio, descuento, impuestos, proveedor) VALUES ('$material', '$descripcion', '$unidad', $precio,'$descuento','$impuesto', '$proveedor')";

        if ($conexion->query($sql) !== TRUE) {
            echo "Error al enviar la cotización: " . $conexion->error;
            exit;
        }
    }
  
    echo '<script>alert("La cotización se ha agregado correctamente."); window.location.href = "../VISTADC/COTIZACION.php";</script>';
        
} 
?>
