<?php
session_start();

if(!isset($_SESSION["nombre"])){
    header("Location:../INDEX.html");
    exit();
}

if(strval($_SESSION["rol"]) !== "1") {
  header("Location: ../INDEX.html");
  exit();
}

function obtenerRol($numeroRol) {
    switch ($numeroRol) {
        case 1:
            return "Admin";
        case 2:
            return "Gerente";
        case 3:
            return "Director de Compra";
        case 4:
            return "Director de Obra";
        case 5:
            return "Residente";
        default:
            return "Desconocido";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/CSSDC.css">
    <link rel="stylesheet" href="../CSS/CSSAD.css">
    <link rel="stylesheet" href="../CSS/responsive.css">
    <link rel="icon" type="image/png" href="../IMG/favicon.png">
    <title>ADMIN</title>
</head>
<body>

<div class="users-table">
        <h1>PEDIDOS</h1>
        <br>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>OBRA</th>
                    <th>USUARIO</th>
                    <th>PRODUCTO</th>
                    <th>PRECIO</th>
                    <th>CANTIDAD</th>
                    <th>UNIDAD</th>
                    <th>FECHA-PEDIDO</th>
                    <th>ESTADO</th>
                    <th>HISTORIAL</th>

                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
    <?php 
    require_once("../PHP/CONN.php");



    $sql = "SELECT pedidos.id, obras.nombre AS nombre_obra, pedidos.usuario, pedidos.producto, pedidos.precio, pedidos.cantidad, pedidos.unidad, pedidos.fecha_pedido, pedidos.estado, pedidos.historial
    FROM pedidos
    INNER JOIN obras ON pedidos.obra_id = obras.id
    ORDER BY pedidos.id ASC";



    $result = mysqli_query($conexion, $sql);
    while ($row = mysqli_fetch_array($result)): 
    ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['nombre_obra'] ?></td>
            <td><?= $row['usuario'] ?></td>
            <td><?= $row['producto'] ?></td>
            <td><?= $row['precio'] ?></td>
            <td><?= $row['cantidad'] ?></td>
            <td><?= $row['unidad'] ?></td>
            <td><?= $row['fecha_pedido'] ?></td>
            <td><?= $row['estado'] ?></td>
            <td><?= $row['historial'] ?></td>
            <td>
                <form action="../ADMIN/UPDATEPE.php" method="post">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <button type="submit" class="users-table--edit" style="cursor: pointer;">Editar</button>
                </form>
            </td>
            <td>
        <form action="../PHP/DELETE_PE.php" method="post">
            <input type="hidden" name="id" value="<?= $row['id'] ?>">
            <button type="submit" class="users-table--delete" style="cursor: pointer;" onclick="confirmDelete()">Eliminar</button>
        </form>


<script>
function confirmDelete() {
    var result = confirm("¿Estás seguro de que quieres eliminar este pedido?");
    if (result) {
        document.getElementById("deleteForm").submit();
    }
}
</script>


            </td>
        </tr>
    <?php endwhile; ?>
</tbody>


        </table>
    </div>
<div class="cad">
<button class="btn1 bc" onclick="window.location.href='CREAR_PEDIDO.php'">AGREGAR PEDIDO</button>
 <button class="btn1 bc2" onclick="window.location.href='../ADMIN/ADMIN.php'">Atras</button>
</div>

<br>

<footer class="footer">
        <p>&copy; Caleidoscopio 2024 - Todos los derechos reservados</p>
</footer>


</body>
</html>