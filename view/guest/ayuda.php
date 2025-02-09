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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/view/partials/header.php'); ?>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/view/partials/nav.php'); ?>

    <main class="main-content">
        <h1>Ayuda</h1>

        <div class="section">
            <h2 class="section-title">Preguntas Frecuentes (FAQ)</h2>
            <p><strong>¿Cómo realizo un pedido?</strong></p>
            <p>Puedes realizar un pedido en línea a través de nuestro sitio web. Simplemente selecciona los productos que deseas, agrégalos al carrito y sigue las instrucciones para completar tu compra.</p>
            <p><strong>¿Cuáles son los métodos de pago aceptados?</strong></p>
            <p>Aceptamos pagos con tarjeta de crédito, débito y PayPal.</p>
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
            <h2 class="section-title">Política de Devoluciones y Reembolsos</h2>
            <p>Si no estás satisfecho con tu compra, puedes devolver los productos no consumidos dentro de los 7 días posteriores a la entrega para un reembolso completo. Por favor, contáctanos para más detalles.</p>
        </div>

        <div class="section">
            <h2 class="section-title">Guía de Compra</h2>
            <p>Para realizar un pedido, sigue estos pasos:</p>
            <ol>
                <li>Selecciona los productos que deseas comprar y agrégalos al carrito.</li>
                <li>Revisa tu carrito y asegúrate de que todos los productos estén correctos.</li>
                <li>Completa la información de envío y pago.</li>
                <li>Confirma tu pedido y recibirás un correo electrónico de confirmación.</li>
            </ol>
        </div>

        <div class="section">
            <h2 class="section-title">Envíos y Entregas</h2>
            <p>Ofrecemos envíos a todo el país. Los tiempos de entrega varían según la ubicación, pero generalmente los pedidos se entregan dentro de 3-5 días hábiles.</p>
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
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/view/partials/footer.php'); ?>
</body>
</html>

