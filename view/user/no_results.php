<?php
$pagina = 'search_results';
session_start();
require_once __DIR__ . '/../../model/carrito_functions.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['id'])) {
    header("Location: ../../view/guest/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>No se encontraron resultados</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include ('../partials/header.php'); ?>
    <?php include ('../partials/nav.php'); ?>

    <main class="main-content">
        <div class="container">
            <h1>No se encontraron resultados</h1>
            <p>Lo sentimos, no se encontraron resultados para su búsqueda.</p>
            <a href="/Panaderia_Web/view/user/inicio.php" class="btn btn-primary">Volver a Inicio</a>
        </div>
    </main>

    <?php include ('../partials/footer.php'); ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>