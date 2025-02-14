<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$pagina = 'perfilAdm';

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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil</title>
    <link rel="stylesheet" href="../../public/css/style.css">
    <link rel="stylesheet" href="../../public/css/perfil.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
</head>
<body>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/view/partials/header_admin.php'); ?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/view/partials/nav_admin.php'); ?>
    <center>
        <div class="cont">
        <main class="main-content">
        <h1>Mi Perfil</h1>
        
        <form id="perfilForm" action="../../controller/UserController.php" method="POST">
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?= $usuario['nombre'] ?>" readonly>
                <span class="edit-icon" onclick="editField('nombre')">&#9998;</span>
            </div>
            <div class="form-group">
                <label for="correo">Correo Electrónico</label>
                <input type="email" class="form-control" id="correo" name="correo" value="<?= $usuario['correo'] ?>" readonly>
                <span class="edit-icon" onclick="editField('correo')">&#9998;</span>
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="text" class="form-control" id="telefono" name="telefono" value="<?= $usuario['telefono'] ?>" readonly maxlength="10" pattern="\d{10}" oninput="validatePhoneNumber(this)">
                <span class="edit-icon" onclick="editField('telefono')">&#9998;</span>
            </div>
            <div class="form-group">
                <label for="direccion">Dirección</label>
                <textarea class="form-control" id="direccion" name="direccion" readonly><?= $usuario['direccion'] ?></textarea>
                <span class="edit-icon" onclick="editField('direccion')">&#9998;</span>
            </div>
            <button type="button" class="btn btn-primary save-button" id="saveButton" onclick="showConfirmModal()">Guardar Cambios</button>
        </form>
    </main>
        </div>
    </center>
   
    
    <?php include ('../partials/footer.php'); ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="../../public/js/perfil.js"></script>

    <!-- Modal -->
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">Confirmar Edición</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que deseas guardar los cambios?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cancelButton">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="confirmButton">Guardar Cambios</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>