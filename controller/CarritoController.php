<?php
session_start();
require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../model/CarritoModel.php';
require_once __DIR__ . '/../model/PedidoModel.php';
require_once __DIR__ . '/../model/ProductoModel.php';

$carritoModel = new CarritoModel($con);
$pedidoModel = new PedidoModel();
$productoModel = new ProductoModel($con);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario_id = $_SESSION['id'];

    if (isset($_POST['accion']) && $_POST['accion'] == 'eliminar') {
        $carrito_id = $_POST['carrito_id'];
        $carritoModel->eliminarProducto($carrito_id);
        $_SESSION['total_productos'] = $carritoModel->actualizarTotalProductos($usuario_id);
        $_SESSION['mensaje'] = 'Producto eliminado del carrito.';
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }

    if (isset($_POST['accion']) && $_POST['accion'] == 'agregar') {
        $producto_id = $_POST['producto_id'];
        $cantidad = $_POST['cantidad'];

        $result = $carritoModel->obtenerProductoEnCarrito($usuario_id, $producto_id);

        if ($result->num_rows > 0) {
            $carritoModel->actualizarCantidadProducto($cantidad, $usuario_id, $producto_id);
        } else {
            $carritoModel->insertarProducto($usuario_id, $producto_id, $cantidad);
        }

        $_SESSION['mensaje'] = 'Producto añadido al carrito correctamente.';
        $_SESSION['total_productos'] = $carritoModel->actualizarTotalProductos($usuario_id);

        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }

    if (isset($_POST['accion']) && $_POST['accion'] == 'realizar_pedido') {
        $pedido_id = $pedidoModel->crearPedido($usuario_id);

        $productosEnCarrito = $pedidoModel->obtenerProductosCarrito($usuario_id);
        foreach ($productosEnCarrito as $producto) {
            $pedidoModel->agregarProductoAPedido($pedido_id, $producto['producto_id'], $producto['cantidad']);
            $productoModel->actualizarStock($producto['producto_id'], $producto['cantidad']);
        }

        // Limpiar el carrito después de realizar el pedido
        $pedidoModel->vaciarCarrito($usuario_id);

        // Actualizar el indicador del carrito en la sesión
        $_SESSION['total_productos'] = 0;

        $_SESSION['mensaje'] = 'Pedido realizado correctamente.';
        header("Location: ../view/user/pedidos.php");
        exit;
    }
}
?>