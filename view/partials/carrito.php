<?php
// Obtener los productos del carrito para el usuario logueado
$usuario_id = $_SESSION['id'];
$productos_carrito = obtenerProductosCarrito($usuario_id);
?>

<!-- Icono del carrito -->
<div class="cart-icon">
    <i class="fas fa-shopping-cart"></i>
    <?php if (isset($_SESSION['total_productos']) && $_SESSION['total_productos'] > 0): ?>
        <span class="badge bg-danger position-absolute top-0 start-100 translate-middle"><?php echo $_SESSION['total_productos']; ?></span>
    <?php endif; ?>
</div>
<div class="cart-dropdown" style="display: none;">
    <span class="close-btn">&times;</span>
    <?php if (!empty($productos_carrito)): ?>
        <?php foreach ($productos_carrito as $producto): ?>
            <div class="cart-item" data-carrito-id="<?php echo $producto['carrito_id']; ?>">
                <div class="item-info">
                    <img src="/Panaderia_Web/public/images/<?php echo $producto['imagen']; ?>" alt="<?php echo $producto['nombre']; ?>">
                    <div class="item-name"><?php echo $producto['nombre']; ?></div>
                    <div class="item-price" data-precio="<?php echo $producto['precio']; ?>">$<?php echo number_format($producto['precio'] * $producto['cantidad'], 2); ?></div>
                </div>

                <div class="item-quantity">
                    <form class="update-quantity-form" action="/Panaderia_Web/controller/CarritoController.php" method="POST">
                        <input type="hidden" name="accion" value="actualizar">
                        <input type="hidden" name="carrito_id" value="<?php echo $producto['carrito_id']; ?>">
                        Cantidad: <input type="number" name="cantidad" value="<?php echo $producto['cantidad']; ?>" min="1">
                    </form>
                </div>

                <form action="/Panaderia_Web/controller/CarritoController.php" method="POST">
                    <input type="hidden" name="accion" value="eliminar">
                    <input type="hidden" name="carrito_id" value="<?php echo $producto['carrito_id']; ?>">
                    <button type="submit" class="remove-item">&times;</button>
                </form>
            </div>
        <?php endforeach; ?>
        <div class="total-pedido">
            Total del Pedido: $<span id="total-pedido"><?php echo number_format(array_sum(array_column($productos_carrito, 'precio')), 2); ?></span>
        </div>
        <div class="realizar-pedido">
            <form action="/Panaderia_Web/controller/CarritoController.php" method="POST">
                <input type="hidden" name="accion" value="realizar_pedido">
                <button type="submit" class="btn btn-success">Realizar Pedido</button>
            </form>
        </div>
    <?php else: ?>
        <p>No hay productos en el carrito.</p>
    <?php endif; ?>
</div>
