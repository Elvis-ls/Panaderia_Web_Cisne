<?php
require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../model/ReporteAdminModel.php';
require_once __DIR__ . '/../fpdf182/fpdf.php';

class PDF extends FPDF {
    // Cabecera de página mejorada
    function Header() {
        $this->SetFont('Arial', 'B', 14);
        $this->SetFillColor(200, 200, 200); // Fondo gris claro
        $this->Cell(0, 12, 'Reporte de Productos', 0, 1, 'C', true);
        $this->Ln(5);

        // Encabezados de la tabla
        $this->SetFont('Arial', 'B', 10);
        $this->SetFillColor(230, 230, 230);
        $this->Cell(10, 10, 'ID', 1, 0, 'C', true);
        $this->Cell(40, 10, 'Nombre', 1, 0, 'C', true);
        $this->Cell(60, 10, 'Descripcion', 1, 0, 'C', true);
        $this->Cell(20, 10, 'Precio', 1, 0, 'C', true);
        $this->Cell(10, 10, 'Stock', 1, 0, 'C', true);
        $this->Cell(30, 10, 'Categoria', 1, 0, 'C', true);
        $this->Cell(20, 10, 'Imagen', 1, 1, 'C', true);
    }

    // Pie de página mejorado
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo(), 0, 0, 'C');
    }

    // Ajustar la altura de la celda en función del contenido
    function Row($data) {
        $nb = 0;
        $widths = [10, 40, 60, 20, 10, 30, 20];
        foreach ($data as $i => $col) {
            $nb = max($nb, $this->NbLines($widths[$i], $col));
        }
        $h = 8 * $nb; // Altura ajustada
        $this->CheckPageBreak($h);

        foreach ($data as $i => $col) {
            $w = $widths[$i];
            $x = $this->GetX();
            $y = $this->GetY();
            $this->Rect($x, $y, $w, $h);
            
            if ($i == 6 && $col != 'No Img') { // Si es imagen
                $this->Image($col, $x + 5, $y + 2, 10);
            } else {
                $this->MultiCell($w, 8, utf8_decode($col), 0, 'L');
            }
            $this->SetXY($x + $w, $y);
        }
        $this->Ln($h);
    }

    function CheckPageBreak($h) {
        if ($this->GetY() + $h > $this->PageBreakTrigger) {
            $this->AddPage($this->CurOrientation);
        }
    }

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
    $categoria_id = $_POST['categoria'];

    $reporteModel = new ReporteModel($con);
    $result = $reporteModel->obtenerProductosPorCategoria($categoria_id);

    $pdf = new PDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', '', 10);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data = [
                $row['id'],
                utf8_decode($row['nombre']),
                utf8_decode($row['descripcion']),
                $row['precio'],
                $row['stock'],
                utf8_decode($row['categoria']),
                $row['imagen'] ? __DIR__ . '/../public/images/' . $row['imagen'] : 'No Img'
            ];
            $pdf->Row($data);
        }
    } else {
        $pdf->Cell(0, 10, 'No hay productos disponibles en la categoria seleccionada.', 1, 1, 'C');
    }

    $pdf->Output();
}
?>
