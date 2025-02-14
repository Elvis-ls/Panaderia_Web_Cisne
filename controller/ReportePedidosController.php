<?php
require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../model/ReporteAdminModel.php';
require_once __DIR__ . '/../fpdf182/fpdf.php';

class PDF extends FPDF {
    // Cabecera de página
    function Header() {
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 10, 'Reporte de Pedidos', 0, 1, 'C');
        $this->Ln(10);
    }

    // Pie de página
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo(), 0, 0, 'C');
    }

    // Ajustar la altura de la celda en función del contenido
    function Row($data, $widths) {
        $nb = 0;
        foreach ($data as $i => $col) {
            $nb = max($nb, $this->NbLines($widths[$i], $col));
        }
        $h = 10 * $nb;
        $this->CheckPageBreak($h);
        foreach ($data as $i => $col) {
            $w = $widths[$i];
            $x = $this->GetX();
            $y = $this->GetY();
            $this->Rect($x, $y, $w, $h);
            $this->MultiCell($w, 10, $col, 0, 'L');
            $this->SetXY($x + $w, $y);
        }
        $this->Ln($h);
    }

    // Verificar si se necesita un salto de página
    function CheckPageBreak($h) {
        if ($this->GetY() + $h > $this->PageBreakTrigger) {
            $this->AddPage($this->CurOrientation);
        }
    }

    // Calcular el número de líneas necesarias para una celda
    function NbLines($w, $txt) {
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0) {
            $w = $this->w - $this->rMargin - $this->x;
        }
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 && $s[$nb - 1] == "\n") {
            $nb--;
        }
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ') {
                $sep = $i;
            }
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j) {
                        $i++;
                    }
                } else {
                    $i = $sep + 1;
                }
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else {
                $i++;
            }
        }
        return $nl;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo_pedido = $_POST['tipo_pedido'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];

    $reporteModel = new ReporteModel($con);

    $pdf = new PDF();
    $pdf->AddPage();

    // Título del reporte
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'Reporte de Pedidos', 0, 1, 'C');
    $pdf->Ln(10);

    // Subtítulo de fecha
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, 'Fecha de Inicio: ' . $fecha_inicio . ' - Fecha de Fin: ' . $fecha_fin, 0, 1, 'C');
    $pdf->Ln(5);

    // Definir el ancho total de la tabla
    $table_width = 190;  // Ajustar el ancho total de la tabla
    $col_widths = [10, 50, 50, 40, 40];  // Definir el ancho de cada columna
    $pdf->SetFont('Arial', 'B', 10);

    if ($tipo_pedido == 'normal') {
        $result = $reporteModel->obtenerPedidos($fecha_inicio, $fecha_fin);

        if ($result->num_rows > 0) {
            // Encabezados de columna
            $pdf->SetX((210 - $table_width) / 2);  // Centrar la tabla en la página
            $pdf->Cell($col_widths[0], 10, 'ID', 1, 0, 'C');
            $pdf->Cell($col_widths[1], 10, 'Usuario', 1, 0, 'C');
            $pdf->Cell($col_widths[2], 10, 'Fecha de Pedido', 1, 0, 'C');
            $pdf->Cell($col_widths[3], 10, 'Estado', 1, 0, 'C');
            $pdf->Cell($col_widths[4], 10, 'Total', 1, 1, 'C');
            
            // Rellenar los datos de los pedidos
            while ($row = $result->fetch_assoc()) {
                $data = [
                    $row['id'],
                    $row['usuario'],
                    $row['fecha_pedido'],
                    $row['estado'],
                    '$' . number_format($row['total'], 2)
                ];
                $pdf->Row($data, $col_widths);
            }
        } else {
            $pdf->Ln(10);
            $pdf->Cell(0, 10, 'No hay pedidos normales disponibles en el rango de fechas seleccionado.', 0, 1, 'C');
        }
    } else {
        $result = $reporteModel->obtenerPedidosPersonalizados($fecha_inicio, $fecha_fin);

        if ($result->num_rows > 0) {
            // Encabezados de columna para pedidos personalizados
            $pdf->SetX((210 - $table_width) / 2);  // Centrar la tabla en la página
            $pdf->Cell($col_widths[0], 10, 'ID', 1, 0, 'C');
            $pdf->Cell($col_widths[1], 10, 'Usuario', 1, 0, 'C');
            $pdf->Cell($col_widths[2], 10, 'Descripcion', 1, 0, 'C');
            $pdf->Cell($col_widths[3], 10, 'Fecha de Entrega', 1, 0, 'C');
            $pdf->Cell($col_widths[4], 10, 'ID Pedido', 1, 1, 'C');
            
            // Rellenar los datos de los pedidos personalizados
            while ($row = $result->fetch_assoc()) {
                $data = [
                    $row['id'],
                    $row['usuario'],
                    $row['descripcion'],
                    $row['fecha_entrega'],
                    $row['pedido_id']
                ];
                $pdf->Row($data, $col_widths);
            }
        } else {
            $pdf->Ln(10);
            $pdf->Cell(0, 10, 'No hay pedidos personalizados disponibles en el rango de fechas seleccionado.', 0, 1, 'C');
        }
    }

    // Salida del archivo PDF
    $pdf->Output();
}
?>