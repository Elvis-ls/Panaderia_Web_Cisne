<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$pagina = 'perfil';

// Verificar si el usuario está logueado
if (!isset($_SESSION['id'])) {
    header("Location: ../../view/guest/login.php");
    exit;
}

// Incluir el modelo del usuario para obtener los datos del usuario
require_once __DIR__ . '/../../model/UserModel.php';
$usuarioModel = new UsuarioModel();
$usuario_id = $_SESSION['id'];
$usuario = $usuarioModel->obtenerUsuario($usuario_id);

// Mostrar mensaje de actualización
if (isset($_SESSION['mensaje'])) {
    echo '<div class="alert alert-info text-center">' . $_SESSION['mensaje'] . '</div>';
    unset($_SESSION['mensaje']);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil</title>
    <link rel="stylesheet" href="../../public/css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .main-content {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .main-content h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group label {
            font-weight: bold;
        }
        .btn-primary {
            width: 100%;
        }
    </style>
</head>
<body>
    <?php include ('../partials/header.php'); ?>
    <?php include ('../partials/nav.php'); ?>

    <main class="main-content">
        <h1>Mi Perfil</h1>
        
        <form action="../../controller/UserController.php" method="POST">
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?= $usuario['nombre'] ?>" required>
            </div>
            <div class="form-group">
                <label for="correo">Correo Electrónico</label>
                <input type="email" class="form-control" id="correo" name="correo" value="<?= $usuario['correo'] ?>" required>
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="text" class="form-control" id="telefono" name="telefono" value="<?= $usuario['telefono'] ?>">
            </div>
            <div class="form-group">
                <label for="direccion">Dirección</label>
                <textarea class="form-control" id="direccion" name="direccion"><?= $usuario['direccion'] ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar Perfil</button>
        </form>
    </main>
    
    <?php include ('../partials/footer.php'); ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>