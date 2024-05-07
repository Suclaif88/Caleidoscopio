var materialesSeleccionados = []; // Array de materiales seleccionados

// Función para validar la cotización
function validarCotizacion(materialesSeleccionados) {
    document.getElementById('formulario-cotizacion').addEventListener('submit', function(event) {
        event.preventDefault();

        var formData = new FormData(this);

        for (var i = 0; i < materialesSeleccionados.length; i++) {
            formData.append('materialesSeleccionados[]', materialesSeleccionados[i]);
        }

        var xhr = new XMLHttpRequest();
        xhr.open('POST', '../PHP/PROCESAR_SOLICITUD.php', true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                console.log(xhr.responseText);
            } else {
                console.error('Error al procesar la solicitud');
            }
        };
        xhr.send(formData);
    });
}

function seleccionar(btn, idMaterial) {
    var fila = btn.parentNode.parentNode;
    var material = fila.cells[0].innerText;
    var descripcion = fila.cells[1].innerText;
    var unidad = fila.cells[2].innerText;
    var precio = fila.cells[3].innerText;
    var descuento = fila.cells[4].innerText;
    var impuesto = fila.cells[5].innerText;
    var proveedor = fila.cells[6].innerText;
    var cotizacion = document.getElementById("cotizacion");
    var nuevaFila = cotizacion.insertRow(-1);
    nuevaFila.innerHTML = "<td>" + material + "</td><td>" + descripcion + "</td><td>" + unidad + "</td><td>" + precio + "</td><td>" + descuento + "</td><td>" + impuesto + "</td><td>" + proveedor + "</td><td><button onclick='eliminarCotizacion(this, " + idMaterial + ")' class='btneliminarcot'>Eliminar</button></td>";

    materialesSeleccionados.push(parseInt(idMaterial));
    
    // console.log(materialesSeleccionados); //depuracion

    Swal.fire({
        position: "top-end",
        icon: "success",
        title: "¡Material agregado con éxito!",
        showConfirmButton: false,
        timer: 1500
    });
}




function eliminarCotizacion(btn, idMaterial) {
    var index = materialesSeleccionados.indexOf(idMaterial);
    if (index !== -1) {
        materialesSeleccionados.splice(index, 1);
    }
    var fila = btn.parentNode.parentNode;
    fila.parentNode.removeChild(fila);

    // console.log(materialesSeleccionados); // Depuración

    Swal.fire({
        position: "top-end",
        icon: "success",
        title: "¡Material eliminado con éxito!",
        showConfirmButton: false,
        timer: 1500
    });
}


    function confirmacionBorrado() {
        Swal.fire({
            title: '¿Estás seguro?',
            text: '¿Quieres borrar los resultados de busqueda?',
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