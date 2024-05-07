function validarCotizacion(){
    document.getElementById('formulario-cotizacion').addEventListener('submit', function(event) {
        event.preventDefault();
    
        var formData = new FormData(this);
    
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '../PHP/PROCESAR_SOLICITUD.php', true);
        xhr.onload = function () {
            if (xhr.status === 200) {
                console.log(xhr.responseText);
            } else {
                console.error('Error al procesar la solicitud');
            }
        };
        xhr.send(formData);
    });
}

var materialesSeleccionados = []; // Aca se guardan los id de los materiales seleccionados (array)

function seleccionar(btn) {
    var fila = btn.parentNode.parentNode;
    var idMaterial = fila.cells[0].innerText.trim();
    var material = fila.cells[1].innerText;
    var descripcion = fila.cells[2].innerText;
    var unidad = fila.cells[3].innerText;
    var precio = fila.cells[4].innerText;
    var descuento = fila.cells[5].innerText;
    var impuesto = fila.cells[6].innerText;
    var proveedor = fila.cells[7].innerText;
    var cotizacion = document.getElementById("cotizacion");
    var nuevaFila = cotizacion.insertRow(-1);
    nuevaFila.innerHTML = "<td>" + material + "</td><td>" + descripcion + "</td><td>" + unidad + "</td><td>" + precio + "</td><td>" + descuento + "</td><td>" + impuesto + "</td><td>" + proveedor + "</td><td><button onclick='eliminarCotizacion(this)' class='btneliminarcot'>Eliminar</button></td>";

    Swal.fire({
        position: "top-end",
        icon: "success",
        title: "¡Material agregado con éxito!",
        showConfirmButton: false,
        timer: 1500
    });
}



function eliminarCotizacion(btn) {
    var fila = btn.parentNode.parentNode;
    fila.parentNode.removeChild(fila);
    console.log(materialesSeleccionados);

    Swal.fire({
        title: "¡Eliminado!",
        text: "Se eliminó el elemento con éxito",
        icon: "success"
    });
}




//arreglar la obtencion de los id








function agregarCotizacion() {
    var tabla = document.getElementById("cotizaciones").getElementsByTagName('tbody')[0];
    var nuevaFila = tabla.insertRow(-1);
    nuevaFila.innerHTML = `
        <td>
            <select name="material_id[]" required>
                <option value="">Seleccione un material</option>
                <?php
                $consulta = "SELECT id, material FROM agregar_materiales";
                $resultado = mysqli_query($conexion, $consulta);
                while ($fila = mysqli_fetch_assoc($resultado)) {
                    echo "<option value='" . $fila['id'] . "'>" . $fila['material'] . "</option>";
                }
                ?>
            </select>
        </td>
        <td><input type="text" name="descripcion[]" required></td>
        <td><input type="text" name="unidad[]" required></td>
        <td><input type="number" name="precio[]" required></td>
        <td><input type="text" name="descuento[]" required></td>
        <td><input type="number" name="impuestos[]" required></td>
        <td>
            <select name="proveedor_id[]" required>
            <option value="">Seleccione un proveedor</option>
                <?php
                $consulta = "SELECT id, proveedor FROM proveedores";
                $resultado = mysqli_query($conexion, $consulta);
                while ($fila = mysqli_fetch_assoc($resultado)) {
                    echo "<option value='" . $fila['id'] . "'>" . $fila['proveedor'] . "</option>";
                }
                ?>
            </select>
        </td>
        <td><button type="button" onclick="eliminarCotizacion(this)">Eliminar</button></td>
    `;
}

    function confirmacionBorrado() {
        Swal.fire({
            title: '¿Estás seguro?',
            text: '¿Quieres borrar los resultados?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, borrar resultados',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                setTimeout(function() {
                    document.getElementById("formulario_borrar").submit();
                }, 2000);
                Swal.fire(
                    'Borrado!',
                    'Los resultados han sido borrados exitosamente.',
                    'success'
                );
            }
        });
    }