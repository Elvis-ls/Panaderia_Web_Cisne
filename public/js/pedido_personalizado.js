function incrementarCantidad(id, stock) {
    var cantidadInput = document.getElementById('cantidad_' + id);
    if (parseInt(cantidadInput.value) < stock) {
        cantidadInput.value = parseInt(cantidadInput.value) + 1;
    }
}

function decrementarCantidad(id, stock) {
    var cantidadInput = document.getElementById('cantidad_' + id);
    if (cantidadInput.value > 1) {
        cantidadInput.value = parseInt(cantidadInput.value) - 1;
    }
}