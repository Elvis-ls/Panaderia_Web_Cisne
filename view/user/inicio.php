<?php $pagina = 'inicio_user'; 
session_start();?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panadería - Página Usuario</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../../public/css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="/Panaderia_Web/public/js/animacion_menu.js"></script>

</head>
<body>
    <!-- Encabezado -->
    <?php include ('../partials/header.php'); ?>
    
    <!-- Menú de Navegación -->
    <?php include ('../partials/nav.php'); ?>
    
    <main class="main-content">
        <h1>Bienvenidos a nuestra Panadería</h1>
        <p>Descubre nuestros deliciosos productos frescos y artesanales.</p>
        <div class="menu-grid">
            <div class="menu-item">
                <div class="menu-card">
                    <div class="menu-card-front">
                        <img src="../../public/images/panaderia.jpg" alt="Panadería">
                        <h3>Panadería</h3>
                    </div>
                    <div class="menu-card-back">
                        <p>Disfruta de una amplia variedad de panes frescos y recién horneados, ideales para cualquier momento del día. Desde panes clásicos hasta opciones especiales, perfectas para acompañar tu desayuno o merienda.</p>
                    </div>
                </div>
                <a href="panaderia_user.php">Ver más</a>
            </div>

            <div class="menu-item">
                <div class="menu-card">
                    <div class="menu-card-front">
                        <img src="../../public/images/pasteleria.jpg" alt="Pastelería">
                        <h3>Pastelería</h3>
                    </div>
                    <div class="menu-card-back">
                        <p>Deléitate con nuestras deliciosas creaciones de pastelería, elaboradas con los mejores ingredientes. Tienes una variedad de tortas, galletas y dulces perfectos para cualquier celebración o simplemente para consentirte.</p>
                    </div>
                </div>
                <a href="pasteleria_user.php">Ver más</a>
            </div>

            <div class="menu-item">
                <div class="menu-card">
                    <div class="menu-card-front">
                        <img src="../../public/images/galleteria.jpg" alt="Galletería">
                        <h3>Galletería</h3>
                    </div>
                    <div class="menu-card-back">
                        <p>Sumérgete en el sabor de nuestras galletas caseras, preparadas con amor y los mejores ingredientes. Desde las clásicas hasta opciones innovadoras, cada bocado es una explosión de sabor.</p>
                    </div>
                </div>
                <a href="galleteria_user.php">Ver más</a>
            </div>

            <div class="menu-item">
                <div class="menu-card">
                    <div class="menu-card-front">
                        <img src="../../public/images/lacteos.jpg" alt="Lácteos">
                        <h3>Lácteos</h3>
                    </div>
                    <div class="menu-card-back">
                        <p>Nuestros productos lácteos son de la más alta calidad, ideales para complementar tu dieta. Encuentra leches, quesos y yogures frescos, perfectos para acompañar tus desayunos o preparar recetas deliciosas.</p>
                    </div>
                </div>
                <a href="lacteos_user.php">Ver más</a>
            </div>
        </div>
    </main>   
    <!-- Pie de página -->
    <?php include ('../partials/footer.php'); ?>
        <!-- Incluir los scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
