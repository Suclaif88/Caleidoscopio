function validarEnvioCotizacion() {
    var tablaSeleccionados = document.getElementById("tablaSeleccionados");
    if (tablaSeleccionados.rows.length <= 1) {
        alert("La tabla de elementos seleccionados está vacía. Agrega elementos antes de enviar la cotización.");
    } else {
        document.getElementById("formulario").submit();
    }
}

function eliminarCotizacion(btn) {
    var fila = btn.parentNode.parentNode;
    fila.parentNode.removeChild(fila);
}

function seleccionar(btn) {
    var fila = btn.parentNode.parentNode;
    var material = fila.cells[0].innerText;
    var descripcion = fila.cells[1].innerText;
    var unidad = fila.cells[2].innerText;
    var precio = fila.cells[3].innerText;
    var descuento = fila.cells[4].innerText;
    var impuesto = fila.cells[5].innerText;
    var proveedor = fila.cells[6].innerText
    var cotizacion = document.getElementById("cotizacion");
    var nuevaFila = cotizacion.insertRow(-1);
    nuevaFila.innerHTML = "<td>" + material + "</td><td>" + descripcion + "</td><td>" + unidad + "</td><td>" + precio + "</td><td>" + descuento + "</td><td>" + impuesto + "</td><td>" + proveedor + "</td><td><button onclick='eliminarCotizacion(this)' class='btneliminarcot'>Eliminar</button></td>";
    alert("Se ha agregado la cotización correctamente.");
}

function seleccionar2(btn) {
    var formulario = btn.closest('form');
    var material = formulario.querySelector('select[name="material_id[]"]').value;
    var descripcion = formulario.querySelector('textarea[name="descripcion[]"]').value;
    var unidad = formulario.querySelector('input[name="unidad[]"]').value;
    var precio = formulario.querySelector('input[name="precio[]"]').value;
    var descuento = formulario.querySelector('input[name="descuento[]"]').value;
    var impuesto = formulario.querySelector('input[name="impuesto[]"]').value;
    var proveedor = formulario.querySelector('select[name="proveedor_id[]"]').value;

    if (material === "") {
        alert("Por favor, seleccione un material.");
        return;
    }

    if (proveedor === "") {
        alert("Por favor, seleccione un proveedor.");
        return;
    }

    var tablaSeleccionados = document.getElementById("tablaSeleccionados");
    
    var nuevaFila = tablaSeleccionados.insertRow(-1);
    
    nuevaFila.innerHTML = "<td>" + material + "</td><td>" + descripcion + "</td><td>" + unidad + "</td><td>" + precio + "</td><td>" + descuento + "</td><td>" + impuesto + "</td><td>" + proveedor + "</td><td><button type='button' onclick='eliminarCotizacion(this)' class='btneliminarcot'>Eliminar</button></td>";
    alert("Se ha agregado la cotización correctamente.");
}

function limpiarCampos() {
    var formulario = document.getElementById("formulario");
    formulario.reset();
}
