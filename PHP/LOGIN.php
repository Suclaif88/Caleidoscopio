<?php
session_start();
require_once(base64_decode('Q09OTi5waHA='));

if ($_SERVER[base64_decode('UkVRVUVTVF9NRVRIT0Q=')] == base64_decode('UE9TVA==')) {
    $ID = $_POST[base64_decode('aWQ=')];
    $PASS = $_POST[base64_decode('cGFzcw==')];

    $consulta = base64_decode('U0VMRUNUICogRlJPTSB1c3VhcmlvcyBXSEVSRSBpZGVudGlmaWNhY2lvbiA9ID8gQU5EIGNvbnRyYXNlbmEgPSA/');
    $stmt = mysqli_prepare($conexion, $consulta);
if (!$stmt) {
    die("Error al preparar la consulta: " . mysqli_error($conexion));
}

mysqli_stmt_bind_param($stmt, "ss", $ID, $PASS);
mysqli_stmt_execute($stmt);

    $resultado = mysqli_stmt_get_result($stmt);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $fila = mysqli_fetch_assoc($resultado);

        $USER_NAME = $fila[base64_decode('bm9tYnJl')];
        $USER_ROL = $fila[base64_decode('cm9s')];
        
        $_SESSION[base64_decode('bm9tYnJl')] = $USER_NAME;
        $_SESSION[base64_decode('cm9s')] = $USER_ROL;

        switch ($USER_ROL) {
            case base64_decode('MQ=='):
                header(base64_decode('TG9jYXRpb246IC4uL0FETUlOL0FETUlOLnBocA=='));
                break;
            case base64_decode('Mg=='):
                header(base64_decode('TG9jYXRpb246IC4uL1ZJU1RBR0UvR0UucGhw'));
                break;
            case base64_decode('Mw=='):
                header(base64_decode('TG9jYXRpb246IC4uL1ZJU1RBREMvREMucGhw'));
                break;
            case base64_decode('NA=='):
                header(base64_decode('TG9jYXRpb246IC4uL1ZJU1RBRE8vRE9VLnBocA=='));
                break;
            case base64_decode('NQ=='):
                header(base64_decode('TG9jYXRpb246IC4uL1ZJU1RBUkUvUkUucGhw'));
                break;
            default:
                echo base64_decode('PGRpdiBhbGVydCAnRXN0ZSB1c3VhcmlvIG5vIHRvIGltcG9ydGEgcXVpIHBlcmNhZGFkb3MhJzsgPGRpdiB3aW5kb3cuY2xvc2UuYWRkRXN0aW9uKCdodHRwczovLycpOyA+');
                echo base64_decode('PGRpdiB3aW5kb3cuY2xvc2UuZm9ybWF0KCRfR0VUWydJTlRFUk5BTUUnXSk7IDwvZGl2Pg==');
        }
    } else {
        echo base64_decode('PGRpdiBhbGVydCAnRXJyb3IgZW4gbGFzIGNyZWRlbmNpYWxlcyBkZSBpbmljaWFkYXMgZGUgaW5pdGlkYWRhJzsgPGRpdiB3aW5kb3cuY2xvc2UuZm9ybWF0KCRfR0VUWydJTlRFUk5BTUUnXSk7IDwvZGl2Pg==');
        echo base64_decode('PGRpdiB3aW5kb3cuY2xvc2UuZm9ybWF0KCRfR0VUWydJTlRFUk5BTUUnXSk7IDwvZGl2Pg==');
    }
}
/*ARREGLAR LOS MENSAJES DE ERRORES*/