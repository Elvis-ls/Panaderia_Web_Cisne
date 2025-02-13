<?php
require_once __DIR__ . '/../fpdf182/fpdf.php';
require_once __DIR__ . '/../model/PedidoModel.php';

class PDF extends FPDF {
    // Cabecera de página
    function Header() {
        // Logo
        $this->Image(__DIR__ . '/../public/images/logo.png',10,8,33);
        // Arial bold 15
        $this->SetFont('Arial','B',15);
        // Movernos a la derecha
        $this->Cell(80);
        // Título
        $this->Cell(30,10,'Reporte de Pedido Personalizado',0,1,'C');
        // Salto de línea
        $this->Ln(20);
    }

    // Pie de página
    function Footer() {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Número de página
        $this->Cell(0,10,'Página '.$this->PageNo().'/{nb}',0,0,'C');
    }

    // Contenido del pedido personalizado
    function PedidoPersonalizadoContent($pedido, $pedido_personalizado) {
        // Fuente
        $this->SetFont('Arial','',12);

        // Información del pedido
        $this->Cell(0,10,'Detalles del Pedido',0,1,'C');
        $this->Ln(10);

        // Detalles del pedido
        $this->SetFont('Arial','B',12);
        $this->Cell(50,10,'ID Pedido:',0,0);
        $this->SetFont('Arial','',12);
        $this->Cell(0,10,$pedido['id'],0,1);
        
        $this->SetFont('Arial','B',12);
        $this->Cell(50,10,'Fecha de Pedido:',0,0);
        $this->SetFont('Arial','',12);
        $this->Cell(0,10,$pedido['fecha_pedido'],0,1);
        
        $this->SetFont('Arial','B',12);
        $this->Cell(50,10,'Cliente:',0,0);
        $this->SetFont('Arial','',12);
        $this->Cell(0,10,$pedido['cliente'],0,1);
        
        $this->SetFont('Arial','B',12);
        $this->Cell(50,10,'Total:',0,0);
        $this->SetFont('Arial','',12);
        $this->Cell(0,10,$pedido['total'],0,1);
        $this->Ln(10);

        // Información del pedido personalizado
        $this->Cell(0,10,'Detalles del Pedido Personalizado',0,1,'C');
        $this->Ln(10);

        // Detalles del pedido personalizado
        $this->SetFont('Arial','B',12);
        $this->Cell(50,10,'ID Pedido Personalizado:',0,0);
        $this->SetFont('Arial','',12);
        $this->Cell(0,10,$pedido_personalizado['id'],0,1);
        
        $this->SetFont('Arial','B',12);
        $this->Cell(50,10,'Fecha de Entrega:',0,0);
        $this->SetFont('Arial','',12);
        $this->Cell(0,10,$pedido_personalizado['fecha_entrega'],0,1);
        
        $this->SetFont('Arial','B',12);
        $this->Cell(50,10,'Estado:',0,0);
        $this->SetFont('Arial','',12);
        $this->Cell(0,10,$pedido_personalizado['estado'],0,1);
        
        $this->SetFont('Arial','B',12);
        $this->Cell(50,10,'Descripción:',0,1);
        $this->SetFont('Arial','',12);
        $this->MultiCell(0,10,utf8_decode($pedido_personalizado['descripcion']),0,1);
        $this->Ln(10);

        // Agregar más detalles si es necesario
        if (!empty($pedido_personalizado['imagen_referencia'])) {
            $this->SetFont('Arial','B',12);
            $this->Cell(0,10,'Imagen de Referencia',0,1);
            $this->Ln(5);
            $this->Image($_SERVER['DOCUMENT_ROOT'] . $pedido_personalizado['imagen_referencia'], 10, $this->GetY(), 50);
            $this->Ln(60); // Ajustar el salto de línea según el tamaño de la imagen
        }
    }
}

// Verificar si se ha pasado el ID del pedido personalizado
if (isset($_GET['pedido_personalizado_id'])) {
    $pedido_personalizado_id = $_GET['pedido_personalizado_id'];

    // Crear una instancia del modelo de pedidos
    $pedidoModel = new PedidoModel();
    $pedido_personalizado = $pedidoModel->obtenerPedidoPersonalizadoPorId($pedido_personalizado_id);

    if ($pedido_personalizado && isset($pedido_personalizado['pedido_id'])) {
        $pedido = $pedidoModel->obtenerPedidoPorId($pedido_personalizado['pedido_id']); // Asumiendo que hay un campo 'pedido_id' en el pedido personalizado

        if ($pedido) {
            // Crear el PDF
            $pdf = new PDF();
            $pdf->AliasNbPages();
            $pdf->AddPage();
            $pdf->SetFont('Arial','B',12);

            // Agregar contenido al PDF
            $pdf->PedidoPersonalizadoContent($pedido, $pedido_personalizado);

            // Salida del PDF
            $pdf->Output();
        } else {
            echo "Pedido no encontrado.";
        }
    } else {
        echo "Pedido personalizado no encontrado o no tiene un 'pedido_id'.";
    }
} else {
    echo "ID de pedido personalizado no especificado.";
}
?>