<!-- Modal de Registro -->
<div class="modal fade" id="registroModal" tabindex="-1" aria-labelledby="registroModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registroModalLabel">Registrarse</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Mostrar el mensaje de éxito o error -->
                <div id="mensaje"></div>
                <!-- Formulario de Registro -->
                <form id="formRegistro">
                    <div class="mb-3">
                        <label for="registroNombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="registroNombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="registroEmail" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="registroEmail" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="registroPassword" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="registroPassword" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="registroTelefono" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="registroTelefono" name="telefono">
                    </div>
                    <div class="mb-3">
                        <label for="registroDireccion" class="form-label">Dirección</label>
                        <textarea class="form-control" id="registroDireccion" name="direccion"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Registrarse</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#formRegistro').on('submit', function(e) {
        e.preventDefault(); // Evitar que el formulario se envíe de la manera tradicional

        $.ajax({
            url: '/panaderia_web/controller/RegistroController.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    $('#mensaje').html('<div class="alert alert-success">' + response.message + '</div>');
                    // Limpiar el formulario si el registro fue exitoso
                    $('#formRegistro')[0].reset();
                } else {
                    $('#mensaje').html('<div class="alert alert-danger">' + response.message + '</div>');
                }
            },
            error: function() {
                $('#mensaje').html('<div class="alert alert-danger">Error al procesar la solicitud.</div>');
            }
        });
    });
});
</script>