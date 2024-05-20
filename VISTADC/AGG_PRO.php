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

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Proveedores</title>
    <link rel="stylesheet" href="../CSS/CSSMP.css">
    <link rel="stylesheet" href="../CSS/CSSCO.css">
    <link rel="stylesheet" href="../CSS/responsive.css">
    <link rel="icon" type="image/png" href="../IMG/favicon.png">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body>
    <header class="cabeza"> 
        <div class="navbar">
            <h1>AGREGAR</h1>
             <ul>
                <li><a href="COTIZACION.php">Atras</a></li>
            </ul>
            <ul>
                <li><a href="AGG_MA.php">Materiales</a></li>
                <li><b>/</b></li>
                <li><a href="AGG_PRO.php" style="color:white;">Proveedores</a></li>
            </ul>
           
        </div>
        
    </header>
<form id="proveedorForm" action="../PHP/AGGPRO.php" method="POST">
    <label for="proveedor">Proveedor:</label>
    <input type="text" id="proveedor" name="proveedor" required><br>
    <label for="nit">Nit:</label>
    <input type="number" id="nit" name="nit"><br>
    <label for="correo">Correo:</label>
    <input type="email" id="correo" name="correo"><br>
    <label for="telefono">Teléfono:</label>
    <input type="number" id="telefono" name="telefono"><br>
    <input type="submit" class="btn" value="Agregar proveedor" style="width: 100%;">
</form>

<script>
    document.getElementById('proveedorForm').addEventListener('submit', function(event) {
        var nitInput = document.getElementById('nit');
        var correoInput = document.getElementById('correo');
        var telefonoInput = document.getElementById('telefono');

        if (nitInput.value === '') {
            nitInput.value = '0';
        }

        if (correoInput.value === '') {
            correoInput.value = '0';
        }

        if (telefonoInput.value === '') {
            telefonoInput.value = '0';
        }

        event.preventDefault();

        var formData = new FormData(this);

        fetch(this.getAttribute('action'), {
            method: this.getAttribute('method'),
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    title: 'Éxito',
                    text: data.success,
                    icon: 'success'
                }).then(() => {
                    window.location.href = 'AGG_PRO.php';
                });
            } else if (data.error) {
                Swal.fire({
                    title: 'Error',
                    text: data.error,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                title: 'Error',
                text: 'Hubo un error al procesar la solicitud',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        });
    });
</script>

</body>
</html>
