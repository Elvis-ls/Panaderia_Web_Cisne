<?php require_once '../partials/header.php'; ?>
<?php require_once '../partials/nav.php'; ?>

<h1>Productos de Pastelería</h1>
<ul>
    <?php foreach ($productos as $producto): ?>
        <li>
            <h2><?php echo $producto['nombre']; ?></h2>
            <p><?php echo $producto['descripcion']; ?></p>
            <p>Precio: $<?php echo $producto['precio']; ?></p>
            <img src="../public/images/<?php echo $producto['imagen']; ?>" alt="<?php echo $producto['nombre']; ?>">
        </li>
    <?php endforeach; ?>
</ul>

<?php require_once '../partials/footer.php'; ?>