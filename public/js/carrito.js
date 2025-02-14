$(document).ready(function() {
    $('.cart-icon').on('click', function() {
        $('.cart-dropdown').toggle();
    });

    $('.close-btn').on('click', function() {
        $('.cart-dropdown').hide();
    });

    $('.item-quantity input').on('change', function() {
        const cantidad = $(this).val();
        const carritoId = $(this).closest('.cart-item').data('carrito-id');
        const precio = $(this).closest('.cart-item').find('.item-price').data('precio');
        const total = cantidad * precio;
        $(this).closest('.cart-item').find('.item-price').text('$' + total.toFixed(2));

        $.ajax({
            url: '/Panaderia_Web/controller/CarritoController.php',
            method: 'POST',
            data: {
                accion: 'actualizar',
                carrito_id: carritoId,
                cantidad: cantidad
            },
            success: function(response) {
                console.log(response);
                actualizarTotalPedido();
            }
        });
    });

    $('.remove-item').on('click', function() {
        const carritoId = $(this).closest('.cart-item').data('carrito-id');
        $(this).closest('.cart-item').remove();

        $.ajax({
            url: '/Panaderia_Web/controller/CarritoController.php',
            method: 'POST',
            data: {
                accion: 'eliminar',
                carrito_id: carritoId
            },
            success: function(response) {
                console.log(response);
                actualizarTotalPedido();
            }
        });
    });

    $('.realizar-pedido button').on('click', function() {
        const $button = $(this);
        $button.prop('disabled', true); // Deshabilitar el botón
        $button.text('Procesando...'); // Cambiar el texto del botón

        $.ajax({
            url: '/Panaderia_Web/controller/CarritoController.php',
            method: 'POST',
            data: {
                accion: 'realizar_pedido'
            },
            success: function(response) {
                // Redirigir a la sección de "Mis Pedidos"
                window.location.href = '/Panaderia_Web/view/user/pedidos.php';
            },
            error: function() {
                alert('Error al realizar el pedido.');
                $button.prop('disabled', false); // Habilitar el botón nuevamente en caso de error
                $button.text('Realizar Pedido'); // Restaurar el texto del botón
            }
        });
    });

    function actualizarTotalPedido() {
        let totalPedido = 0;
        $('.item-price').each(function() {
            totalPedido += parseFloat($(this).text().replace('$', ''));
        });
        $('#total-pedido').text('$' + totalPedido.toFixed(2));
    }
});