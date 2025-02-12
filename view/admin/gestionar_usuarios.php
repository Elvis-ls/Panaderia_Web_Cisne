<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Incluir la conexión y el controlador
require_once($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/config/conexion.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/controller/AdminController.php');

// Crear la conexión a la base de datos
$con = new mysqli($host, $usuario, $contraseña, $base_de_datos);

if ($con->connect_error) {
    die("Conexión fallida: " . $con->connect_error);
}

// Instanciar el controlador
$adminController = new AdminController($con);

// Manejar la acción de eliminar usuario
if (isset($_GET['action']) && $_GET['action'] == 'eliminarUsuario' && isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sanitizar el ID
    if ($adminController->eliminarUsuario($id)) {
        $_SESSION['mensaje'] = "Usuario eliminado correctamente.";
    } else {
        $_SESSION['error'] = "Error al eliminar el usuario.";
    }
    // No redirigimos aquí, la página se recargará automáticamente después de la eliminación
}

// Manejar la búsqueda de usuarios (si se envió el formulario)
if (isset($_GET['nombre'])) {
    $nombre = $_GET['nombre'];
    $usuarios = $adminController->buscarUsuariosPorNombre($nombre);
} else {
    // Obtener los usuarios (para mostrar en la tabla)
    $usuarios = $adminController->getUsuarios();
}
?>

<!-- Incluir jQuery antes de Bootstrap -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="/Panaderia_Web/public/css/style.css">

<?php $pagina = 'gestUsuarios'; ?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/view/partials/header.php'); ?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/view/partials/nav_admin.php'); ?>

<main class="main-content">
    <div class="container">
        <h1 class="my-4">Gestionar Usuarios</h1>

        <!-- Barra de búsqueda -->
        <form action="gestionar_usuarios.php" method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" name="nombre" class="form-control" placeholder="Buscar usuario por nombre">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </div>
            </div>
        </form>

        <!-- Mensajes de éxito o error -->
        <?php if (isset($_SESSION['mensaje'])): ?>
            <div class="alert alert-success"><?php echo $_SESSION['mensaje']; unset($_SESSION['mensaje']); ?></div>
        <?php endif; ?>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <!-- Tabla de usuarios -->
        <!-- Tabla de usuarios -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Dirección</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($usuarios)): ?>
                    <?php foreach ($usuarios as $usuario): ?>
                        <tr>
                            <td><?php echo $usuario['nombre']; ?></td>
                            <td><?php echo $usuario['correo']; ?></td>
                            <td><?php echo $usuario['telefono']; ?></td>
                            <td><?php echo $usuario['direccion']; ?></td>
                            <td>
                                <!-- Botón para abrir el modal de confirmación -->
                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#confirmarEliminarModal" data-id="<?php echo $usuario['id']; ?>">
                                    <i class="fas fa-trash"></i> Eliminar
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">No hay usuarios registrados.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div> 
</main>
<!-- Modal de confirmación de eliminación -->
<div class="modal fade" id="confirmarEliminarModal" tabindex="-1" role="dialog" aria-labelledby="confirmarEliminarModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmarEliminarModalLabel">Confirmar Eliminación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que deseas eliminar este usuario?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" id="confirmarEliminarBtn" class="btn btn-danger">Eliminar</button>
            </div>
        </div>
    </div>
</div>



<script>
    $(document).ready(function() {
        var idUsuarioAEliminar; // Variable para almacenar el ID del usuario a eliminar

        // Cuando se abre el modal, capturar el ID del usuario
        $('#confirmarEliminarModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Botón que activó el modal
            idUsuarioAEliminar = button.data('id'); // Extraer el ID del usuario
        });

        // Cuando se confirma la eliminación
        $('#confirmarEliminarBtn').on('click', function() {
            // Realizar la solicitud de eliminación usando AJAX
            $.ajax({
                url: 'gestionar_usuarios.php?action=eliminarUsuario&id=' + idUsuarioAEliminar,
                method: 'GET',
                success: function(response) {
                    // Cerrar el modal
                    $('#confirmarEliminarModal').modal('hide');
                    // Recargar la página para reflejar los cambios
                    location.reload();
                },
                error: function() {
                    alert('Hubo un error al eliminar el usuario.');
                }
            });
        });
    });
</script>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/view/partials/footer.php'); ?>