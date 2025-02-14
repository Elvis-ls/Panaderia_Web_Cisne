<?php
require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../model/ReporteAdminModel.php';
require_once __DIR__ . '/../fpdf182/fpdf.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];

    $reporteModel = new ReporteModel($con);
    $result = $reporteModel->obtenerNotificaciones($fecha_inicio, $fecha_fin);

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Reporte de Notificaciones', 0, 1, 'C');
    $pdf->SetFont('Arial', '', 10);

    if ($result->num_rows > 0) {
        $pdf->Cell(10, 10, 'ID', 1);
        $pdf->Cell(80, 10, 'Mensaje', 1);
        $pdf->Cell(30, 10, 'Fecha de Creacion', 1);
        $pdf->Cell(30, 10, 'Fecha de Eliminacion', 1);
        $pdf->Cell(40, 10, 'Imagen', 1);
        $pdf->Ln();

        while ($row = $result->fetch_assoc()) {
            $pdf->Cell(10, 10, $row['id'], 1);
            $pdf->Cell(80, 10, $row['mensaje'], 1);
            $pdf->Cell(30, 10, $row['fecha_creacion'], 1);
            $pdf->Cell(30, 10, $row['fecha_eliminacion'] ? $row['fecha_eliminacion'] : 'N/A', 1);
            $pdf->Cell(40, 10, $row['imagen'], 1);
            $pdf->Ln();
        }
    } else {
        $pdf->Cell(0, 10, 'No hay notificaciones disponibles en el rango de fechas seleccionado.', 0, 1);
    }

    $pdf->Output();
}
?>