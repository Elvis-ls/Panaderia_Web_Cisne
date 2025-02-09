<?php
$pagina = 'pasteleria_user';

// Incluir el archivo de configuración para la conexión a la base de datos
require_once __DIR__ . '/../../config/conexion.php';

// Incluir el modelo de productos
require_once __DIR__ . '/../../model/ProductoModel.php';

// Crear una instancia del modelo de productos
$productoModel = new ProductoModel($con);

// Obtener los productos de la categoría "Pastelería"
$productos = $productoModel->getProductosPorCategoria(2); // ID de la categoría "Pastelería"
?>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/view/partials/header.php'); ?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/view/partials/nav_user.php'); ?>

<!-- Incluir el nuevo archivo CSS -->
<link rel="stylesheet" href="/Panaderia_Web/public/css/productos.css">

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
                    <form action="/Panaderia_Web/controller/CarritoController.php" method="POST">
                        <input type="hidden" name="producto_id" value="<?php echo $producto['id']; ?>">
                        <input type="hidden" name="cantidad" value="1">
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