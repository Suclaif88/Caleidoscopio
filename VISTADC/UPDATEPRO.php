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
 
$id = $_GET['id'];

$sql = "SELECT * FROM proveedores WHERE id = '$id'";
$query=mysqli_query($conexion, $sql);

$row=mysqli_fetch_array($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../CSS/CSSDC.css">
    <link rel="stylesheet" href="../CSS/CSSAD.css">
    <link rel="stylesheet" href="../CSS/responsive.css">
    <link rel="icon" type="image/png" href="../IMG/favicon.png">
    <title>EDITAR PROVEEDOR</title>
    <link rel="shortcut icon" href="../images/favicon.png" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            font-family: 'Segoe UI', sans-serif;
            text-align: center;
        }

        a {
            text-decoration: none;
        }

        .users-form form {
            display: flex;
            flex-direction: column;
            gap: 24px;
            width: 30%;
            margin: 20px auto;
            text-align: center;
        }

        .users-form form input {
            font-family: 'Segoe UI', sans-serif;
        }

        .users-form form input[type=text],
        .users-form form input[type=password],
        .users-form form input[type=email] {
            padding: 8px;
            border: 2px solid #aaa;
            border-radius: 4px;
            outline: none;
            transition: .3s;
        }

        .users-form form input[type=text]:focus,
        .users-form form input[type=password]:focus,
        .users-form form input[type=password]:focus {
            border-color: dodgerBlue;
            box-shadow: 0 0 6px 0 dodgerBlue;
        }

        .users-form form input[type=submit] {
            border: none;
            padding: 12px 50px;
            text-decoration: none;
            transition-duration: 0.4s;
            cursor: pointer;
            border-radius: 5px;
            background-color: white;
            color: black;
            border: 2px solid #60a100;
        }

        .users-form form input[type=submit]:hover {
            background-color: #60a100;
            color: white;
        }
    </style>
</head>
<body>
    <div class="users-form">
        <form id="editarFormulario" method="POST">
            <input type="hidden" name="id" value="<?= $row['id']?>">

            <label for="proveedor">Proveedor:</label>
            <input type="text" id="proveedor" name="proveedor" placeholder="Proveedor" value="<?= $row['proveedor']?>" required>

            <label for="nit">NIT:</label>
            <input type="text" id="nit" name="nit" placeholder="NIT" value="<?= $row['nit']?>" required>

            <label for="correo">Correo Electrónico:</label>
            <input type="text" id="correo" name="correo" placeholder="Correo" value="<?= $row['correo']?>" required>

            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name="telefono" placeholder="Teléfono" value="<?= $row['telefono']?>" required>

            <input type="submit" id="actualizarBtn" value="ACTUALIZAR">
            <a href="MOD_PROVEEDOR.php">ATRAS</a>
        </form>
    </div>
</body>
<script>
document.getElementById("editarFormulario").addEventListener("submit", function(event) {
    event.preventDefault();

    var formData = new FormData(this);

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "../PHP/EDIT_PROVEEDOR.php", true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.success) {
                    // Muestra una alerta de éxito
                    Swal.fire({
                        title: 'Actualización exitosa',
                        text: response.message,
                        icon: 'success',
                        confirmButtonText: 'Aceptar'
                    }).then((result) => {
                        window.location.href = '../VISTADC/MOD_PROVEEDOR.php';
                    });
                } else {
                
                    Swal.fire({
                        title: 'Error',
                        text: response.message,
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    }).then((result) => {
                    });
                }
            } else {
                Swal.fire({
                    title: 'Error',
                    text: 'Hubo un error en el servidor',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            }
        }
    };
    xhr.send(formData);
});
</script>
</html>


