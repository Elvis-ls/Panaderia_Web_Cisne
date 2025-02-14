<?php
// Definir la página actual
$pagina = 'search_results';
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['id'])) {
    header("Location: ../../view/guest/login.php");
    exit;
}

// Incluir la configuración y el modelo necesario
require_once __DIR__ . '/../../config/conexion.php';
require_once __DIR__ . '/../../model/ProductoModel.php';
require_once __DIR__ . '/../../model/carrito_functions.php';

// Crear una instancia del modelo de productos
$productoModel = new ProductoModel($con);

// Obtener el término de búsqueda
$query = isset($_GET['query']) ? $_GET['query'] : '';

// Buscar productos utilizando el modelo
$resultados = $productoModel->buscarProductos($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de la búsqueda - Panadería</title>
    <!-- Incluir estilos -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="/Panaderia_Web/public/css/productos.css">
    <link rel="stylesheet" href="/Panaderia_Web/public/css/carrito.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

    <!-- Incluir Header y Nav -->
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/view/partials/header.php'); ?>

    <!-- Menú de Navegación -->
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/view/partials/nav.php'); ?>

    <!-- Carrito flotante -->
    <?php include ('../partials/carrito.php'); ?>

    <!-- Contenido Principal -->
    <main class="main-content">
        <h1>Resultados de la búsqueda</h1>
        <div class="productos">
            <?php if (!empty($resultados)): ?>
                <?php foreach ($resultados as $producto): ?>
                    <div class="producto">
                        <?php 
                        $rutaImagen = '/Panaderia_Web/public/images/' . $producto['imagen']; 
                        $nombreProducto = htmlspecialchars($producto['nombre']);
                        $descripcionProducto = htmlspecialchars($producto['descripcion']);
                        ?>
                        <img src="<?php echo $rutaImagen; ?>" alt="<?php echo $nombreProducto; ?>">
                        <h2><?php echo $nombreProducto; ?></h2>
                        <p><?php echo $descripcionProducto; ?></p>
                        <p>Precio: <?php echo $producto['precio']; ?></p>
                        <p>Stock: <?php echo $producto['stock']; ?></p>
                        <form action="/Panaderia_Web/controller/CarritoController.php" method="POST">
                            <input type="hidden" name="producto_id" value="<?php echo $producto['id']; ?>">
                            <input type="hidden" name="accion" value="agregar">
                            <div class="form-group cantidad-group">
                                <label for="cantidad_<?php echo $producto['id']; ?>">Cantidad:</label>
                                <div class="input-group">
                                    <button type="button" class="btn btn-outline-secondary" 
                                        onclick="modificarCantidad(<?php echo $producto['id']; ?>, <?php echo $producto['stock']; ?>, -1)">-</button>
                                    <input type="number" id="cantidad_<?php echo $producto['id']; ?>" 
                                        name="cantidad" value="1" min="1" max="<?php echo $producto['stock']; ?>" 
                                        class="form-control text-center" readonly>
                                    <button type="button" class="btn btn-outline-secondary" 
                                        onclick="modificarCantidad(<?php echo $producto['id']; ?>, <?php echo $producto['stock']; ?>, 1)">+</button>
                                </div>
                            </div>
                            <br>
                            <button type="submit" class="btn btn-primary">Añadir al carrito</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No se encontraron productos para "<?php echo htmlspecialchars($query); ?>".</p>
            <?php endif; ?>
        </div>
    </main>

    <!-- Incluir Footer -->
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/view/partials/footer.php'); ?>
    <script src="/Panaderia_Web/public/js/carrito.js"></script>

    <!-- Scripts -->
    <script>
        /**
         * Función para modificar la cantidad de productos
         * @param {number} id - ID del producto
         * @param {number} stock - Stock disponible del producto
         * @param {number} cambio - Valor a incrementar o decrementar
         */
        function modificarCantidad(id, stock, cambio) {
            var cantidadInput = document.getElementById('cantidad_' + id);
            var nuevaCantidad = parseInt(cantidadInput.value) + cambio;
            if (nuevaCantidad >= 1 && nuevaCantidad <= stock) {
                cantidadInput.value = nuevaCantidad;
            }
        }
    </script>

    <script>
        $(document).ready(function() {
            $('.update-quantity-form input[name="cantidad"]').on('change', function() {
                var form = $(this).closest('form');
                $.ajax({
                    url: form.attr('action'),
                    method: form.attr('method'),
                    data: form.serialize(),
                    success: function(response) {
                        // Actualizar el total del pedido y otros elementos del carrito si es necesario
                        $('#total-pedido').text(response.total_pedido);
                        // Aquí puedes actualizar otros elementos del carrito si es necesario
                    },
                    error: function() {
                        alert('Error al actualizar la cantidad del producto.');
                    }
                });
            });
        });
    </script>
</body>
</html>
