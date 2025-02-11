<?php $pagina = 'pasteleria'; ?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/view/partials/header.php'); ?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/view/partials/nav_admin.php'); ?>

<link rel="stylesheet" href="/Panaderia_Web/public/css/productos.css">

<main class="main-content">
    <h1>Pastelería</h1>
    <a href="admin_productos.php?categoria=pasteleria&accion=agregar" class="btn btn-success">Agregar Producto</a>
    <div class="productos">
        <?php if (!empty($productos)): ?>
            <?php foreach ($productos as $producto): ?>
                <div class="producto">
                    <img src="/Panaderia_Web/public/images/<?php echo $producto['imagen']; ?>" alt="<?php echo $producto['nombre']; ?>">
                    <h2><?php echo $producto['nombre']; ?></h2>
                    <p><?php echo $producto['descripcion']; ?></p>
                    <p>Precio: <?php echo $producto['precio']; ?></p>
                    <a href="admin_productos.php?id=<?php echo $producto['id']; ?>&accion=editar" class="btn btn-primary">Editar</a>
                    <a href="admin_productos.php?id=<?php echo $producto['id']; ?>&accion=eliminar" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este producto?');">Eliminar</a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No hay productos disponibles en esta categoría.</p>
        <?php endif; ?>
    </div>
</main>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/view/partials/footer.php'); ?>