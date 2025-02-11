<?php $pagina = 'galleteria'; ?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/view/partials/header.php'); ?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/view/partials/nav_admin.php'); ?>

<link rel="stylesheet" href="/Panaderia_Web/public/css/productos.css">
<link rel="stylesheet" href="/Panaderia_Web/public/css/style.css">

<main class="main-content">
    <h1>Galletería</h1>
    <button class="btn btn-success" data-toggle="modal" data-target="#agregarModal">Agregar Producto</button>
    <div class="productos">
        <?php if (!empty($productos)): ?>
            <?php foreach ($productos as $producto): ?>
                <div class="producto">
                    <img src="/Panaderia_Web/public/images/<?php echo $producto['imagen']; ?>" alt="<?php echo $producto['nombre']; ?>">
                    <h2><?php echo $producto['nombre']; ?></h2>
                    <p><?php echo $producto['descripcion']; ?></p>
                    <p>Precio: <?php echo $producto['precio']; ?></p>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#editarModal" data-id="<?php echo $producto['id']; ?>" data-nombre="<?php echo $producto['nombre']; ?>" data-descripcion="<?php echo $producto['descripcion']; ?>" data-precio="<?php echo $producto['precio']; ?>" data-categoria_id="<?php echo $producto['categoria_id']; ?>" data-imagen="<?php echo $producto['imagen']; ?>">Editar</button>
                    <button class="btn btn-danger" data-toggle="modal" data-target="#eliminarModal" data-id="<?php echo $producto['id']; ?>">Eliminar</button>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No hay productos disponibles en esta categoría.</p>
        <?php endif; ?>
    </div>
</main>

<!-- Modal para agregar producto -->
<div class="modal fade" id="agregarModal" tabindex="-1" role="dialog" aria-labelledby="agregarModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="agregarModalLabel">Agregar Producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="agregarProductoForm" method="POST" action="../../controller/ProductoAdminController.php?action=agregar" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="precio">Precio</label>
                        <input type="number" step="0.01" class="form-control" id="precio" name="precio" required>
                    </div>
                    <div class="form-group">
                        <label for="categoria_id">Categoría</label>
                        <select class="form-control" id="categoria_id" name="categoria_id" required>
                            <?php foreach ($categorias as $categoria): ?>
                                <option value="<?php echo $categoria['id']; ?>"><?php echo $categoria['nombre']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="imagen">Imagen</label>
                        <input type="file" class="form-control" id="imagen" name="imagen" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Agregar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para editar producto -->
<div class="modal fade" id="editarModal" tabindex="-1" role="dialog" aria-labelledby="editarModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarModalLabel">Editar Producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editarProductoForm" method="POST" action="../../controller/ProductoAdminController.php?action=editar" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" id="editar_id" name="id">
                    <div class="form-group">
                        <label for="editar_nombre">Nombre</label>
                        <input type="text" class="form-control" id="editar_nombre" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="editar_descripcion">Descripción</label>
                        <textarea class="form-control" id="editar_descripcion" name="descripcion" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="editar_precio">Precio</label>
                        <input type="number" step="0.01" class="form-control" id="editar_precio" name="precio" required>
                    </div>
                    <div class="form-group">
                        <label for="editar_categoria_id">Categoría</label>
                        <select class="form-control" id="editar_categoria_id" name="categoria_id" required>
                            <?php foreach ($categorias as $categoria): ?>
                                <option value="<?php echo $categoria['id']; ?>"><?php echo $categoria['nombre']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="editar_imagen">Imagen</label>
                        <input type="file" class="form-control" id="editar_imagen" name="imagen">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para eliminar producto -->
<div class="modal fade" id="eliminarModal" tabindex="-1" role="dialog" aria-labelledby="eliminarModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eliminarModalLabel">Eliminar Producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="eliminarProductoForm" method="POST" action="/Panaderia_Web/controller/ProductoAdminController.php?action=eliminar">
                <div class="modal-body">
                    <input type="hidden" id="eliminar_id" name="id">
                    <p>¿Estás seguro de que deseas eliminar este producto?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/view/partials/footer.php'); ?>

<!-- Incluir jQuery y Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="../../public/js/modalesProductos.js"></script>
