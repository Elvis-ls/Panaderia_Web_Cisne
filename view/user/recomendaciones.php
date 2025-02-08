<?php
session_start();
$pagina = 'recomendaciones';

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

// Aquí deberías obtener las recomendaciones de productos del usuario desde la base de datos
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recomendaciones</title>
    <link rel="stylesheet" href="../../public/css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include ('../partials/header.php'); ?>
    <?php include ('../partials/nav.php'); ?>

    <main class="main-content">
        <h1>Recomendaciones Personalizadas</h1>
        
        <div class="recomendaciones-lista">
            <!-- Aquí deberías mostrar las recomendaciones desde la base de datos -->
            <div class="recomendacion-item">
                <p>Producto recomendado: Pan Artesanal</p>
                <a href="producto.php?id=1">Ver producto</a>
            </div>
            <!-- Fin de la lista de recomendaciones -->
        </div>
    </main>
    
    <?php include ('../partials/footer.php'); ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
