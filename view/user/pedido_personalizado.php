<div class="modal-content">
    <span class="close">&times;</span>
    <h5 class="modal-title" id="pedidoPersonalizadoModalLabel">Pedido Personalizado</h5>
    <form action="/Panaderia_Web/controller/PedidoController.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="nombre">Nombre del Producto:</label>
            <input type="text" id="nombre" name="nombre" class="form-control custom-input" required>
        </div>
        <div class="form-group">
            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" class="form-control custom-input" required></textarea>
        </div>
        <div class="form-group">
            <label for="cantidad">Cantidad:</label>
            <input type="number" id="cantidad" name="cantidad" class="form-control custom-input" min="1" required>
        </div>
        <div class="form-group">
            <label for="fecha_entrega">Fecha de Entrega:</label>
            <input type="date" id="fecha_entrega" name="fecha_entrega" class="form-control custom-input" required>
        </div>
        <div class="form-group">
            <label for="imagen_referencia">Imagen de Referencia:</label>
            <input type="file" id="imagen_referencia" name="imagen_referencia" class="form-control-file" accept="image/*">
        </div>
        <input type="hidden" name="total" value="0"> <!-- Ajusta el valor del total según sea necesario -->
        <input type="hidden" name="accion" value="crearPedidoPersonalizado">
        <div class="d-flex justify-content-between">
            <button type="submit" class="btn custom-btn">Enviar Pedido</button>
            <button type="button" class="btn custom-cancel-btn" onclick="document.getElementById('pedidoPersonalizadoModal').style.display='none'">Cancelar</button>
        </div>
    </form>
</div>
