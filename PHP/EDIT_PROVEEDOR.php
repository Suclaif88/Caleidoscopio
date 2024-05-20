<?php
require_once("CONN.php");

$id = $_POST["id"];
$proveedor = $_POST['proveedor'];
$nit = $_POST['nit'];
$correo = $_POST['correo'];
$telefono = $_POST['telefono'];

$sql = "UPDATE proveedores SET proveedor='$proveedor', nit='$nit', correo='$correo', telefono='$telefono' WHERE id='$id'";

$query = mysqli_query($conexion, $sql);

if ($query) {
    // Si la actualización es exitosa, crea un array con la respuesta
    $response = array(
        "success" => true,
        "message" => "Actualización exitosa"
    );
} else {
    // Si hay un error en la consulta, crea un array con la respuesta
    $response = array(
        "success" => false,
        "message" => "Error al actualizar los datos del proveedor"
    );
}

echo json_encode($response);

