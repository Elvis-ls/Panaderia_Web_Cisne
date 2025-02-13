<?php
$pagina = 'pasteleria_user';

// Incluir el archivo de configuración para la conexión a la base de datos
require_once __DIR__ . '/../../config/conexion.php';

// Incluir el modelo de productos
require_once __DIR__ . '/../../model/ProductoModel.php';

// Crear una instancia del modelo de productos
$productoModel = new ProductoModel($con);

// Obtener los productos de la categoría "Panadería"
$productos = $productoModel->getProductosPorCategoria(2); // ID de la categoría "Panadería"
?>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/view/partials/header.php'); ?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/view/partials/nav_user.php'); ?>

<!-- Incluir el nuevo archivo CSS -->
<link rel="stylesheet" href="/Panaderia_Web/public/css/productos.css">
<!-- Incluir el archivo CSS para pedidos personalizados -->
<link rel="stylesheet" href="/Panaderia_Web/public/css/pedido_personalizado.css">


<main class="main-content">
    <h1>Pastelería</h1>
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

    <!-- Botón para abrir la ventana modal de pedido personalizado -->
    <div class="pedido-personalizado">
        <h2>¿No encuentras lo que buscas?</h2>
        <p>Realiza un pedido personalizado:</p>
        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#pedidoPersonalizadoModal">Pedido Personalizado</button>
    </div>
</main>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/view/partials/footer.php'); ?>

<!-- Ventana modal para el pedido personalizado -->
<div class="modal fade" id="pedidoPersonalizadoModal" tabindex="-1" role="dialog" aria-labelledby="pedidoPersonalizadoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pedidoPersonalizadoModalLabel">Pedido Personalizado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/Panaderia_Web/controller/PedidoPersonalizadoController.php" method="POST">
                    <div class="form-group">
                        <label for="nombre">Nombre del Producto:</label>
                        <input type="text" id="nombre" name="nombre" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="descripcion">Descripción:</label>
                        <textarea id="descripcion" name="descripcion" class="form-control" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="cantidad">Cantidad:</label>
                        <input type="number" id="cantidad" name="cantidad" class="form-control" min="1" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Enviar Pedido</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Elimina la inclusión de Bootstrap CSS -->
<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->

<!-- Incluye solo el JavaScript de Bootstrap para el modal -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>