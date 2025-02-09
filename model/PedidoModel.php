<?php
require_once __DIR__ . '/../config/conexion.php';

class PedidoModel {
    private $con;

    public function __construct() {
        global $con;
        $this->con = $con;
    }

    public function obtenerPedidos($usuario_id) {
        $sql = "SELECT id, fecha_pedido, total, estado FROM pedidos WHERE usuario_id = ? ORDER BY fecha_pedido DESC";
        $stmt = mysqli_prepare($this->con, $sql);
        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . mysqli_error($this->con));
        }
        mysqli_stmt_bind_param($stmt, "i", $usuario_id);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);

        $pedidos = [];
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $pedidos[] = $fila;
        }

        mysqli_stmt_close($stmt);
        return $pedidos;
    }

    public function obtenerPedidoPorId($pedido_id) {
        $sql = "SELECT * FROM pedidos WHERE id = ?";
        $stmt = mysqli_prepare($this->con, $sql);
        mysqli_stmt_bind_param($stmt, "i", $pedido_id);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        $pedido = mysqli_fetch_assoc($resultado);
        mysqli_stmt_close($stmt);
        return $pedido;
    }

    public function obtenerDetallesPedido($pedido_id) {
        $sql = "SELECT dp.id, dp.cantidad, dp.precio_unitario, p.nombre 
                FROM detallespedidos dp 
                JOIN productos p ON dp.producto_id = p.id 
                WHERE dp.pedido_id = ?";
        $stmt = mysqli_prepare($this->con, $sql);
        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . mysqli_error($this->con));
        }
        mysqli_stmt_bind_param($stmt, "i", $pedido_id);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);

        $detalles = [];
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $detalles[] = $fila;
        }

        mysqli_stmt_close($stmt);
        return $detalles;
    }
}
?>