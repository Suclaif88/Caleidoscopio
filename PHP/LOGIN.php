<?php

session_start();
require_once "CONN.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ID = $_POST['id'];
    $PASS = $_POST['pass'];

    $consulta = "SELECT * FROM usuarios WHERE identificacion = '$ID' AND contrasena = '$PASS'";
    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $fila = mysqli_fetch_assoc($resultado);
        $USER_NAME = $fila["nombre"];

        $_SESSION["nombre"] = $USER_NAME;

        if ($fila["rol"] === '1') {
            header("Location: ../controlador.html");
        }
        elseif($fila["rol"] === '2') {
            header("Location: ../GE.html");
        }
        elseif($fila["rol"] === '3') {
            header("Location: ../VISTAS/DC.php");
        }
        elseif($fila["rol"] === '4') {
            header("Location: ../DO.html");
        }
        elseif($fila["rol"] === '5') {
            header("Location: ../RE.html");
        }
    } else {
        echo "<script>alert('Error en las credenciales de inicio de sesión');</script>";
        echo "<script>window.location.href='../INDEX.html';</script>";
        
    }
}