<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$pagina = 'pedidos';

// Verificar si el usuario está logueado
if (!isset($_SESSION['id'])) {
    header("Location: ../../view/guest/login.php");
    exit;
}

// Incluir el archivo del modelo de pedidos
require_once __DIR__ . '/../../model/PedidoModel.php';

// Crear una instancia del modelo de pedidos
$pedidoModel = new PedidoModel();

// Obtener los pedidos del usuario
$usuario_id = $_SESSION['id'];
$pedidos = $pedidoModel->obtenerPedidos($usuario_id);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Pedidos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../public/css/style.css">
    <link rel="stylesheet" href="../../public/css/pedidos.css">
    <link rel="stylesheet" href="../../public/css/gest_Usuarios.css">

</head>
<body>
    <?php include ('../partials/header.php'); ?>
    <?php include ('../partials/nav.php'); ?>

    <main class="main-content">
        <h1>Mis Pedidos</h1>
        
        <?php if (empty($pedidos)): ?>
            <div class="alert alert-warning text-center">No has realizado ningún pedido.</div>
        <?php else: ?>
            <div class="table-container">
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>ID Pedido</th>
                            <th>Fecha</th>
                            <th>Total</th>
                            <th>Estado</th>
                            <th>Acciones</th> <!-- Nueva columna para el botón de reporte -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pedidos as $pedido): ?>
                            <tr>
                                <td><?= $pedido['id'] ?></td>
                                <td><?= $pedido['fecha_pedido'] ?></td>
                                <td>$<?= number_format($pedido['total'], 2) ?></td>
                                <td><span class="badge" style="background-color: #3d8d58; color: #fff;"><?= $pedido['estado'] ?></span></td>
                                <td>
                                    <a href="../../controller/ReporteController.php?pedido_id=<?= $pedido['id'] ?>" class="btn btn-primary btn-sm">Generar PDF</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </main>
    
    <?php include ('../partials/footer.php'); ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>