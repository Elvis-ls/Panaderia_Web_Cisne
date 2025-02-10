$(document).ready(function() {
    $('#editarModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var nombre = button.data('nombre');
        var descripcion = button.data('descripcion');
        var precio = button.data('precio');
        var categoria_id = button.data('categoria_id');

        var modal = $(this);
        modal.find('#editar_id').val(id);
        modal.find('#editar_nombre').val(nombre);
        modal.find('#editar_descripcion').val(descripcion);
        modal.find('#editar_precio').val(precio);
        modal.find('#editar_categoria_id').val(categoria_id);
    });

    $('#eliminarModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');

        var modal = $(this);
        modal.find('#eliminar_id').val(id);
    });
});
