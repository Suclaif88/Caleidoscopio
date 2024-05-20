<?php
session_start();

if (!isset($_SESSION["nombre"])) {
    header("Location: ../INDEX.html");
    exit();
}

if (strval($_SESSION["rol"]) !== "3") {
    header("Location: ../INDEX.html");
    exit();
}

require_once("../PHP/CONN.php");

$sql = "SELECT * FROM proveedores";
$result = mysqli_query($conexion, $sql);

if (!$result) {
    die("Error en la consulta: " . mysqli_error($conexion));
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
    <title>MODIFICAR PROVEEDORES</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 15px; /* Incrementar el padding para mayor espacio */
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .users-table--edit, .users-table--delete {
            text-decoration: none;
            color: #007bff;
        }

        .users-table--edit:hover, .users-table--delete:hover {
            text-decoration: none;
        }
    </style>
</head>
<header class="cabeza">
    <h1>Modificar proveedores</h1>
</header>
<body>
<div class="users-table">
    <h1>Proveedores registrados</h1>
    <br>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>PROVEEDOR</th>
                <th>NIT</th>
                <th>EMAIL</th>
                <th>TELEFONO</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['proveedor']) ?></td>
                    <td><?= htmlspecialchars($row['nit']) ?></td>
                    <td><?= htmlspecialchars($row['correo']) ?></td>
                    <td><?= htmlspecialchars($row['telefono']) ?></td>
                    <td><a href="../ADMIN/UPDATE.php?id=<?= urlencode($row['id']) ?>" class="users-table--edit">Editar</a></td>
                    <td><a href="../PHP/DELETE_USER.php?id=<?= urlencode($row['id']) ?>" class="users-table--delete">Eliminar</a></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<br>
</body>
</html>

<?php
mysqli_free_result($result);
mysqli_close($conexion);
?>
