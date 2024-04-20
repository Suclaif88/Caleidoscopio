<?php
session_start();
require_once('CONN.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ID = $_POST['id'];
    $PASS = $_POST['pass'];

    $ID = htmlspecialchars($ID);
    $PASS = htmlspecialchars($PASS);

    $consulta = "SELECT nombre, rol, pass FROM usuarios WHERE id = :id";
    
    $stmt = $conexion->prepare($consulta);
    
    $stmt->bindParam(':id', $ID);
    
    $stmt->execute();

    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($resultado && password_verify($PASS, $resultado['pass'])) {
        $USER_NAME = $resultado['nombre'];
        $USER_ROL = $resultado['rol'];

        $_SESSION['nombre'] = $USER_NAME;
        $_SESSION['rol'] = $USER_ROL;

        switch ($USER_ROL) {
            case '1':
                header('Location: ../ADMIN/ADMIN.php');
                break;
            case '2':
                header('Location: ../VISTA/VISTA.php');
                break;
            case '3':
                header('Location: ../VISTA/DE.php');
                break;
            case '4':
                header('Location: ../VISTA/DO.php');
                break;
            case '5':
                header('Location: ../VISTA/RE.php');
                break;
            default:
                echo "Error en las credenciales de inicio de sesión.";
                break;
        }
    } else {
        echo "Error en las credenciales de inicio de sesión.";
    }
}