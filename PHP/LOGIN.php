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
        $USER_ROL = $fila["rol"];
        
        $_SESSION["nombre"] = $USER_NAME;
        $_SESSION["rol"] = $USER_ROL;

        if ($USER_ROL === '1') {
            header("Location: ../ADMIN/ADMIN.php");
        }
        elseif($USER_ROL === '2') {
            header("Location: ../VISTAGE/GE.php");
        }
        elseif($USER_ROL === '3') {
            header("Location: ../VISTADC/DC.php");
        }
        elseif($USER_ROL === '4') {
            header("Location: ../VISTADO/DOU.php");
        }
        elseif($USER_ROL === '5') {
            header("Location: ../VISTARE/RE.php");
        }
    } else {
        echo "<script>alert('Error en las credenciales de inicio de sesión');</script>";
        echo "<script>window.location.href='../INDEX.html';</script>";
    }
}