<?php
session_start();
$pagina = 'pedidos';

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

// Aquí deberías obtener los pedidos del usuario desde la base de datos
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Pedidos</title>
    <link rel="stylesheet" href="../../public/css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include ('../partials/header.php'); ?>
    <?php include ('../partials/nav.php'); ?>

    <main class="main-content">
        <h1>Mis Pedidos</h1>
        
        <div class="pedidos-lista">
            <!-- Aquí debería mostrar los pedidos del usuario desde la base de datos -->
            <div class="pedido-item">
                <p>Pedido #1234 - Estado: Confirmado</p>
                <a href="detalle_pedido.php?id=1234">Ver detalles</a>
            </div>
            <!-- Fin de la lista de pedidos -->
        </div>
        
        <div class="nuevo-pedido">
            <h2>Realizar un nuevo pedido</h2>
            <a href="realizar_pedido.php" class="btn btn-primary">Crear nuevo pedido</a>
        </div>
    </main>
    
    <?php include ('../partials/footer.php'); ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
