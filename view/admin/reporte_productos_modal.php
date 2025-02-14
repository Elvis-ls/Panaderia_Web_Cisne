<!-- filepath: /c:/xampp/htdocs/Panaderia_Web/view/admin/reporte_productos_modal.php -->
<div class="modal fade" id="reporteProductosModal" tabindex="-1" aria-labelledby="reporteProductosModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg rounded">
            <div class="modal-header" style="background-color: #5a3e2b; color: white;">
                <h5 class="modal-title" id="reporteProductosModalLabel">📊 Reportes de Productos</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form action="/Panaderia_Web/controller/ReporteProductosController.php" method="POST">
                    <div class="mb-3">
                        <label for="categoria" class="form-label fw-bold">Categoría:</label>
                        <select id="categoria" name="categoria" class="form-select border-2" required>
                            <option value="" selected disabled>Seleccione una categoría</option>
                            <option value="1">🍞 Panadería</option>
                            <option value="2">🍰 Pastelería</option>
                            <option value="3">🍪 Galletería</option>
                            <option value="4">🥛 Lácteos</option>
                        </select>
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
