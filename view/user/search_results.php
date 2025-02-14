<?php
$pagina = 'search_results';
session_start();
require_once __DIR__ . '/../../model/carrito_functions.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['id'])) {
    header("Location: ../../view/guest/login.php");
    exit;
}
// Incluir el archivo de configuración para la conexión a la base de datos
require_once __DIR__ . '/../../config/conexion.php';

// Incluir el modelo de productos
require_once __DIR__ . '/../../model/ProductoModel.php';

// Crear una instancia del modelo de productos
$productoModel = new ProductoModel($con);

// Obtener el término de búsqueda
$query = isset($_GET['query']) ? $_GET['query'] : '';

// Buscar productos
$resultados = $productoModel->buscarProductos($query);
?>


<?php include($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/view/partials/header.php'); ?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/view/partials/nav_user.php'); ?>

<!-- Incluir el nuevo archivo CSS -->
<link rel="stylesheet" href="/Panaderia_Web/public/css/productos.css">

<main class="main-content">
    <h1>Resultados de la búsqueda</h1>
    <div class="productos">
        <?php if (!empty($resultados)): ?>
            <?php foreach ($resultados as $producto): ?>
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
            <p>No se encontraron productos para "<?php echo htmlspecialchars($query); ?>".</p>
        <?php endif; ?>
    </div>
</main>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/view/partials/footer.php'); ?>

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