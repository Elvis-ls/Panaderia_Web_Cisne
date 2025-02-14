<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/config/conexion.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/controller/AdminController.php');

$con = new mysqli($host, $usuario, $contraseña, $base_de_datos);
$adminController = new AdminController($con);

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $detalles = $adminController->obtenerDetallesPedido($id); // Método para obtener detalles

    if (!empty($detalles)) {
        echo "<h4>Detalles del Pedido #$id</h4>";
        echo "<table class='table table-bordered'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Producto</th>";
        echo "<th>Cantidad</th>";
        echo "<th>Precio Unitario</th>";
        echo "<th>Subtotal</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        $total = 0; // Variable para calcular el total del pedido

        foreach ($detalles as $detalle) {
            $subtotal = $detalle['cantidad'] * $detalle['precio_unitario'];
            $total += $subtotal;

            echo "<tr>";
            echo "<td>{$detalle['nombre']}</td>";
            echo "<td>{$detalle['cantidad']}</td>";
            echo "<td>$" . number_format($detalle['precio_unitario'], 2) . "</td>";
            echo "<td>$" . number_format($subtotal, 2) . "</td>";
            echo "</tr>";
        }

        echo "<tr>";
        echo "<td colspan='3' class='text-right'><strong>Total:</strong></td>";
        echo "<td><strong>$" . number_format($total, 2) . "</strong></td>";
        echo "</tr>";

        echo "</tbody>";
        echo "</table>";
    } else {
        echo "<p>No se encontraron detalles para este pedido.</p>";
    }
}
?>