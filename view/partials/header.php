<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

<<<<<<< HEAD
<header>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&family=Lora:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Panaderia_Web/public/css/style.css">
    
    <div class="d-flex justify-content-between align-items-center">
        <div class="logo">
            <img src="http://localhost/Panaderia_Web/public/images/logo.png" alt="Logo Panadería">
            <h1>El Cisne Panadería y Pastelería</h1>
        </div>
        
        
        <?php if (isset($_SESSION['rol_id'])): ?>
            <div class="header-extras d-flex justify-content-end align-items-center" style="margin-top: 20px;">
                <?php if ($_SESSION['rol_id'] == 1): ?>
                    <!-- Mostrar barra de búsqueda para rol 1 -->
                    <form class="d-flex" action="/Panaderia_Web/controller/SearchController.php" method="GET">
                        <input class="form-control me-2" type="search" placeholder="Buscar" aria-label="Buscar" name="query" style="background-color: #ffffff; color: #000000;">
                        <button class="btn btn-outline-light" type="submit" style="border-color: #ffffff; color: #ffffff;">Buscar</button>
                    </form>
                <?php elseif ($_SESSION['rol_id'] == 2): ?>
                    <!-- Mostrar carrito de compras e barra de búsqueda para rol 2 -->
                    <div class="position-relative">
                        <a href="/Panaderia_Web/view/user/carrito.php" class="btn btn-outline-light me-2" style="border-color: #ffffff; color: #ffffff;">
                            <i class="fas fa-shopping-cart"></i>
                            <?php if (isset($_SESSION['total_productos']) && $_SESSION['total_productos'] > 0): ?>
                                <span class="badge bg-danger position-absolute top-0 start-100 translate-middle"><?php echo $_SESSION['total_productos']; ?></span>
                            <?php endif; ?>
                        </a>
                    </div>
                    <form class="d-flex" action="/Panaderia_Web/controller/SearchController.php" method="GET">
                        <input class="form-control me-2" type="search" placeholder="Buscar" aria-label="Buscar" name="query" style="background-color: #ffffff; color: #000000;">
                        <button class="btn btn-outline-light" type="submit" style="border-color: #ffffff; color: #ffffff;">Buscar</button>
                    </form>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
    <p>El arte de hornear con amor</p>
</header>
=======
if (isset($_SESSION['id'])) {
    if ($_SESSION['rol_id'] == 1) {
        include 'header_admin.php';
    } elseif ($_SESSION['rol_id'] == 2) {
        include 'header_user.php';
    }
} else {
    include 'header_guest.php';
}
?>
>>>>>>> abca5b0bf244714d987389b3021b27d11626222c
