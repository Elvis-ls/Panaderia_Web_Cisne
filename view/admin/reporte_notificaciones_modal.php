<!-- filepath: /c:/xampp/htdocs/Panaderia_Web/view/admin/reporte_notificaciones_modal.php -->
<div class="modal fade" id="reporteNotificacionesModal" tabindex="-1" aria-labelledby="reporteNotificacionesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg rounded">
            <div class="modal-header" style="background-color: #5a3e2b; color: white;">
                <h5 class="modal-title" id="reporteNotificacionesModalLabel">🔔 Reportes de Notificaciones</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form action="../../controller/ReporteNotificacionesController.php" method="POST">
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
