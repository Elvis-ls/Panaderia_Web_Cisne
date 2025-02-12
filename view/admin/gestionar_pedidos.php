<?php $pagina = 'gestPedidos'; ?>
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

// Manejar la acción de eliminar pedido
if (isset($_GET['action']) && $_GET['action'] == 'eliminarPedido' && isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sanitizar el ID
    if ($adminController->eliminarPedido($id)) {
        $_SESSION['mensaje'] = "Pedido eliminado correctamente.";
    } else {
        $_SESSION['error'] = "Error al eliminar el pedido.";
    }
    header("Location: gestionar_pedidos.php"); // Redirigir para evitar reenvío del formulario
    exit;
}

// Manejar la acción de actualizar el estado del pedido
if (isset($_POST['actualizarEstado'])) {
    $id = intval($_POST['id']);
    $estado = $_POST['estado'];
    if ($adminController->actualizarEstadoPedido($id, $estado)) {
        $_SESSION['mensaje'] = "Estado del pedido actualizado correctamente.";
    } else {
        $_SESSION['error'] = "Error al actualizar el estado del pedido.";
    }
    header("Location: gestionar_pedidos.php");
    exit;
}

// Obtener los pedidos
$pedidos = $adminController->getPedidos();
?>

<?php $pagina = 'gestPedidos'; ?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/view/partials/header.php'); ?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/view/partials/nav_admin.php'); ?>
<link rel="stylesheet" href="/Panaderia_Web/public/css/style.css">

<main class="main-content">
    <div class="container">
        <h1 class="my-4">Gestionar Pedidos</h1>

        <!-- Mensajes de éxito o error -->
        <?php if (isset($_SESSION['mensaje'])): ?>
            <div class="alert alert-success"><?php echo $_SESSION['mensaje']; unset($_SESSION['mensaje']); ?></div>
        <?php endif; ?>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <!-- Tabla de pedidos -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Fecha del Pedido</th>
                    <th>Estado</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($pedidos)): ?>
                    <?php foreach ($pedidos as $pedido): ?>
                        <tr>
                            <td><?php echo $pedido['id']; ?></td>
                            <td><?php echo $pedido['nombre_usuario']; ?></td>
                            <td><?php echo $pedido['fecha_pedido']; ?></td>
                            <td>
                                <form action="gestionar_pedidos.php" method="POST" class="form-inline">
                                    <input type="hidden" name="id" value="<?php echo $pedido['id']; ?>">
                                    <select name="estado" class="form-control">
                                        <option value="pendiente" <?php echo ($pedido['estado'] == 'pendiente') ? 'selected' : ''; ?>>Pendiente</option>
                                        <option value="entregado" <?php echo ($pedido['estado'] == 'entregado') ? 'selected' : ''; ?>>Entregado</option>
                                    </select>
                                    <button type="submit" name="actualizarEstado" class="btn btn-primary ml-2">Actualizar</button>
                                </form>
                            </td>
                            <td><?php echo $pedido['total']; ?></td>
                            <td>
                                <!-- Botón para eliminar el pedido -->
                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#confirmarEliminarModal" data-id="<?php echo $pedido['id']; ?>">
                                    <i class="fas fa-trash"></i> Eliminar
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">No hay pedidos registrados.</td>
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
                ¿Estás seguro de que deseas eliminar este pedido?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <a id="confirmarEliminarBtn" href="#" class="btn btn-danger">Eliminar</a>
            </div>
        </div>
    </div>
</div>

<!-- Incluir jQuery antes de Bootstrap -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Script para manejar el modal de confirmación -->
<script>
    $(document).ready(function() {
        var idPedidoAEliminar; // Variable para almacenar el ID del pedido a eliminar

        // Cuando se abre el modal, capturar el ID del pedido
        $('#confirmarEliminarModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Botón que activó el modal
            idPedidoAEliminar = button.data('id'); // Extraer el ID del pedido
            var eliminarBtn = $('#confirmarEliminarBtn'); // Botón de confirmación en el modal

            // Actualizar el enlace de eliminación con el ID del pedido
            eliminarBtn.attr('href', 'gestionar_pedidos.php?action=eliminarPedido&id=' + idPedidoAEliminar);
        });
    });
</script>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/view/partials/footer.php'); ?>