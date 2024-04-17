<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "CONN.php";

    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    // Obtener datos del formulario
    $usuario = $conexion->real_escape_string($_POST['usuario']);
    $obra_id = intval($_POST['obra_id']);
    $material_ids = $_POST['material_id'];
    $cantidades = $_POST['cantidad'];
    $unidades = $_POST['unidad'];
    $material_nombres = $_POST['material_nombre'];

    // Bucle para procesar cada material seleccionado
    for ($i = 0; $i < count($material_ids); $i++) {
        // Recuperar datos específicos del material
        $material_id = intval($material_ids[$i]);
        $cantidad = intval($cantidades[$i]);
        $unidad = $conexion->real_escape_string($unidades[$i]);
        $material_nombre = $conexion->real_escape_string($material_nombres[$i]);

        // Consulta para obtener el precio del material de la tabla cotizaciones
        $sql_precio = "SELECT precio FROM cotizaciones WHERE id = $material_id";
        $resultado_precio = $conexion->query($sql_precio);

        if ($resultado_precio) {
            if ($resultado_precio->num_rows > 0) {
                $row = $resultado_precio->fetch_assoc();
                $precio = floatval($row['precio']);

                // Insertar la solicitud del material en la tabla de pedidos
                $sql_insert = "INSERT INTO pedidos (usuario, obra_id, producto, cantidad, unidad, precio, estado)
                               VALUES ('$usuario', $obra_id, '$material_nombre', $cantidad, '$unidad', $precio, 1)";

                if ($conexion->query($sql_insert) !== TRUE) {
                    echo "Error al enviar la solicitud de materiales: " . $conexion->error;
                    exit;
                }
            } else {
                echo "Error: No se encontró el precio del material con ID '$material_id'.";
                exit;
            }
        } else {
            echo "Error en la consulta SQL: " . $conexion->error;
            exit;
        }
    }

    // Éxito: mostrar mensaje y redirigir
    echo "<script>alert('¡Solicitud de materiales enviada con éxito!');</script>";
    echo "<script>window.location.href = '../VISTADC/COTIZACION.php';</script>";

    // Cerrar conexión
    $conexion->close();
}