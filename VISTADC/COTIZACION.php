<?php 
require_once("../PHP/REALIZAR_BUSQUEDA.php");
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cotizaciones</title>
    <link rel="stylesheet" href="../CSS/CSSCO.css">
    <link rel="stylesheet" href="../CSS/CSS.css">
    <link rel="stylesheet" href="../CSS/COT.css">
    <link rel="stylesheet" href="../CSS/responsive.css">
    <link rel="icon" type="image/png" href="../IMG/favicon.png">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        #formulario-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100px;
            margin-bottom: 20px;
        }
        #title{
            text-align: center;
            margin: 3vh;
        }
        form {
    max-width: 900px;
    width: 100%;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #f9f9f9;
    margin: 0 auto;
}

        .parent{
            display: flex;
            gap: 10px;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        select,
        input[type="number"],
        input[type="text"] {
            width: calc(100% - 0px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        .custom-submit {
    width: 100px;
    margin-left: 10px;
    margin-bottom: 8px;
    padding: 10px;
    color: black;
    border: black 2px solid;
    border-radius: 5px;
    cursor: pointer;
    background: #f0c760;
    background-image: -webkit-linear-gradient(top, #f0c760, #d6941a);
    background-image: -moz-linear-gradient(top, #f0c760, #d6941a);
    background-image: -ms-linear-gradient(top, #f0c760, #d6941a);
    background-image: -o-linear-gradient(top, #f0c760, #d6941a);
    background-image: linear-gradient(to bottom, #f0c760, #d6941a);
}


        input[type="submit"] {
            width: 100%;
            padding: 10px;
            color: black;
            border: black 2px solid;
            border-radius: 5px;
            cursor: pointer;
            background: #f0c760;
            background-image: -webkit-linear-gradient(top, #f0c760, #d6941a);
            background-image: -moz-linear-gradient(top, #f0c760, #d6941a);
            background-image: -ms-linear-gradient(top, #f0c760, #d6941a);
            background-image: -o-linear-gradient(top, #f0c760, #d6941a);
            background-image: linear-gradient(to bottom, #f0c760, #d6941a);
        }

        input[type="submit"]:hover {
            background: #777777;
            background-image: -webkit-linear-gradient(top, #777777, #000000);
            background-image: -moz-linear-gradient(top, #777777, #000000);
            background-image: -ms-linear-gradient(top, #777777, #000000);
            background-image: -o-linear-gradient(top, #777777, #000000);
            background-image: linear-gradient(to bottom, #777777, #000000);
            text-decoration: none;
        }
        .container {
            width: 100%; 
            max-width: 900px; 
            margin: 0 auto; 
            display: grid;
            grid-template-columns: 1fr;
            grid-gap: 20px;
            margin-top: 20px;
        }

        .container form {
            width: 100%; 
        }

        .container form table {
            width: 100%; 
            max-width: 800px; 
            margin: 0 auto; 
            table-layout: auto;
        }

.container form table th,
.container form table td {
            padding: 8px; 
            white-space: nowrap; 
            overflow: hidden; 
            text-overflow: ellipsis;
        }

.container form table th {
            background-color: #f0f0f0; 
        }
.t{
            width: 100%;
            margin-top:5vh;
        }

.input-group-item textarea[name="descripcion[]"] {
        width: calc(100% - 20px);
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
        overflow: auto;
    }

#loader {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  z-index: 9999;
  display: flex;
  justify-content: center;
  align-items: center;
}
#loader img {
  width: 50px;
  height: 50px;
}
#loader p {
  margin-top: 10px;
  font-size: 18px;
  color: #ffffff;
}

        
    </style>
</head>

<body>
    <div class="navbar">
        <h1 style="cursor:default;">COTIZACIONES</h1>
        <ul>
            <li><a href="SOLICITUDES.php">Solicitudes</a></li>
            <li><a href="OBRAS.php">Obras</a></li>
            <li><a href="" style="color:white;">Cotizaciones</a></li>
            <li><a href="DC.php">Inicio</a></li>
        </ul>
    </div>
    <!-- Botones adicionales -->
    <br><br>
    <div class="parent table-container">
        <button type="button" onclick="window.location.href='AGG_MA.php'" class="v t">Agregar material</button>
        <button type="button" onclick="window.location.href='AGG_PRO.php'" class="v t">Agregar proveedor</button>
        <button type="button" onclick="window.location.href='MOD_PRECIO.php'" class="v t">Editar precios</button>
        <button type="button" onclick="window.location.href='AGG_CO.php'" class="v t">Agregar productos</button>
    </div>
    </div>
</div>
    <!-- busqueda de materiales -->
    <div class="table-container">
    <div class="form-container">
        <form action="#" method="post" class="input-group" id="searchForm">
            <input type="text" name="busqueda" id="busqueda" placeholder="Búsqueda de materiales" class="form-control">
            <input type="button" value="Buscar" class="custom-submit" onclick="realizarBusqueda()">
        </form>    
<!--Borrar los resultados -->
<!-- Contenedor del botón de borrar resultados -->
<div id="contenedorBotonBorrar" style="display: none;">
    <form id="formulario_borrar" action="" method="post" class="input-group">
        <button type="button" onclick="confirmacionBorrado()" class="v t">Borrar resultados</button>
    </form>
</div>
        <div id="loader" style="display: none;">
            <img src="../IMG/loader.gif" alt="Cargando...">
            <p>Cargando...</p>
        </div>
    </div>
</div>

<div id="resultadosBusqueda">
    <!--Aqui se muestran los resultados enviados por el php-->
</div>


<br>
            <div class="cotcont">
                <div>
                 <form id="formulario-cotizacion" action="../PHP/PROCESAR_SOLICITUD.php" method="post">
                 <input type="submit" value="Enviar Materiales" onclick="validarCotizacion(materialesSeleccionados)" class="btn2">
                    <?php if (!empty($cotizacion)) : ?>
                        <?php echo $cotizacion; ?>
                    <?php else : ?>
                        <p>No hay cotizaciones disponibles.</p>
                    <?php endif; ?>
                    
                    <select id="obra" name="obra_id" required>
                        <option value="">Seleccione una obra</option>
                        <?php

                        require_once("../PHP/CONN.php");

                        if ($conexion->connect_error) {
                            die("Error de conexión: " . $conexion->connect_error);
                        }

                        $sql = "SELECT id, nombre FROM obras";
                        $resultado = $conexion->query($sql);

                        if ($resultado->num_rows > 0) {
                            while ($fila = $resultado->fetch_assoc()) {
                                echo "<option value='".$fila['id']."'>".$fila['nombre']."</option>";
                            }
                        } else {
                            echo "<option value=''>No hay obras disponibles</option>";
                        }

                        ?>
                    </select>
                   
                </form>
                </div>
            </div>
        </div>
    
    </div>
</div>
</div>
<div class="input-group">
            
    </div>

<br><br>
</body>
<script src="../JS/app.js"></script>
</html>
