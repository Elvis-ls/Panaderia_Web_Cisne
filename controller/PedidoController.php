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

    public function crearPedidoPersonalizado() {
        // Verificar si el usuario está logueado
        if (!isset($_SESSION['id'])) {
            header("Location: /Panaderia_Web/view/guest/login.php");
            exit;
        }
    
        // Validar los datos del formulario
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $usuario_id = $_SESSION['id'];
            $descripcion = $_POST['descripcion'];
            $fecha_entrega = $_POST['fecha_entrega'];
            $total = $_POST['total']; // Puedes calcular el total en el formulario o aquí

            // Manejar la carga de la imagen de referencia
            $imagen_referencia = null;
            if (isset($_FILES['imagen_referencia']) && $_FILES['imagen_referencia']['error'] === UPLOAD_ERR_OK) {
                $nombreImagen = basename($_FILES['imagen_referencia']['name']);
                $rutaImagen = '/Panaderia_Web/public/images/referencias/' . $nombreImagen;
                $target_dir = $_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/public/images/referencias/';
                $target_file = $target_dir . $nombreImagen;
                move_uploaded_file($_FILES['imagen_referencia']['tmp_name'], $target_file);
                $imagen_referencia = $rutaImagen;
            }

            // Ajustar la descripción para incluir el total
            $descripcion .= "\nTotal: " . $total;
    
            // Crear el pedido personalizado
            $pedido_id = $this->pedidoModel->crearPedidoPersonalizado($usuario_id, $descripcion, $fecha_entrega, null);
    
            if ($pedido_id) {
                $_SESSION['mensaje'] = 'Pedido personalizado creado correctamente.';
                header("Location: /Panaderia_Web/view/user/pedidos.php");
                exit;
            } else {
                $_SESSION['error'] = 'Error al crear el pedido personalizado.';
                header("Location: /Panaderia_Web/view/user/crear_pedido_personalizado.php");
                exit;
            }
        }
    }
}

// Crear una instancia del controlador y llamar al método correspondiente
$pedidoModel = new PedidoModel();
$pedidoController = new PedidoController($pedidoModel);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['accion']) && $_POST['accion'] === 'crearPedidoPersonalizado') {
        $pedidoController->crearPedidoPersonalizado();
    } else {
        $pedidoController->realizarPedido();
    }
} else {
    $pedidoController->mostrarPedidos();
}
?>