<div class="recomendaciones-icon-wrapper position-fixed" style="top: 35vh; left: 0; width: 55px; height: 50px; background-color: #000; border-right: 1px solid #ccc; border-top-right-radius: 5px; border-bottom-right-radius: 5px; display: flex; align-items: center; justify-content: center; z-index: 9999;">
    <i class="fas fa-star" id="recomendaciones-icon" style="cursor: pointer; color: #FFD700; font-size: 28px;"></i>
    <span id="recomendaciones-count" class="badge bg-danger position-absolute top-0 start-100 translate-middle" style="font-size: 1em;"></span>
    <div id="recomendaciones-list" class="dropdown-menu" style="display: none; position: absolute; top: 60px; left: 0; z-index: 9999;">
        <!-- Aquí se cargarán las recomendaciones -->
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="notificationModalLabel">Notificación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="notificationMessage">
                <!-- Mensaje de notificación -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    function cargarRecomendaciones() {
        $.ajax({
            url: '/Panaderia_Web/controller/RecomendacionController.php',
            method: 'GET',
            success: function(response) {
                var recomendaciones = JSON.parse(response);
                var lista = $('#recomendaciones-list');
                var count = $('#recomendaciones-count');
                lista.empty();
                count.text(recomendaciones.length);
                recomendaciones.forEach(function(producto) {
                    lista.append('<div class="dropdown-item">' +
                                 '<img src="/Panaderia_Web/public/images/' + producto.imagen + '" alt="' + producto.nombre + '" style="width: 50px; height: 50px; margin-right: 10px;">' +
                                 '<span>' + producto.nombre + ' - $' + producto.precio + '</span>' +
                                 '<input type="number" id="cantidad_' + producto.producto_id + '" value="1" min="1" max="10" style="width: 50px; margin-right: 10px;">' +
                                 '<button class="btn btn-primary btn-sm float-right" onclick="agregarAlCarrito(' + producto.producto_id + ')">Agregar</button>' +
                                 '<button class="btn btn-danger btn-sm float-right" onclick="eliminarRecomendacion(' + producto.producto_id + ')">Eliminar</button>' +
                                 '</div>');
                });
            },
            error: function(xhr, status, error) {
                console.error('Error al cargar recomendaciones:', error);
            }
        });
    }

    $('#recomendaciones-icon').on('click', function() {
        $('#recomendaciones-list').toggle();
    });

    cargarRecomendaciones();
});

function mostrarModal(mensaje) {
    $('#notificationMessage').text(mensaje);
    $('#notificationModal').modal('show');
}

function agregarAlCarrito(producto_id) {
    var cantidad = $('#cantidad_' + producto_id).val();
    $.ajax({
        url: '/Panaderia_Web/controller/CarritoController.php',
        method: 'POST',
        data: { producto_id: producto_id, cantidad: cantidad, accion: 'agregar' },
        success: function(response) {
            mostrarModal('Producto agregado al carrito');
            setTimeout(function() {
                location.reload();
            }, 2000);
        },
        error: function(xhr, status, error) {
            console.error('Error al agregar al carrito:', error);
        }
    });
}

function eliminarRecomendacion(producto_id) {
    $.ajax({
        url: '/Panaderia_Web/controller/RecomendacionController.php',
        method: 'POST',
        data: { producto_id: producto_id },
        success: function(response) {
            mostrarModal('Recomendación eliminada');
            setTimeout(function() {
                location.reload();
            }, 2000);
        },
        error: function(xhr, status, error) {
            console.error('Error al eliminar recomendación:', error);
        }
    });
}
</script>