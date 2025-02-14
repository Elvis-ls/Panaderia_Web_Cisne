<?php
session_start();
require_once __DIR__ . '/../model/RecomendacionesModel.php';

if (!isset($_SESSION['id'])) {
    header("Location: ../../view/guest/login.php");
    exit;
}

$usuario_id = $_SESSION['id'];
$recomendacionesModel = new RecomendacionesModel();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Obtener productos recomendados
    $productos_recomendados = $recomendacionesModel->obtenerProductosRecomendados($usuario_id);
    echo json_encode($productos_recomendados);
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Eliminar recomendación
    $producto_id = $_POST['producto_id'];
    $recomendacionesModel->eliminarRecomendacion($usuario_id, $producto_id);
    echo json_encode(['status' => 'success']);
}
?>