<?php
require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../model/ProductoModel.php';

if (isset($_GET['query'])) {
    $query = $_GET['query'];
    $productoModel = new ProductoModel($con);
    $resultados = $productoModel->buscarProductos($query);

    header('Content-Type: application/json');
    echo json_encode($resultados);
}
?>