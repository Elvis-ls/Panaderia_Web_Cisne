<?php
require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../model/ProductoModel.php';

if (isset($_GET['query'])) {
    $query = $_GET['query'];
    $productoModel = new ProductoModel($con);
    $resultados = $productoModel->buscarProductos($query);

    if (empty($resultados)) {
        header("Location: /Panaderia_Web/view/user/no_results.php");
        exit;
    } else {
        // Redirigir a la vista de resultados de búsqueda
        header("Location: /Panaderia_Web/view/user/search_results.php?query=" . urlencode($query));
        exit;
    }
}
?>