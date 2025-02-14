<!-- filepath: /c:/xampp/htdocs/Panaderia_Web/view/user/pedido_personalizado.php -->
<div class="modal-content">
    <span class="close" style="font-size: 24px; cursor: pointer;">&times;</span>
    <h5 class="modal-title text-center mb-4" id="pedidoPersonalizadoModalLabel" style="color: #3e3e3e; font-weight: bold;">Pedido Personalizado</h5>

    <!-- Indicaciones -->
    <div class="alert alert-info mb-4" role="alert">
        <strong>Indicaciones:</strong> Por favor, complete el siguiente formulario para enviar su pedido personalizado. Asegúrese de proporcionar una descripción detallada y una imagen de referencia si es posible. La fecha de entrega debe ser al menos 3 días después de la fecha actual. No olvide incluir un precio estimado en la descripción.
    </div>

    <form action="/Panaderia_Web/controller/PedidoPersonalizadoController.php" method="POST" enctype="multipart/form-data">
        <!-- Nombre del Producto -->
        <div class="form-group mb-3">
            <label for="nombre" class="form-label">Nombre del Producto:</label>
            <input type="text" id="nombre" name="nombre" class="form-control custom-input" required>
        </div>

        <!-- Descripción -->
        <div class="form-group mb-3">
            <label for="descripcion" class="form-label">Descripción:</label>
            <textarea id="descripcion" name="descripcion" class="form-control custom-input" rows="4" required></textarea>
        </div>

        <!-- Cantidad -->
        <div class="form-group mb-3">
            <label for="cantidad" class="form-label">Cantidad:</label>
            <input type="number" id="cantidad" name="cantidad" class="form-control custom-input" min="1" required>
        </div>

        <!-- Fecha de Entrega -->
        <div class="form-group mb-3">
            <label for="fecha_entrega" class="form-label">Fecha de Entrega:</label>
            <input type="date" id="fecha_entrega" name="fecha_entrega" class="form-control custom-input" required>
        </div>

        <!-- Imagen de Referencia -->
        <div class="form-group mb-3">
            <label for="imagen_referencia" class="form-label">Imagen de Referencia:</label>
            <input type="file" id="imagen_referencia" name="imagen_referencia" class="form-control-file" accept="image/*">
        </div>

        <!-- Campos ocultos -->
        <input type="hidden" name="total" value="0"> <!-- Ajusta el valor del total según sea necesario -->
        <input type="hidden" name="accion" value="crearPedidoPersonalizado">

        <!-- Botones de acción -->
        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-primary custom-btn">Enviar Pedido</button>
            <button type="button" class="btn btn-secondary custom-cancel-btn" onclick="document.getElementById('pedidoPersonalizadoModal').style.display='none'">Cancelar</button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fechaEntregaInput = document.getElementById('fecha_entrega');
        const today = new Date();
        today.setDate(today.getDate() + 3); // Añadir 3 días a la fecha actual
        const minDate = today.toISOString().split('T')[0]; // Formatear la fecha en YYYY-MM-DD
        fechaEntregaInput.setAttribute('min', minDate);
    });
</script>
