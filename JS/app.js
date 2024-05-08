var materialesSeleccionados = [];
var proveedoresSeleccionados = [];

// Función para validar la cotización
function validarCotizacion(materialesSeleccionados, proveedoresSeleccionados) {
    console.log("Materiales seleccionados:", materialesSeleccionados);
    console.log("Proveedores seleccionados:", proveedoresSeleccionados);
    
    document.getElementById('formulario-cotizacion').addEventListener('submit', function(event) {
        event.preventDefault();

        var formData = new FormData(this);

        // Agregar los materiales seleccionados al objeto formData
        for (var i = 0; i < materialesSeleccionados.length; i++) {
            formData.append('materialesSeleccionados[]', materialesSeleccionados[i]);
            formData.append('proveedoresSeleccionados[]', proveedoresSeleccionados[i]); // Agregar proveedores asociados a los materiales
        }

        // Enviar la solicitud al servidor
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

function seleccionar(btn, idMaterial, proveedor) {
    var fila = btn.parentNode.parentNode;
    var material = fila.cells[0].innerText;
    var descripcion = fila.cells[1].innerText;
    var unidad = fila.cells[2].innerText;
    var precio = fila.cells[3].innerText;
    var descuento = fila.cells[4].innerText;
    var impuesto = fila.cells[5].innerText;
    var cotizacion = document.getElementById("cotizacion");
    var nuevaFila = cotizacion.insertRow(-1);
    nuevaFila.innerHTML = "<td>" + material + "</td><td>" + descripcion + "</td><td>" + unidad + "</td><td>" + precio + "</td><td>" + descuento + "</td><td>" + impuesto + "</td><td>" + proveedor + "</td><td><button onclick='eliminarCotizacion(this, " + idMaterial + proveedor + ")' class='btneliminarcot'>Eliminar</button></td>";

    // materialesSeleccionados.push(parseInt(material)); //en caso de necesitar el idMaterial
    materialesSeleccionados.push(material); //inserta el nombre del material
    proveedoresSeleccionados.push(proveedor); //inserta el proveedor seleccionado
    
    // console.log(materialesSeleccionados); //Activar para ver el array

    Swal.fire({
        position: "top-end",
        icon: "success",
        title: "¡Material agregado con éxito!",
        showConfirmButton: false,
        timer: 1500
    });
}


function eliminarCotizacion(btn, idMaterial) {
    var index = -1;
    for (var i = 0; i < materialesSeleccionados.length; i++) {
        if (materialesSeleccionados[i].id === idMaterial) {
            index = i;
            break;
        }
    }
    if (index !== -1) {
        materialesSeleccionados.splice(index, 1);
    }
    var fila = btn.parentNode.parentNode;
    fila.parentNode.removeChild(fila);

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
    

function eliminarCotizacion(btn, idMaterial) {
    var index = -1;
    for (var i = 0; i < materialesSeleccionados.length; i++) {
        if (materialesSeleccionados[i].id === idMaterial) {
            index = i;
            break;
        }
    }
    if (index !== -1) {
        materialesSeleccionados.splice(index, 1);
    }
    var fila = btn.parentNode.parentNode;
    fila.parentNode.removeChild(fila);

    // Actualizar la visualización o cualquier otra acción necesaria...
}

function confirmacionBorrado() {
    Swal.fire({
        title: '¿Estás seguro?',
        text: '¿Quieres borrar los resultados de búsqueda?',
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

document.getElementById("searchForm").addEventListener("submit", function(event) {
    event.preventDefault();
    mostrarLoader();
});

function mostrarLoader() {
    document.getElementById("loader").style.display = "flex";
    setTimeout(function() {
        document.getElementById("searchForm").submit();
    }, 500);
}
