<!-- filepath: /c:/xampp/htdocs/Panaderia_Web/view/admin/reporte_pedidos_modal.php -->
<div class="modal fade" id="reportePedidosModal" tabindex="-1" aria-labelledby="reportePedidosModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg rounded">
            <div class="modal-header" style="background-color: #5a3e2b; color: white;">
                <h5 class="modal-title" id="reportePedidosModalLabel">📦 Reportes de Pedidos</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form action="/Panaderia_Web/controller/ReportePedidosController.php" method="POST">
                    <div class="mb-3">
                        <label for="tipo_pedido" class="form-label fw-bold">Tipo de Pedido:</label>
                        <select id="tipo_pedido" name="tipo_pedido" class="form-control border-2" required>
                            <option value="">Seleccione un tipo de pedido</option>
                            <option value="normal">Normal</option>
                            <option value="personalizado">Personalizado</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="fecha_inicio" class="form-label fw-bold">Fecha de Inicio:</label>
                        <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control border-2" required>
                    </div>
                    <div class="mb-3">
                        <label for="fecha_fin" class="form-label fw-bold">Fecha de Fin:</label>
                        <input type="date" id="fecha_fin" name="fecha_fin" class="form-control border-2" required>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn text-white" style="background-color: #8d583d;">📄 Generar Reporte</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">❌ Cerrar</button>
            </div>
        </div>
    </div>
</div>
