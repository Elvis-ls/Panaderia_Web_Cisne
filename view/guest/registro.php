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
                <div id="mensajeRegistro" class="alert" style="display: none;"></div>
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

        var formData = new FormData(this); // Crear una instancia de FormData y pasarle el formulario

        $.ajax({
            url: '/panaderia_web/controller/RegistroController.php',
            type: 'POST',
            data: formData,
            processData: false, // Evitar que jQuery procese los datos
            contentType: false, // Evitar que jQuery establezca el tipo de contenido
            success: function(response) {
                console.log(response); // Verifica la respuesta en la consola
                try {
                    var data = JSON.parse(response); // Intenta parsear la respuesta como JSON
                    if (data.success) {
                        $('#mensajeRegistro').removeClass('alert-danger').addClass('alert-success').text(data.message).show();
                        $('#formRegistro')[0].reset(); // Limpiar el formulario
                    } else {
                        $('#mensajeRegistro').removeClass('alert-success').addClass('alert-danger').text(data.message).show();
                        $('#formRegistro')[0].reset(); // Limpiar el formulario
                    }
                } catch (e) {
                    console.error("Error al parsear la respuesta:", e); // Muestra errores de parsing
                    $('#mensajeRegistro').removeClass('alert-success').addClass('alert-danger').text('Error en la respuesta del servidor.').show();
                    $('#formRegistro')[0].reset(); // Limpiar el formulario
                }
            },
            error: function(xhr, status, error) {
                console.error("Error en la solicitud AJAX:", status, error); // Muestra errores de la solicitud
                $('#mensajeRegistro').removeClass('alert-success').addClass('alert-danger').text('Error al procesar la solicitud.').show();
                $('#formRegistro')[0].reset(); // Limpiar el formulario
            }
        });
    });
});
</script>