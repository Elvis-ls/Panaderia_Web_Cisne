<?php
// Configuración de la página
$pagina = 'pasteleria_user';
session_start();
require_once __DIR__ . '/../../model/carrito_functions.php';
require_once __DIR__ . '/../../config/conexion.php';
require_once __DIR__ . '/../../model/ProductoModel.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['id'])) {
    header("Location: ../../view/guest/login.php");
    exit;
}

// Crear instancia del modelo de productos
$productoModel = new ProductoModel($con);

// Obtener el ID del producto si está presente en la URL
$producto_id = isset($_GET['id']) ? $_GET['id'] : null;

// Obtener los productos de la categoría "Pastelería"
$productos = $productoModel->getProductosPorCategoria(2); // ID de la categoría "Pastelería"
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pastelería - Página Usuario</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/Panaderia_Web/public/css/productos.css">
    <link rel="stylesheet" href="/Panaderia_Web/public/css/modal.css">
    <link rel="stylesheet" href="/Panaderia_Web/public/css/carrito.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <!-- Encabezado -->
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/view/partials/header.php'); ?>
    
    <!-- Menú de Navegación -->
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/view/partials/nav_user.php'); ?>
    
    <!-- Carrito flotante -->
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/view/partials/carrito.php'); ?>

    <!-- Recomendaciones flotantes -->
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/view/partials/recomendaciones.php'); ?>

    <main class="main-content">
        <h1 class="text-center flex-grow-1">Pastelería</h1>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <!-- Botón para abrir la ventana modal de pedido personalizado -->
            <button type="button" class="btn btn-secondary ms-auto" id="pedidoPersonalizadoBtn">Pedido Personalizado</button>
        </div>
        <div class="productos">
            <?php if (!empty($productos)): ?>
                <?php foreach ($productos as $producto): ?>
                    <div class="producto">
                        <?php $rutaImagen = '/Panaderia_Web/public/images/' . $producto['imagen']; ?>
                        <img src="<?php echo $rutaImagen; ?>" alt="<?php echo $producto['nombre']; ?>">
                        <h2><?php echo $producto['nombre']; ?></h2>
                        <p><?php echo $producto['descripcion']; ?></p>
                        <p>Precio: <?php echo $producto['precio']; ?></p>
                        <p>Stock: <?php echo $producto['stock']; ?></p>
                        <form action="/Panaderia_Web/controller/CarritoController.php" method="POST">
                            <input type="hidden" name="producto_id" value="<?php echo $producto['id']; ?>">
                            <input type="hidden" name="accion" value="agregar">
                            <div class="form-group cantidad-group">
                                <label for="cantidad_<?php echo $producto['id']; ?>">Cantidad:</label>
                                <div class="input-group">
                                    <button type="button" class="btn btn-outline-secondary" onclick="decrementarCantidad(<?php echo $producto['id']; ?>, <?php echo $producto['stock']; ?>)">-</button>
                                    <input type="number" id="cantidad_<?php echo $producto['id']; ?>" name="cantidad" value="1" min="1" max="<?php echo $producto['stock']; ?>" class="form-control text-center">
                                    <button type="button" class="btn btn-outline-secondary" onclick="incrementarCantidad(<?php echo $producto['id']; ?>, <?php echo $producto['stock']; ?>)">+</button>
                                </div>
                                <br>
                                <button type="submit" class="btn btn-primary">Añadir al carrito</button>
                            </div>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No hay productos disponibles en esta categoría.</p>
            <?php endif; ?>
        </div>
    </main>

    <?php include($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/view/partials/footer.php'); ?>

    <!-- Ventana modal personalizada -->
    <div id="pedidoPersonalizadoModal" class="modal">
        <?php include($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/view/user/pedido_personalizado.php'); ?>
    </div>

    <script>
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

        $(document).ready(function() {
            $('.update-quantity-form input[name="cantidad"]').on('change', function() {
                var form = $(this).closest('form');
                $.ajax({
                    url: form.attr('action'),
                    method: form.attr('method'),
                    data: form.serialize(),
                    success: function(response) {
                        $('#total-pedido').text(response.total_pedido);
                    },
                    error: function() {
                        alert('Error al actualizar la cantidad del producto.');
                    }
                });
            });
        });
    </script>

    <!-- Archivos JavaScript personalizados -->
    <script src="/Panaderia_Web/public/js/modal.js"></script>
    <script src="/Panaderia_Web/public/js/carrito.js"></script>
</body>
</html>