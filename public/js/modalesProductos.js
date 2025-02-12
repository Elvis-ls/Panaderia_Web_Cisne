$(document).ready(function() {
    // Configuración del modal de edición
    $('#editarModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);

        // Obtener los datos del botón "Editar"
        var id = button.data('id');
        var nombre = button.data('nombre');
        var descripcion = button.data('descripcion');
        var precio = parseFloat(button.data('precio')).toFixed(2); // Formatear precio a dos decimales
        var stock = button.data('stock');
        var imagen = button.data('imagen');
        var categoria = button.data('categoria');

        // Asignar los valores a los campos del modal
        var modal = $(this);
        modal.find('#editar_id').val(id);
        modal.find('#editar_nombre').val(nombre);
        modal.find('#editar_descripcion').val(descripcion);
        modal.find('#editar_precio').val(precio);
        modal.find('#editar_stock').val(stock);
        modal.find('#imagen_actual').val(imagen);
        modal.find('#imagen_actual_text').val(imagen);
        modal.find('#imagen_actual_nombre').text(imagen);
        modal.find('#editar_categoria').val(categoria);
    });

    // Manejar el formulario de agregar producto
    $('#agregarProductoForm').on('submit', function(event) {
        event.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: '/Panaderia_Web/controller/ProductoAdminController.php?action=agregar',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.success) {
                    $('#agregarModal').modal('hide');
                    setTimeout(function() {
                        $('#mensajeModalTexto').text(response.message);
                        $('#mensajeModal').modal('show');
                        setTimeout(function() {
                            $('#mensajeModal').modal('hide');
                            location.reload(); // Recargar la página para mostrar los cambios
                        }, 2000);
                    }, 1000); // Esperar 1 segundo antes de mostrar el modal de confirmación
                } else {
                    alert(response.message);
                }
            }
        });
    });

    // Manejar el formulario de eliminación de producto
    $('#confirmarEliminarBtn').on('click', function() {
        var id = $('#confirmarEliminarModal').data('id');
        console.log('ID del producto a eliminar:', id); // Agregar este log para depurar
        $.ajax({
            url: '/Panaderia_Web/controller/ProductoAdminController.php?action=eliminar',
            type: 'POST',
            data: { id: id },
            success: function(response) {
                console.log('Respuesta del servidor:', response); // Agregar este log para depurar
                if (response.success) {
                    $('#confirmarEliminarModal').modal('hide');
                    setTimeout(function() {
                        $('#mensajeModalTexto').text(response.message);
                        $('#mensajeModal').modal('show');
                        setTimeout(function() {
                            $('#mensajeModal').modal('hide');
                            location.reload(); // Recargar la página para mostrar los cambios
                        }, 2000);
                    }, 1000); // Esperar 1 segundo antes de mostrar el modal de confirmación
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr, status, error) {
                alert('Error al eliminar el producto: ' + error);
            }
        });
    });

    // Cerrar el modal de confirmación al hacer clic en "Cerrar" o en la "x"
    $('#mensajeModal .close, #mensajeModal .btn-secondary').on('click', function() {
        $('#mensajeModal').modal('hide');
    });

    // Pasar el ID del producto al modal de confirmación de eliminación
    $('#confirmarEliminarModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        $(this).data('id', id);
    });

    // Manejar el formulario de edición de producto
    $('#editarProductoForm').on('submit', function(event) {
        event.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: '/Panaderia_Web/controller/ProductoAdminController.php?action=editar',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log('Respuesta del servidor:', response); // Agregar este log para depurar
                if (response.success) {
                    $('#editarModal').modal('hide');
                    setTimeout(function() {
                        $('#mensajeModalTexto').text(response.message);
                        $('#mensajeModal').modal('show');
                        setTimeout(function() {
                            $('#mensajeModal').modal('hide');
                            location.reload(); // Recargar la página para mostrar los cambios
                        }, 2000);
                    }, 1000); // Esperar 1 segundo antes de mostrar el modal de confirmación
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr, status, error) {
                alert('Error al editar el producto: ' + error);
            }
        });
    });

    // Pasar los datos del producto al modal de edición
    $('#editarModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var nombre = button.data('nombre');
        var descripcion = button.data('descripcion');
        var precio = button.data('precio');
        var stock = button.data('stock');
        var categoria = button.data('categoria');
        var imagen = button.data('imagen');

        var modal = $(this);
        modal.find('#editar_id').val(id);
        modal.find('#editar_nombre').val(nombre);
        modal.find('#editar_descripcion').val(descripcion);
        modal.find('#editar_precio').val(precio);
        modal.find('#editar_stock').val(stock);
        modal.find('#editar_categoria').val(categoria);
        modal.find('#imagen_actual').val(imagen);
        modal.find('#imagen_actual_text').val(imagen);
        modal.find('#imagen_actual_nombre').text(imagen);
    });
});
