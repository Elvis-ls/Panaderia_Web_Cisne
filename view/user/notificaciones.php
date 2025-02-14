<?php
session_start();
$pagina = 'notificaciones';

// Vista: ver_notificaciones.php
require_once($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/config/conexion.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/controller/NotificacionController.php');

// Crear la conexión a la base de datos
$con = new mysqli($host, $usuario, $contraseña, $base_de_datos);

if ($con->connect_error) {
    die("Conexión fallida: " . $con->connect_error);
}

// Instanciar el controlador
$controlador = new Controlador($con);

// Obtener las notificaciones desde el controlador
$notificaciones = $controlador->mostrarNotificaciones();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificaciones</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="/Panaderia_Web/public/css/notificaciones.css">

    <link rel="stylesheet" href="/Panaderia_Web/public/css/style.css">
    

</head>
<body>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/view/partials/header.php'); ?>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/view/partials/nav_user.php'); ?>
    <center>
        <main class="main-content">
            
                <h1 class="text-center mb-4">Notificaciones</h1>
                <?php if (!empty($notificaciones)): ?>
                    <?php foreach ($notificaciones as $notificacion): ?>
                        <div class="notificacion-box">
                            <!-- Mensaje -->
                            <div class="notificacion-mensaje">
                                <p><?php echo $notificacion['mensaje']; ?></p>
                                <div class="notificacion-fecha">
                                    <?php echo $notificacion['fecha_creacion']; ?>
                                </div>
                            </div>
                            <!-- Imagen -->
                            <?php if ($notificacion['imagen']): ?>
                                <div class="notificacion-imagen">
                                    <img src="<?php echo $notificacion['imagen']; ?>" alt="Imagen de notificación">
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="no-notificaciones">No hay notificaciones disponibles.</p>
                <?php endif; ?>

        </main>
    </center>
    
    <!-- Bootstrap JS y dependencias -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/view/partials/footer.php'); ?>
</html>
