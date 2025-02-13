<?php $pagina = 'panaderia'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panaderia</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="/Panaderia_Web/public/css/style.css">
    <script src="/Panaderia_Web/public/js/animacion_menu.js"></script>
    <link rel="stylesheet" href="/Panaderia_Web/public/css/productos.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/view/partials/header.php'); ?>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/view/partials/nav.php'); ?>
    <main class="main-content">
        <h1>Panadería</h1>
        <div class="productos">
            <?php if (!empty($productos)): ?>
                <?php foreach ($productos as $producto): ?>
                    <div class="producto">
                        <?php $rutaImagen = '/Panaderia_Web/public/images/' . $producto['imagen']; ?>
                        <img src="<?php echo $rutaImagen; ?>" alt="<?php echo $producto['nombre']; ?>">
                        <h2><?php echo $producto['nombre']; ?></h2>
                        <p><?php echo $producto['descripcion']; ?></p>
                        <p>Precio: <?php echo $producto['precio']; ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No hay productos disponibles en esta categoría.</p>
            <?php endif; ?>
        </div>
    </main>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/view/partials/footer.php'); ?>
</body>
</html>