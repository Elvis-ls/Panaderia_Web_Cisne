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
        $this->Cell(30,10,'Reporte de Pedido',0,1,'C');
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

    // Contenido del pedido
    function PedidoContent($pedido, $detalles) {
        // Fuente
        $this->SetFont('Arial','',12);
        
        // Información del pedido
        $this->Cell(0,10,'ID Pedido: ' . $pedido['id'],0,1);
        $this->Cell(0,10,'Fecha: ' . $pedido['fecha_pedido'],0,1);
        $this->Cell(0,10,'Total: $' . number_format($pedido['total'], 2),0,1);
        $this->Cell(0,10,'Estado: ' . $pedido['estado'],0,1);
        $this->Ln(10);

        // Detalles del pedido
        $this->SetFont('Arial','B',12);
        $this->Cell(0,10,'Detalles del Pedido',0,1);
        $this->SetFont('Arial','',12);
        
        // Encabezados de la tabla
        $this->Cell(60,10,'Producto',1);
        $this->Cell(30,10,'Cantidad',1);
        $this->Cell(50,10,'Precio Unitario',1);
        $this->Cell(50,10,'Subtotal',1);
        $this->Ln();

        // Datos de la tabla
        foreach ($detalles as $detalle) {
            $this->Cell(60,10,$detalle['nombre'],1);
            $this->Cell(30,10,$detalle['cantidad'],1);
            $this->Cell(50,10,'$' . number_format($detalle['precio_unitario'], 2),1);
            $this->Cell(50,10,'$' . number_format($detalle['cantidad'] * $detalle['precio_unitario'], 2),1);
            $this->Ln();
        }
        $this->Ln(10);
    }
}

// Verificar si se ha pasado el ID del pedido
if (isset($_GET['pedido_id'])) {
    $pedido_id = $_GET['pedido_id'];

    // Crear una instancia del modelo de pedidos
    $pedidoModel = new PedidoModel();
    $pedido = $pedidoModel->obtenerPedidoPorId($pedido_id);
    $detalles = $pedidoModel->obtenerDetallesPedido($pedido_id);

    if ($pedido) {
        // Crear el PDF
        $pdf = new PDF();
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',12);

        // Agregar contenido al PDF
        $pdf->PedidoContent($pedido, $detalles);

        // Salida del PDF
        $pdf->Output();
    } else {
        echo "Pedido no encontrado.";
    }
} else {
    echo "ID de pedido no especificado.";
}
?>