<?php
require_once __DIR__ . '/../config/conexion.php';

class ReporteModel {
    private $con;

    public function __construct($con) {
        $this->con = $con;
    }

    public function obtenerNotificaciones($fecha_inicio, $fecha_fin) {
        $sql = "SELECT * FROM notificaciones WHERE fecha_creacion BETWEEN ? AND ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param('ss', $fecha_inicio, $fecha_fin);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function obtenerProductosPorCategoria($categoria_id) {
        $sql = "SELECT p.id, p.nombre, p.descripcion, p.precio, p.imagen, p.stock, c.nombre AS categoria 
                FROM productos p 
                JOIN categorias c ON p.categoria_id = c.id 
                WHERE p.categoria_id = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param('i', $categoria_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function obtenerPedidos($fecha_inicio, $fecha_fin) {
        $sql = "SELECT p.id, p.usuario_id, p.fecha_pedido, p.estado, p.total, u.nombre AS usuario 
                FROM pedidos p 
                JOIN usuarios u ON p.usuario_id = u.id 
                WHERE p.fecha_pedido BETWEEN ? AND ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param('ss', $fecha_inicio, $fecha_fin);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function obtenerPedidosPersonalizados($fecha_inicio, $fecha_fin) {
        $sql = "SELECT pp.id, pp.descripcion, pp.fecha_entrega, p.id AS pedido_id, u.nombre AS usuario 
                FROM pedidospersonalizados pp 
                JOIN pedidos p ON pp.pedido_id = p.id 
                JOIN usuarios u ON p.usuario_id = u.id 
                WHERE pp.fecha_entrega BETWEEN ? AND ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param('ss', $fecha_inicio, $fecha_fin);
        $stmt->execute();
        return $stmt->get_result();
    }
}
?>