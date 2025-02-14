<?php $pagina = 'gestNotificaciones'; 
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['id'])) {
    header("Location: ../../view/guest/login.php");
    exit;
}


require_once($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/config/conexion.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/controller/NotificacionController.php');

$con = new mysqli($host, $usuario, $contraseña, $base_de_datos);
if ($con->connect_error) {
    die("Conexión fallida: " . $con->connect_error);
}

$controlador = new Controlador($con);
$controlador->manejarAcciones();
$notificaciones = $controlador->mostrarNotificaciones();
?>


<?php include($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/view/partials/header.php'); ?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/view/partials/nav_admin.php'); ?>
<link rel="stylesheet" href="/Panaderia_Web/public/css/style.css">
<link rel="stylesheet" href="/Panaderia_Web/public/css/gest_Notificaciones.css">
<center>
    <main class="main-content">
        
            <h1 class="my-4">Gestionar Notificaciones</h1>

            <!-- Botón para abrir el modal de agregar -->
            <button type="button" class="btn btn-primary mb-4" data-toggle="modal" data-target="#agregarModal">
                Agregar Notificación
            </button>

            <!-- Modal para agregar -->
            <div class="modal fade" id="agregarModal" tabindex="-1" aria-labelledby="agregarModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="agregarModalLabel">Agregar Notificación</h5>
                        </div>
                        <div class="modal-body">
                            <form action="gestionar_notificaciones.php" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="action" value="agregar">
                                <div class="form-group">
                                    <label for="mensaje">Mensaje:</label>
                                    <textarea name="mensaje" class="form-control" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="imagen">Imagen:</label>
                                    <input type="file" name="imagen" class="form-control">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-primary">Agregar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla de notificaciones -->
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Mensaje</th>
                        <th>Imagen</th>
                        <th>Fecha de Creación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($notificaciones)): ?>
                        <?php foreach ($notificaciones as $notificacion): ?>
                            <tr>
                                <td><?php echo $notificacion['id']; ?></td>
                                <td><?php echo $notificacion['mensaje']; ?></td>
                                <td>
                                    <?php if ($notificacion['imagen']): ?>
                                        <img src="<?php echo $notificacion['imagen']; ?>" width="100">
                                    <?php endif; ?>
                                </td>
                                <td><?php echo $notificacion['fecha_creacion']; ?></td>
                                <td class="text-right">
                                    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editarModal<?php echo $notificacion['id']; ?>">Editar</button>
                                    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#eliminarModal<?php echo $notificacion['id']; ?>">Eliminar</button>
                                </td>
                            </tr>

                            <!-- Modal para editar -->
                            <div class="modal fade" id="editarModal<?php echo $notificacion['id']; ?>" tabindex="-1" aria-labelledby="editarModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editarModalLabel">Editar Notificación</h5>
                                        </div>
                                        <div class="modal-body">
                                            <form action="gestionar_notificaciones.php" method="POST" enctype="multipart/form-data">
                                                <input type="hidden" name="action" value="editar">
                                                <input type="hidden" name="id" value="<?php echo $notificacion['id']; ?>">
                                                <input type="hidden" name="imagen_actual" value="<?php echo $notificacion['imagen']; ?>">
                                                <div class="form-group">
                                                    <label for="mensaje">Mensaje:</label>
                                                    <textarea name="mensaje" class="form-control" required><?php echo $notificacion['mensaje']; ?></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="imagen">Imagen:</label>
                                                    <input type="file" name="imagen" class="form-control">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal para eliminar -->
                            <div class="modal fade" id="eliminarModal<?php echo $notificacion['id']; ?>" tabindex="-1" aria-labelledby="eliminarModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="eliminarModalLabel">Eliminar Notificación</h5>
                                        </div>
                                        <div class="modal-body">
                                            <p>¿Estás seguro de que deseas eliminar esta notificación?</p>
                                            <form action="gestionar_notificaciones.php" method="GET">
                                                <input type="hidden" name="action" value="eliminar">
                                                <input type="hidden" name="id" value="<?php echo $notificacion['id']; ?>">
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">No hay notificaciones registradas.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
    </main>
</center>


<!-- Scripts de Bootstrap -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/view/partials/footer.php'); ?>