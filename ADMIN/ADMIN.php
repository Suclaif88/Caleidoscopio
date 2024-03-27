<?php
session_start();

if(!isset($_SESSION["nombre"])){
    header("Location:../INDEX.html");
    exit();
}
$usuario=$_SESSION["nombre"];

if($_SESSION["rol"] !== "1") {
    header("Location: ../INDEX.html");
    exit();
}

require_once("../PHP/CONN.php");

$sql = "SELECT * FROM usuarios";
$result = mysqli_query($conexion, $sql);

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

require_once("../PHP/CONN.php");
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
<header class="cabeza"><h1>ADMINISTRADOR, <?php echo $usuario; ?></h1></header>
<body>






<div class="users-form">
    <h1>Crear usuario</h1>
    <form action="../PHP/INSERTAR_USER.php" method="POST">
        <input type="text" name="identificacion" placeholder="Identificacion" required>
        <input type="text" name="nombre" placeholder="Nombre" required>
        <input type="email" name="correo" placeholder="Correo" required>
        <input type="password" name="contrasena" placeholder="Contraseña" required>
        <select id="perfil" name="rol" required>
            <option value="" disabled selected>SELECCIONE PERFIL</option>
            <option value="1">1.Admin</option>
            <option value="2">2.Gerente</option>
            <option value="3">3.Director de Compra</option>
            <option value="4">4.Director de Obra</option>
            <option value="5">5.Residente</option>
        </select>
        <input type="submit" value="Agregar">
    </form>
</div>







<div class="users-table">
        <h1>Usuarios registrados</h1>
        <br>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>IDENTIFICACION</th>
                    <th>NOMBRE</th>
                    <th>EMAIL</th>
                    <th>CONTRASEÑA</th>
                    <th>ROL</th>
                    

                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $result = mysqli_query($conexion, "SELECT * FROM usuarios");
                while ($row = mysqli_fetch_array($result)): 
                    // Obtener el valor del campo "rol" de la fila actual
                    $numeroRol = $row['rol'];
                    // Convertir el número de rol en letras utilizando la función obtenerRol
                    $rolEnLetras = obtenerRol($numeroRol);
                ?>
                    <tr>
                        <th><?= $row['id'] ?></th>
                        <th><?= $row['identificacion'] ?></th>
                        <th><?= $row['nombre'] ?></th>
                        <th><?= $row['email'] ?></th>
                        <th><?= $row['contrasena'] ?></th>
                        <th><?= $rolEnLetras ?></th>
                        <th><a href="../ADMIN/UPDATE.php?id=<?= $row['id'] ?>" class="users-table--edit">Editar</a></th>
                        <th><a href="../PHP/DELETE_USER.php?id=<?= $row['id'] ?>" class="users-table--delete" >Eliminar</a></th>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>


<div class="botones">
<button class="btn1 div5" onclick="window.location.href='../PHP/LOGOUT.php'">Cerrar Sesion</button>
</div>

<br>

<footer class="footer">
        <p>&copy; Caleidoscopio 2024 - Todos los derechos reservados</p>
</footer>


</body>
</html>