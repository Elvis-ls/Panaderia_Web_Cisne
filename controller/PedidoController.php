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
        if (!isset($_SESSION['usuario_id'])) {
            header("Location: login.php");
            exit;
        }

        // Obtener los pedidos del usuario
        $usuario_id = $_SESSION['usuario_id'];
        $pedidos = $this->pedidoModel->obtenerPedidos($usuario_id);

        // Incluir la vista
        include '../view/user/pedidos.php';
    }
}

// Crear una instancia del controlador y llamar al método para mostrar pedidos
$pedidoModel = new PedidoModel();
$pedidoController = new PedidoController($pedidoModel);
$pedidoController->mostrarPedidos();
?>