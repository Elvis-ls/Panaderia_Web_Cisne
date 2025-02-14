<?php
$pagina = 'ayuda';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ayuda</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="/Panaderia_Web/public/css/ayuda.css">
    <link rel="stylesheet" href="/Panaderia_Web/public/css/style.css">
    <script src="/Panaderia_Web/public/js/animacion_menu.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/view/partials/header.php'); ?>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/view/partials/nav.php'); ?>

    <CENTER>
    <main class="main-content">
        <h1>Ayuda</h1>

        <div class="section">
            <h2 class="section-title">Preguntas Frecuentes (FAQ)</h2>
            <p><strong>¿Cómo realizo un pedido?</strong></p>
            <p>Para realizar un pedido primeor debe de ser un usuario de nuestra panaderia, para esto puede registrarse y luego inciar sesion.</p>
            <p><strong>¿Cómo puedo registrame?</strong></p>
            <p>En la sección superior derecha hay un boton para registrase, llene los datos que se solicitan y siga las instrucciones que se mencionan en el proceso de registro.</p>
            <!-- Agrega más preguntas frecuentes aquí -->
        </div>
        <div class="section contact-info">
            <h2 class="section-title">Información de Contacto</h2>
            <p><strong>Dirección:</strong> Calle Falsa 123, Ciudad, País</p>
            <p><strong>Teléfono:</strong> +123 456 7890</p>
            <p><strong>Correo Electrónico:</strong> contacto@panaderia.com</p>
            <p><strong>Horario de Atención:</strong> Lunes a Viernes, 8:00 AM - 6:00 PM</p>
        </div>
        <div class="section">
            <h2 class="section-title">Cuidado y Almacenamiento de Productos</h2>
            <p>Para mantener la frescura de nuestros productos, recomendamos almacenarlos en un lugar fresco y seco. Los productos horneados deben consumirse dentro de los 2-3 días posteriores a la entrega para garantizar la mejor calidad.</p>
        </div>

        <div class="section">
            <h2 class="section-title">Información Nutricional y Alergias</h2>
            <p>Nuestros productos pueden contener alérgenos como gluten, nueces y lácteos. Por favor, revisa la información nutricional en cada producto para más detalles.</p>
        </div>
    </main>
    </CENTER>
   
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/view/partials/footer.php'); ?>
</body>
</html>

