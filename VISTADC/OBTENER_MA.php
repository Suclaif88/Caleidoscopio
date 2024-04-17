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
    
    $usuario=$_SESSION["nombre"];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Solicitud de Materiales</title>
    <link rel="stylesheet" href="../CSS/CSSCO.css">
    <link rel="stylesheet" href="../CSS/CSSDC.css">
    <link rel="stylesheet" href="../CSS/COT.css">
    <link rel="stylesheet" href="../CSS/responsive.css">
    <link rel="icon" type="image/png" href="../IMG/favicon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

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
            width: 90%;
            margin: 5vh auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
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

        .select-btn {
            justify-content: space-between;
            cursor: pointer;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-sizing: border-box;
            background-color: #fff;
        }

        .select-btn .btn-text {
            font-size: 17px;
            font-weight: 400;
            color: #333;
        }

        .select-btn .arrow-dwn {
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

        .select-btn.open .arrow-dwn {
            transform: rotate(-180deg);
        }

        .list-items {
            position: relative;
            margin-top: 8px;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
            display: none;
        }

        .select-btn.open ~ .list-items {
            display: block;
        }

        .list-items .item {
            display: flex;
            align-items: center;
            list-style: none;
            height: 50px;
            cursor: pointer;
            transition: 0.3s;
            position: relative;
            left: -20px;
        }

        .list-items .item:hover {
            background-color: rgba(230, 186, 73, 0.5);
        }

        .item .item-text {
            font-size: 16px;
            font-weight: 400;
            color: #333;
            position: relative;
            left: 20px;
        }

        .item .item-price {
            font-size: 16px;
            font-weight: 400;
            color: #333;
            margin-left: auto;
            margin-right: 20px;
        }

        .item .checkbox {
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

        .item.checked .checkbox {
            background-color: #4070f4;
            border-color: #4070f4;
        }

        .checkbox .check-icon {
            color: #fff;
            font-size: 11px;
            transform: scale(0);
            transition: all 0.2s ease-in-out;
        }

        .item.checked .check-icon {
            transform: scale(1);
        }

        .list-items.scrollable {
            max-height: 200px;
            overflow-y: auto;
        }

        .search-container.open {
            display: block;
            margin: auto;
            height: 50px;
            border: none;
        }

        .search-input {
            width: calc(100% - 40px);
            margin-bottom: 10px;
            border-radius: 10px;
            padding: 10px;
        }

        .material-fields {
            margin-top: 20px;
        }

        .material-fields div {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
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
            width: 150px;
        }

        input[readonly] {
            background-color: transparent;
            color: #333;
            border: none;
            font-size: 20px;
        }

        #materiales {
            width: 100%;
        }

        @media only screen and (max-width: 768px) {
            form {
                width: 90%;
            }
        }

        @media only screen and (max-width: 480px) {
            form {
                width: 100%;
            }

            .item .item-text {
                font-size: 14px;
            }

            .item .item-price {
                font-size: 14px;
            }

            .material-fields label {
                width: 80px;
            }

            .material-fields input[type="number"],
            .material-fields input[type="text"] {
                width: 120px;
            }

            input[readonly] {
                font-size: 16px;
            }
        }
</style>
</head>
<body>
<br>
<div class="contobtenerma">
    <h1>Solicitud de Materiales</h1>
    <form action="../PHP/PROCESAR_SOLICITUD.php" method="post" class="solicitud">
        <!-- Obtener proveedor preseleccionado de la URL -->
        <?php
        $proveedor = '';
        $obra_id = '';

        if (isset($_GET['proveedor'])) {
            $proveedor = $_GET['proveedor'];
        }
        if (isset($_GET['obra_id'])) {
            $obra_id = $_GET['obra_id'];
        }
        ?>

        <div id="materiales">
            <div class="materiales">
                <div class="select-btn">
                    <span class="btn-text">Seleccione Materiales</span>
                    <span class="arrow-dwn">
                        <i class="fas fa-chevron-down"></i>
                    </span>
                </div>
                <ul class="list-items">
                    <div class="search-container">
                        <input type="text" class="search-input" placeholder="Buscar Materiales">
                    </div>
                    <?php

                    if ($conexion->connect_error) {
                        die("Error de conexión: " . $conexion->connect_error);
                    }

                    $sql = "SELECT id, material, descripcion, precio FROM cotizaciones WHERE proveedor = '$proveedor'";
                    $resultado = $conexion->query($sql);

                    if ($resultado->num_rows > 0) {
                        while ($row = $resultado->fetch_assoc()) {
                            echo '<li class="item" data-id="' . $row["id"] . '">
                                <span class="checkbox">
                                    <i class="check-icon fas fa-check"></i>
                                </span>
                                <span class="item-text">' . $row["material"] . '</span>
                                <span class="item-price">' . $row["precio"] . '</span>
                            </li>';
                        }
                    } else {
                        echo "<li>Sin resultados</li>";
                    }

                    $conexion->close();
                    ?>
                </ul>
                <div class="material-fields"></div>
            </div>
        </div>

        <!-- Campos ocultos para enviar el resto de la informacion -->
        <input type="hidden" name="proveedor" value="<?php echo htmlspecialchars($proveedor); ?>">
        <input type="hidden" name="obra_id" value="<?php echo htmlspecialchars($obra_id); ?>">
        <input type="hidden" name="usuario" value="<?php echo htmlspecialchars($usuario); ?>">
        <button class="btn1 div2" type="submit"><em>Enviar Solicitud</em></button><br>
        <button class="btn1 div2"><em><a href="COTIZACION.php">Volver</a></em></button>
    </form>
</div>

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
    const existingMaterialInput = document.querySelector(`input[name="material_nombre[]"][value="${materialName}"]`);
    if (existingMaterialInput) {
        return;
    }

    const materialDiv = document.createElement("div");
    materialFields.appendChild(materialDiv);

    const materialInput = document.createElement("input");
    materialInput.setAttribute("value", materialName);
    materialInput.setAttribute("name", "material_id[]");
    materialInput.setAttribute("readonly", "");
    materialDiv.appendChild(materialInput);

    const labelCantidad = document.createElement("label");
    labelCantidad.setAttribute("for", "cantidad");
    labelCantidad.textContent = `Cantidad:`;
    materialDiv.appendChild(labelCantidad);

    const inputCantidad = document.createElement("input");
    inputCantidad.setAttribute("type", "number");
    inputCantidad.setAttribute("name", "cantidad[]");
    inputCantidad.setAttribute("required", "");
    materialDiv.appendChild(inputCantidad);

    const labelUnidad = document.createElement("label");
    labelUnidad.setAttribute("for", "unidad");
    labelUnidad.textContent = `Unidad:`;
    materialDiv.appendChild(labelUnidad);

    const inputUnidad = document.createElement("input");
    inputUnidad.setAttribute("type", "text");
    inputUnidad.setAttribute("name", "unidad[]");
    inputUnidad.setAttribute("required", "");
    materialDiv.appendChild(inputUnidad);

    const inputMaterial = document.createElement("input");
    inputMaterial.setAttribute("type", "hidden");
    inputMaterial.setAttribute("name", "material_nombre[]");
    inputMaterial.setAttribute("value", materialName);
    materialDiv.appendChild(inputMaterial);
}



    selectBtn.addEventListener("click", () => {
        selectBtn.classList.toggle("open");
        searchContainer.classList.toggle("open");

        if (selectBtn.classList.contains("open")) {
            listItems.scrollTop = 0; 
        }
    });

    items.forEach((item) => {
    item.addEventListener("click", () => {
        item.classList.toggle("checked");

        let checked = document.querySelectorAll(".checked"),
            btnText = document.querySelector(".btn-text");

        if (checked && checked.length > 0) {
            if (checked.length > 6 ) {
                btnText.innerText = `${checked.length} Seleccionados`;
            } else {
                btnText.innerText = `${checked.length} Seleccionados: ${Array.from(checked)
                    .map((item) => item.querySelector(".item-text").textContent)
                    .join(", ")}`;
            }
        } else {
            btnText.innerText = "Seleccionar Material";
        }

        const checkedMaterials = Array.from(checked).map((item) => item.querySelector(".item-text").textContent);

        checkedMaterials.forEach((materialName) => {
            createFieldsForMaterial(materialName);
        });

        const materialDivs = document.querySelectorAll(".material-fields > div");
        materialDivs.forEach((materialDiv) => {
            const materialName = materialDiv.querySelector("input[name='material_id[]']").value;
            if (!checkedMaterials.includes(materialName)) {
                materialDiv.remove();
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
            item.classList.remove("hidden");
        } else {
            item.classList.add("hidden");
        }
    });
});

    if (listItems.children.length > 3) {
        listItems.classList.add("scrollable");
    }
});

</script>
</body>
</html>
