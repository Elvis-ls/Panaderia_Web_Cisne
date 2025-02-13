<?php
session_start();
require_once __DIR__ . '/../../config/conexion.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['id'])) {
    header("Location: ../../view/guest/login.php");
    exit;
}

// Obtener los productos del carrito para el usuario logueado
$usuario_id = $_SESSION['id'];
$query = "SELECT c.id as carrito_id, c.cantidad, p.nombre, p.precio, p.imagen FROM carrito c JOIN productos p ON c.producto_id = p.id WHERE c.usuario_id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();
$productos_carrito = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/view/partials/header.php'); ?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/view/partials/nav_user.php'); ?>

<!-- Incluir el nuevo archivo CSS -->
<link rel="stylesheet" href="/Panaderia_Web/public/css/productos.css">

<main class="main-content">
    <h1>Carrito de Compras</h1>
    <div class="productos">
        <?php if (!empty($productos_carrito)): ?>
            <?php foreach ($productos_carrito as $producto): ?>
                <div class="producto">
                    <?php $rutaImagen = '/Panaderia_Web/public/images/' . $producto['imagen']; ?>
                    <img src="<?php echo $rutaImagen; ?>" alt="<?php echo $producto['nombre']; ?>">
                    <h2><?php echo $producto['nombre']; ?></h2>
                    <p>Precio: <?php echo $producto['precio']; ?></p>
                    <p>Cantidad: <?php echo $producto['cantidad']; ?></p>
                    <form action="/Panaderia_Web/controller/CarritoController.php" method="POST" class="d-inline">
                        <input type="hidden" name="carrito_id" value="<?php echo $producto['carrito_id']; ?>">
                        <button type="submit" name="accion" value="eliminar" class="btn btn-danger">Eliminar</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No hay productos en el carrito.</p>
        <?php endif; ?>
    </div>
    <?php if (!empty($productos_carrito)): ?>
        <div class="realizar-pedido text-center mt-4">
            <form action="/Panaderia_Web/controller/CarritoController.php" method="POST">
                <input type="hidden" name="accion" value="realizar_pedido">
                <button type="submit" class="btn btn-success">Realizar Pedido</button>
            </form>
        </div>
    <?php endif; ?>
</main>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/view/partials/footer.php'); ?>