<?php
// controller/PedidoController.php
session_start();
require_once '../model/PedidoModel.php';

class PedidoController {
    private $pedidoModel;

    public function __construct() {
        $this->pedidoModel = new PedidoModel();
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
        include '../view/pedidos.php';
    }
}

// Crear una instancia del controlador y llamar al método para mostrar pedidos
$pedidoController = new PedidoController();
$pedidoController->mostrarPedidos();
?>