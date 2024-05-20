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
        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 0 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            text-align: center; /* Centra el contenido horizontalmente */
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
            cursor: pointer;
        }

        .users-table--edit:hover, .users-table--delete:hover {
            text-decoration: none;
        }

        /* Estilos para pantallas pequeñas */
        @media only screen and (max-width: 600px) {
            th, td {
                padding: 5px; /* Reducir el padding en pantallas pequeñas */
            }
        }
    </style>
</head>
<body>
    <header class="cabeza">
        <h1>Modificar proveedores</h1>
        <br>
        <a href="COTIZACION.php" style="color:black;">Atras</a>
    </header>
<div class="container">
    <div class="users-table">
        <h2>Proveedores registrados</h2>
        <br>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>PROVEEDOR</th>
                    <th>NIT</th>
                    <th>EMAIL</th>
                    <th>TELEFONO</th>
                    <th>EDITAR</th>
                    <th>ELIMINAR</th>
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
                        <td><a onclick="mostrarEditarAlert(<?= $row['id'] ?>)" class="users-table--edit">Editar</a></td>
                        <td><a onclick="mostrarEliminarAlert(<?= $row['id'] ?>)" class="users-table--delete">Eliminar</a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<br>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function mostrarEditarAlert(id) {
        Swal.fire({
            title: 'Editar proveedor',
            text: '¿Desea editar este proveedor?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Editar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `../VISTADC/UPDATEPRO.php?id=${id}`;
            }
        });
    }

    function mostrarEliminarAlert(id) {
        Swal.fire({
            title: 'Eliminar proveedor',
            text: '¿Desea eliminar este proveedor?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `../PHP/DELETEPRO.php?id=${id}`;
            }
        });
    }
</script>
</body>
</html>

<?php
mysqli_free_result($result);
mysqli_close($conexion);
?>
