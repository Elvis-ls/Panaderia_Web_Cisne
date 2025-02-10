<?php
session_start();
require_once __DIR__ . '/../model/PedidoModel.php';

class PedidoController {
    private $pedidoModel;

    public function __construct(PedidoModel $pedidoModel) {
        $this->pedidoModel = $pedidoModel;
    }

    public function mostrarPedidos() {
        // Verificar si el usuario está logueado
        if (!isset($_SESSION['id'])) {
            header("Location: /Panaderia_Web/view/guest/login.php");
            exit;
        }

        // Obtener los pedidos del usuario
        $usuario_id = $_SESSION['id'];
        $pedidos = $this->pedidoModel->obtenerPedidos($usuario_id);

        // Incluir la vista
        include '../view/user/pedidos.php';
    }

    public function realizarPedido() {
        // Verificar si el usuario está logueado
        if (!isset($_SESSION['id'])) {
            header("Location: /Panaderia_Web/view/guest/login.php");
            exit;
        }

        $usuario_id = $_SESSION['id'];

        // Insertar el pedido en la tabla pedidos
        $pedido_id = $this->pedidoModel->crearPedido($usuario_id);

        // Obtener los productos del carrito
        $productos_carrito = $this->pedidoModel->obtenerProductosCarrito($usuario_id);

        // Insertar los productos del carrito en la tabla detallespedidos
        foreach ($productos_carrito as $producto) {
            $this->pedidoModel->agregarProductoAPedido($pedido_id, $producto['producto_id'], $producto['cantidad']);
        }

        // Vaciar el carrito
        $this->pedidoModel->vaciarCarrito($usuario_id);

        $_SESSION['mensaje'] = 'Pedido realizado correctamente.';
        header("Location: /Panaderia_Web/view/user/pedidos.php");
        exit;
    }
}

// Crear una instancia del controlador y llamar al método correspondiente
$pedidoModel = new PedidoModel();
$pedidoController = new PedidoController($pedidoModel);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pedidoController->realizarPedido();
} else {
    $pedidoController->mostrarPedidos();
}
?>