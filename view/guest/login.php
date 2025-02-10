<!-- Modal de Iniciar Sesión -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Iniciar Sesión</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Mostrar el mensaje de éxito o error -->
                <div id="mensajeLogin" class="alert" style="display: none;"></div>
                <!-- Formulario de Iniciar Sesión -->
                <form id="formLogin">
                    <div class="form-group">
                        <label for="correo">Correo Electrónico</label>
                        <input type="email" class="form-control" name="correo" required>
                    </div>
                    <div class="form-group">
                        <label for="contraseña">Contraseña</label>
                        <input type="password" class="form-control" name="contraseña" required>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary">Ingresar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#formLogin').on('submit', function(e) {
        e.preventDefault(); // Evitar que el formulario se envíe de la manera tradicional

        var formData = new FormData(this); // Crear una instancia de FormData y pasarle el formulario

        $.ajax({
            url: '/panaderia_web/controller/LoginController.php',
            type: 'POST',
            data: formData,
            processData: false, // Evitar que jQuery procese los datos
            contentType: false, // Evitar que jQuery establezca el tipo de contenido
            success: function(response) {
                console.log(response); // Verifica la respuesta en la consola
                try {
                    var data = JSON.parse(response); // Intenta parsear la respuesta como JSON
                    if (data.success) {
                        $('#mensajeLogin').removeClass('alert-danger').addClass('alert-success').text(data.message).show();
                        $('#formLogin')[0].reset(); // Limpiar el formulario
                        // Redirigir a la página de inicio o perfil
                        window.location.href = data.redirect;
                    } else {
                        $('#mensajeLogin').removeClass('alert-success').addClass('alert-danger').text(data.message).show();
                    }
                } catch (e) {
                    console.error("Error al parsear la respuesta:", e); // Muestra errores de parsing
                    $('#mensajeLogin').removeClass('alert-success').addClass('alert-danger').text('Error en la respuesta del servidor.').show();
                }
            },
            error: function(xhr, status, error) {
                console.error("Error en la solicitud AJAX:", status, error); // Muestra errores de la solicitud
                $('#mensajeLogin').removeClass('alert-success').addClass('alert-danger').text('Error al procesar la solicitud.').show();
            }
        });
    });
});
</script>