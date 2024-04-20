<?php
session_start();
require_once('CONN.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ID = $_POST['id'];
    $PASS = $_POST['pass'];

    $consulta = "SELECT nombre, rol FROM usuarios WHERE id = :id AND pass = :pass";
    
    $stmt = $conexion->prepare($consulta);
    
    $stmt->bindParam(':id', $ID);
    $stmt->bindParam(':pass', $PASS);
    
    $stmt->execute();

    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($resultado) {
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