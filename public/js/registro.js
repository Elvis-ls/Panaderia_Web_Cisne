$('#formRegistro').on('submit', function(e) {
    e.preventDefault(); // Prevenir que el formulario se envíe de forma tradicional
    console.log("Formulario enviado"); // Agregar esta línea para verificar si el evento se dispara

    var formData = $(this).serialize(); // Obtener los datos del formulario

    $.ajax({
        url: '../controller/RegistroController.php', // Aquí se hace la llamada al controlador
        type: 'POST',
        data: formData, // Los datos del formulario son enviados al controlador
        success: function(response) {
            console.log(response); // Ver respuesta del servidor
            var mensaje = JSON.parse(response);
            $('#mensaje').removeClass('alert-success alert-danger').addClass(mensaje.tipo);
            $('#mensaje').text(mensaje.mensaje);
            $('#mensaje').show(); // Mostrar el mensaje
        },
        error: function() {
            console.log("Error en la solicitud AJAX"); // Ver si ocurre un error en la solicitud
            $('#mensaje').removeClass('alert-success alert-danger').addClass('alert-danger');
            $('#mensaje').text("Hubo un error al procesar el formulario. Intenta nuevamente.");
            $('#mensaje').show(); // Mostrar el mensaje de error
        }
    });
});
