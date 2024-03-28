<?php
session_start();
require_once "CONN.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ID = $_POST['id'];
    $PASS = $_POST['pass'];

    $consulta = "SELECT * FROM usuarios WHERE identificacion = ? AND contrasena = ?";
    $stmt = mysqli_prepare($conexion, $consulta);
    mysqli_stmt_bind_param($stmt, "ss", $ID, $PASS);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $fila = mysqli_fetch_assoc($resultado);
        $USER_NAME = $fila["nombre"];
        $USER_ROL = $fila["rol"];
        
        $_SESSION["nombre"] = $USER_NAME;
        $_SESSION["rol"] = $USER_ROL;

        switch ($USER_ROL) {
            case '1':
                header("Location: ../ADMIN/ADMIN.php");
                break;
            case '2':
                header("Location: ../VISTAGE/GE.php");
                break;
            case '3':
                header("Location: ../VISTADC/DC.php");
                break;
            case '4':
                header("Location: ../VISTADO/DOU.php");
                break;
            case '5':
                header("Location: ../VISTARE/RE.php");
                break;
            default:
                header("Location: ../INDEX.html");
        }
    } else {
        echo "<script>alert('Error en las credenciales de inicio de sesión');</script>";
        echo "<script>window.location.href='../INDEX.html';</script>";
    }
}