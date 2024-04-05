<?php
    session_start();
    if(!isset($_SESSION["nombre"])){
        header("Location:../INDEX.html");
        exit();
    }
    if(strval($_SESSION["rol"]) !== "5") {
        header("Location: ../INDEX.html");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Solicitud de Materiales</title>
    <link rel="stylesheet" href="../CSS/CSSCO.css">
    <link rel="stylesheet" href="../CSS/CSSDC.css">
    <link rel="stylesheet" href="../CSS/responsive.css">
    <link rel="icon" type="image/png" href="../IMG/favicon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</head>
<body>
<style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px 0;
        }

        form {
            max-width: 600px;
            margin: 5vh;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
            margin-top: 20px;
            background-color: #ccc;
        }

        form label {
            font-weight: bold;
        }

        form select, form input[type="text"], form input[type="number"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
        }
        h4{
            text-align: center;
            text-decoration: none;
            color: black;
            margin-top: 4vh:
        }

        .select-btn{


            justify-content: space-between;
            cursor: pointer;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 8%px;
            box-sizing: border-box;
            background-color: #fff;
        }
        .select-btn .btn-text{
            font-size: 17px;
            font-weight: 400;
            color: #333;
        }
        .select-btn .arrow-dwn{
            display: flex;
            height: 14px;
            width: 14px;
            color: #000;
            position: relative;
            top: 4px;
            font-size: 11px;
            border-radius: 50%;
            background: #fff;
            align-items: center;
            justify-content: center;
            transition: 0.3s;
        }
        .select-btn.open .arrow-dwn{
            transform: rotate(-180deg);
        }
        .list-items{
            position: relative;
            margin-top: 8px;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
            display: none;
        }
        .select-btn.open ~ .list-items{
            display: block;
        }
        .list-items .item{
            display: flex;
            align-items: center;
            list-style: none;
            height: 50px;
            cursor: pointer;
            transition: 0.3s;
            position: relative;
            left: -20px;
        }
        .list-items .item:hover{
            background-color: rgba(230, 186, 73, 0.5);
        }
        .item .item-text{
            font-size: 16px;
            font-weight: 400;
            color: #333;
            position: relative;
            left: 20px;
        }
        .item .checkbox{
            display: flex;
            align-items: center;

            height: 16px;
            width: 16px;
            border-radius: 4px;
            margin-right: 12px;
            border: 1.5px solid #c0c0c0;
            transition: all 0.3s ease-in-out;
            position: relative;
            left: 10px;
        }
        .item.checked .checkbox{
            background-color: #4070f4;
            border-color: #4070f4;
        }
        .checkbox .check-icon{
            color: #fff;
            font-size: 11px;
            transform: scale(0);
            transition: all 0.2s ease-in-out;
        }
        .item.checked .check-icon{
            transform: scale(1);
        }

        .list-items.scrollable {
            max-height: 200px; /* ajusta según sea necesario */
            overflow-y: auto;
        }

  
        .search-container.open {
            display: block;
        }
  
        .search-input {
            width: 100%;
            margin-bottom: 10px;
            border: none;
            border-radius: 10px;
            position: relative;
            left: -16px;
        }


        .material-fields {
            margin-top: 20px;
        }
  
        .material-fields div {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            height: auto;
            width: auto;
        }
  
        .material-fields label {
            margin-right: 10px;
            width: 100px;
        }
  
        .material-fields input[type="number"],
        .material-fields input[type="text"] {
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            width: auto;
        }

        input[readonly] {

            background-color: transparent;
            color: #333;
            border: none;
            font-size: 20px;
            width: 100%;
            color: #000;

        }

    </style>
    <header class="navbar">
        <h1>Nueva Solicitud de Materiales</h1>
        <ul>
        <li><a href="DEVOLUCIONES.php">Devoluciones</a></li>
        <li><a href="OBRASRE.php">Obras</a></li>
        <li><a href="" style="color:white;">Solicitud de compra</a></li>
        <li><a href="RE.php">Atras</a></li>
    </ul>
    </header>
    <br>
    <div>
        <h4><button class="btn1" onclick="window.location.href='FURG.php'">Formulario de emergencia</a></h4>
    </div>
    
    <form action="../PHP/AGGSO.php" method="post" class="solicitud">
        <label for="usuario">Nombre de Usuario:</label>
        <input type="text" id="usuario" name="usuario" required>
        
        <label for="obra">Obra:</label>
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
        </select><br><br>
        <div id="productos">
            <div>
                <label for="producto">Materiales:</label>
    <div class="select-btn">

        <span class="btn-text">Seleccione Materiales</span>
        <span class="arrow-dwn">
            <i class="fa-solid fa-chevron-down"></i>
        </span>

    </div>

    <ul class="list-items">
        <div class="search-container">
            <input type="text" class="search-input" placeholder="Buscar Materiales">
        </div>

            <?php
            require_once("../PHP/CONN.php");

            if ($conexion->connect_error) {
                die("Error de conexión: " . $conexion->connect_error);
            }

            $sql = "SELECT id, material FROM agregar_materiales";
            $resultado = $conexion->query($sql);

        if ($resultado->num_rows > 0) {
            while ($row = $resultado->fetch_assoc()) {
                echo '<li class="item" data-id="' . $row["id"] . '">
                          <span class="checkbox">
                            <i class="fa-solid fa-check check-icon"></i>
                          </span>
                          <span class="item-text">' . $row["material"] . '</span>
                      </li>';
            }
        } else {
            echo "0 resultados";
        }
        $conexion->close();
        ?>
    </ul>
    <br>
    <div class="material-fields"></div>
    <br>


        </div>
    </div>
        <br>
        <button class="btn1 div1"type="submit"><em>Enviar Solicitud</em></button>
   </form>
    
    <script>
        document.addEventListener("DOMContentLoaded", function () {
    const selectBtn = document.querySelector(".select-btn"),
        items = document.querySelectorAll(".item"),
        searchContainer = document.querySelector(".search-container"),
        searchInput = document.querySelector(".search-input"),
        listItems = document.querySelector(".list-items"),
        form = document.querySelector(".solicitud"),
        materialFields = document.querySelector(".material-fields");

    function createFieldsForMaterial(materialName) {
        // Crear un div para agrupar los inputs relacionados con este material
        const materialDiv = document.createElement("div");
        materialFields.appendChild(materialDiv);

        
        const materialInput = document.createElement("input");
        materialInput.textContent = materialName;
        materialInput.setAttribute("value",materialName,);
        materialInput.setAttribute("name", "material_id[]");
        materialInput.setAttribute("readonly", "");
        materialInput.setAttribute("data-material", materialName); // Añadir atributo data-material
        materialDiv.appendChild(materialInput);

        const labelCantidad = document.createElement("label");
        labelCantidad.setAttribute("for", "cantidad");
        labelCantidad.setAttribute("data-material", materialName); // Añadir atributo data-material
        labelCantidad.textContent = `Cantidad:`;
        materialDiv.appendChild(labelCantidad);

        const inputCantidad = document.createElement("input");
        inputCantidad.setAttribute("type", "number");
        inputCantidad.setAttribute("name", "cantidad[]");
        inputCantidad.setAttribute("required", "");
        inputCantidad.setAttribute("data-material", materialName); // Añadir atributo data-material
        materialDiv.appendChild(inputCantidad);

        const labelUnidad = document.createElement("label");
        labelUnidad.setAttribute("for", "unidad");
        labelUnidad.setAttribute("data-material", materialName); // Añadir atributo data-material
        labelUnidad.textContent = `Unidad:`;
        materialDiv.appendChild(labelUnidad);

        const inputUnidad = document.createElement("input");
        inputUnidad.setAttribute("type", "text");
        inputUnidad.setAttribute("name", "unidad[]");
        inputUnidad.setAttribute("required", "");
        inputUnidad.setAttribute("data-material", materialName); // Añadir atributo data-material
        materialDiv.appendChild(inputUnidad);

        const inputMaterial = document.createElement("input");
        inputMaterial.setAttribute("type", "hidden");
        inputMaterial.setAttribute("name", "material[]");
        inputMaterial.setAttribute("value", materialName);
        inputMaterial.setAttribute("data-material", materialName); // Añadir atributo data-material
        materialDiv.appendChild(inputMaterial);
    }

    selectBtn.addEventListener("click", () => {
        selectBtn.classList.toggle("open");
        searchContainer.classList.toggle("open");

        // Desplazar las opciones hacia arriba al abrir el contenedor
        if (selectBtn.classList.contains("open")) {
            listItems.scrollTop = 0; // Scroll al principio
        }
    });

    items.forEach((item) => {
        item.addEventListener("click", () => {
            item.classList.toggle("checked");

            let checked = document.querySelectorAll(".checked"),
                btnText = document.querySelector(".btn-text");

            if (checked && checked.length > 0) {
                if (checked.length > 4) {
                    btnText.innerText = `${checked.length} Seleccionados`;
                } else {
                    btnText.innerText = `${checked.length} Seleccionados: ${Array.from(checked)
                        .map((item) => item.querySelector(".item-text").textContent)
                        .join(", ")}`;
                }
            } else {
                btnText.innerText = "Seleccionar Material";
            }

            checked.forEach((item) => {
                const materialName = item.querySelector(".item-text").textContent;
                const isMaterialSelected = form.querySelector(
                    `input[name="material[]"][value="${materialName}"]`
                );

                // Verificar si el material ya está seleccionado
                if (!isMaterialSelected) {
                    createFieldsForMaterial(materialName);
                }
            });

            items.forEach((item) => {
                if (!item.classList.contains("checked")) {
                    const materialName = item.querySelector(".item-text").textContent;
                    const isMaterialSelected = form.querySelector(
                        `input[name="material[]"][value="${materialName}"]`
                    );

                    if (isMaterialSelected) {
                        const labelCantidad = form.querySelector(
                            `label[for="cantidad"][data-material="${materialName}"]`
                        );
                        const inputCantidad = form.querySelector(
                            `input[name="cantidad[]"][data-material="${materialName}"]`
                        );
                        const labelUnidad = form.querySelector(
                            `label[for="unidad"][data-material="${materialName}"]`
                        );
                        const inputUnidad = form.querySelector(
                            `input[name="unidad[]"][data-material="${materialName}"]`
                        );
                        const materialInput = form.querySelector(
                            `span[name="material_id[]"][data-material="${materialName}"]`
                        );
                        const materialInputId = form.querySelector(
                            `input[name="material_id[]"][data-material="${materialName}"]`
                        );

                        if (labelCantidad) labelCantidad.remove();
                        if (inputCantidad) inputCantidad.remove();
                        if (labelUnidad) labelUnidad.remove();
                        if (inputUnidad) inputUnidad.remove();
                        if (materialInput) materialInput.remove();
                        if (materialInputId) materialInputId.remove();

                        form.querySelector(
                            `input[name="material[]"][value="${materialName}"]`
                        ).remove();
                    }
                }
            });
        });
    });

    searchInput.addEventListener("input", () => {
        const searchValue = searchInput.value.toLowerCase();

        items.forEach((item) => {
            const text = item.querySelector(".item-text").textContent.toLowerCase();
            const id = item.getAttribute("data-id");

            if (text.includes(searchValue) || id.includes(searchValue)) {
                item.style.display = "block";
            } else {
                item.style.display = "none";
            }
        });
    });

    // Agregar clase 'scrollable' si hay más de 4 materiales
    if (listItems.children.length > 3) {
        listItems.classList.add("scrollable");
    }
});


    </script>
</body>
</html>
