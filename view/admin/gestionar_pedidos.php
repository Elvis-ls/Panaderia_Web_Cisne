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
    $tipo = $_POST['tipo_pedido']; // Obtener el tipo de pedido

    if ($adminController->actualizarEstadoPedido($id, $estado, $tipo)) {
        $_SESSION['mensaje'] = "Estado del pedido actualizado correctamente.";
    } else {
        $_SESSION['error'] = "Error al actualizar el estado del pedido.";
    }
    header("Location: gestionar_pedidos.php");
    exit;
}

// Obtener los pedidos
$pedidos_normales = $adminController->getPedidos();
$pedidos_personalizados = $adminController->getPedidosPersonalizados();
?>

<?php $pagina = 'gestPedidos'; ?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/view/partials/header_admin.php'); ?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/view/partials/nav_admin.php'); ?>
<link rel="stylesheet" href="/Panaderia_Web/public/css/style.css">
<link rel="stylesheet" href="/Panaderia_Web/public/css/pedidos.css">




<center>
<main class="main-content">
        <h1 class="my-4">Gestionar Pedidos</h1>

        <!-- Mensajes de éxito o error -->
        <?php if (isset($_SESSION['mensaje'])): ?>
            <div class="alert alert-success"><?php echo $_SESSION['mensaje']; unset($_SESSION['mensaje']); ?></div>
        <?php endif; ?>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <!-- Pestañas de Bootstrap -->
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="pedidos-normales-tab" data-toggle="tab" href="#pedidos-normales" role="tab" aria-controls="pedidos-normales" aria-selected="true">Pedidos Normales</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pedidos-personalizados-tab" data-toggle="tab" href="#pedidos-personalizados" role="tab" aria-controls="pedidos-personalizados" aria-selected="false">Pedidos Personalizados</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <!-- Pestaña de Pedidos Normales -->
            <div class="tab-pane fade show active" id="pedidos-normales" role="tabpanel" aria-labelledby="pedidos-normales-tab">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID Pedido</th>
                            <th>Usuario</th>
                            <th>Fecha del Pedido</th>
                            <th>Estado</th>
                            <th>Total</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($pedidos_normales)): ?>
                            <?php foreach ($pedidos_normales as $pedido): ?>
                                <tr>
                                    <td><?php echo $pedido['id']; ?></td>
                                    <td><?php echo $pedido['nombre_usuario']; ?></td>
                                    <td><?php echo $pedido['fecha_pedido']; ?></td>
                                    <td>
                                        <span class="estado-pedido"><?php echo ucfirst($pedido['estado']); ?></span>
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#actualizarPedidoModal" data-id="<?php echo $pedido['id']; ?>" data-tipo="normal">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </td>
                                    <td>$<?php echo number_format($pedido['total'], 2); ?></td>
                                    <td>
                                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#verDetallesModal" data-id="<?php echo $pedido['id']; ?>">
                                            <i class="fas fa-eye"></i> Ver
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">No hay pedidos normales registrados.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pestaña de Pedidos Personalizados -->
            <div class="tab-pane fade" id="pedidos-personalizados" role="tabpanel" aria-labelledby="pedidos-personalizados-tab">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID Pedido Personalizado</th>
                            <th>Usuario</th>
                            <th>Fecha de Entrega</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($pedidos_personalizados)): ?>
                            <?php foreach ($pedidos_personalizados as $pedido_personalizado): ?>
                                <tr>
                                    <td><?php echo $pedido_personalizado['id']; ?></td>
                                    <td><?php echo $pedido_personalizado['nombre_usuario']; ?></td>
                                    <td><?php echo $pedido_personalizado['fecha_entrega']; ?></td>
                                    <td><?php echo nl2br($pedido_personalizado['descripcion']); ?></td>
                                    <td>
                                        <span class="estado-pedido"><?php echo ucfirst($pedido_personalizado['estado']); ?></span>
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#actualizarPedidoModal" data-id="<?php echo $pedido_personalizado['id']; ?>" data-tipo="personalizado">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    </td>
                                    <td>$<?php echo number_format($pedido_personalizado['total'], 2); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center">No hay pedidos personalizados registrados.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</center>

<!-- Modal para ver detalles del pedido -->
<div class="modal fade" id="verDetallesModal" tabindex="-1" role="dialog" aria-labelledby="verDetallesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="verDetallesModalLabel">Detalles del Pedido</h5>
            </div>
            <div class="modal-body" id="detallesPedidoBody">
                <!-- Los detalles del pedido se cargarán aquí dinámicamente -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal para actualizar el pedido -->
<div class="modal fade" id="actualizarPedidoModal" tabindex="-1" role="dialog" aria-labelledby="actualizarPedidoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="actualizarPedidoModalLabel">Actualizar Estado del Pedido</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="gestionar_pedidos.php" method="POST">
                    <input type="hidden" name="id" id="pedidoId">
                    <input type="hidden" name="tipo_pedido" id="tipoPedido"> <!-- Campo oculto para el tipo de pedido -->
                    <div class="form-group">
                        <label for="estado">Estado del Pedido</label>
                        <select name="estado" id="estado" class="form-control">
                            <option value="pendiente">Pendiente</option>
                            <option value="entregado">Entregado</option>
                        </select>
                    </div>
                    <br>
                    <div class="text-center">
                        <button type="submit" name="actualizarEstado" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>



<!-- Incluir jQuery antes de Bootstrap -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function() {
        // Cuando se abre el modal de actualización, capturar el ID y el tipo de pedido
        $('#actualizarPedidoModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Botón que activó el modal
            var idPedido = button.data('id'); // Extraer el ID del pedido
            var tipoPedido = button.data('tipo'); // Extraer el tipo de pedido (normal o personalizado)
            var modal = $(this);

            // Asignar el ID y el tipo de pedido a los campos ocultos
            modal.find('.modal-body #pedidoId').val(idPedido);
            modal.find('.modal-body #tipoPedido').val(tipoPedido);
        });
    });
</script>
<!-- Script para cargar los detalles del pedido en el modal -->
<script>
    $(document).ready(function() {
        $('#verDetallesModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Botón que activó el modal
            var idPedido = button.data('id'); // Extraer el ID del pedido
            var modal = $(this);

            // Cargar los detalles del pedido mediante AJAX
            $.ajax({
                url: 'obtener_detalles_pedido.php', // Archivo que obtiene los detalles del pedido
                type: 'GET',
                data: { id: idPedido },
                success: function(response) {
                    modal.find('.modal-body').html(response); // Insertar la respuesta en el modal
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function() {
        // Cuando se abre el modal de actualización, capturar el ID y el tipo de pedido
        $('#actualizarPedidoModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Botón que activó el modal
            var idPedido = button.data('id'); // Extraer el ID del pedido
            var tipoPedido = button.data('tipo'); // Extraer el tipo de pedido (normal o personalizado)
            var modal = $(this);

            // Asignar el ID y el tipo de pedido a los campos ocultos
            modal.find('.modal-body #pedidoId').val(idPedido);
            modal.find('.modal-body #tipoPedido').val(tipoPedido);
        });
    });
</script>



<?php include($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/view/partials/footer.php'); ?>