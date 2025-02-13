<?php
$pagina = 'pasteleria_user';
session_start();

// Incluir el archivo de configuración para la conexión a la base de datos
require_once __DIR__ . '/../../config/conexion.php';

// Incluir el modelo de productos
require_once __DIR__ . '/../../model/ProductoModel.php';

// Crear una instancia del modelo de productos
$productoModel = new ProductoModel($con);

// Obtener el ID del producto si está presente en la URL
$producto_id = isset($_GET['id']) ? $_GET['id'] : null;

// Obtener los productos de la categoría "Pastelería"
$productos = $productoModel->getProductosPorCategoria(2); // ID de la categoría "Pastelería"
?>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/view/partials/header.php'); ?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/view/partials/nav_user.php'); ?>

<!-- Incluir el nuevo archivo CSS -->
<link rel="stylesheet" href="/Panaderia_Web/public/css/productos.css">
<link rel="stylesheet" href="/Panaderia_Web/public/css/modal.css">

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
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary">Añadir al carrito</button>
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

<<<<<<< HEAD
<!-- Elimina la inclusión de Bootstrap CSS -->
<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->

<!-- Incluye solo el JavaScript de Bootstrap para el modal -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
=======
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
</script>

<!-- Incluir el archivo JavaScript para la ventana modal -->
<script src="/Panaderia_Web/public/js/modal.js"></script>
>>>>>>> abca5b0bf244714d987389b3021b27d11626222c
