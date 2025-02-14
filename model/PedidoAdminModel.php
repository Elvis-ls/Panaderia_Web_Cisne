<?php
class PedidoAdminModel {
    private $con;

    public function __construct($con) {
        $this->con = $con;
    }

    /**
     * Obtiene todos los pedidos con el nombre del usuario asociado.
     */
// En el AdminController
public function getPedidosNormales() {
    $sql = "SELECT p.id, p.fecha_pedido, p.total, p.estado, u.nombre AS nombre_usuario 
            FROM pedidos p 
            JOIN usuarios u ON p.usuario_id = u.id 
            WHERE NOT EXISTS (SELECT 1 FROM pedidospersonalizados pp WHERE pp.pedido_id = p.id)
            ORDER BY p.fecha_pedido DESC";
    $resultado = $this->con->query($sql);
    $pedidos = [];
    while ($fila = $resultado->fetch_assoc()) {
        $pedidos[] = $fila;
    }
    return $pedidos;
}
public function getPedidosPersonalizados() {
    $sql = "SELECT pp.id, pp.descripcion, pp.fecha_entrega, p.estado, p.total, u.nombre AS nombre_usuario 
            FROM pedidospersonalizados pp 
            JOIN pedidos p ON pp.pedido_id = p.id 
            JOIN usuarios u ON p.usuario_id = u.id 
            ORDER BY pp.fecha_entrega DESC";
    $resultado = $this->con->query($sql);
    $pedidos_personalizados = [];
    while ($fila = $resultado->fetch_assoc()) {
        $pedidos_personalizados[] = $fila;
    }
    return $pedidos_personalizados;
}
    /**
     * Elimina un pedido y sus detalles asociados.
     */
    public function eliminarPedido($id) {
        // Eliminar detalles del pedido primero
        $queryDetalles = "DELETE FROM detallespedidos WHERE pedido_id = ?";
        $stmtDetalles = $this->con->prepare($queryDetalles);
        $stmtDetalles->bind_param('i', $id);
        if (!$stmtDetalles->execute()) {
            error_log("Error al eliminar detalles del pedido: " . $stmtDetalles->error);
            return false;
        }

        // Luego eliminar el pedido
        $queryPedido = "DELETE FROM pedidos WHERE id = ?";
        $stmtPedido = $this->con->prepare($queryPedido);
        $stmtPedido->bind_param('i', $id);
        if (!$stmtPedido->execute()) {
            error_log("Error al eliminar el pedido: " . $stmtPedido->error);
            return false;
        }

        return true;
    }
    /**
     * Actualiza el estado de un pedido.
     */
    
     public function actualizarEstadoPedido($id, $estado, $tipo) {
        if ($tipo === 'normal') {
            $sql = "UPDATE pedidos SET estado = ? WHERE id = ?";
        } elseif ($tipo === 'personalizado') {
            $sql = "UPDATE pedidos p 
                    JOIN pedidospersonalizados pp ON p.id = pp.pedido_id 
                    SET p.estado = ? 
                    WHERE pp.id = ?";
        } else {
            return false; // Tipo de pedido no válido
        }
    
        $stmt = $this->con->prepare($sql);
        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . $this->con->error);
        }
        $stmt->bind_param("si", $estado, $id);
        return $stmt->execute();
    }

    public function obtenerDetallesPedido($id) {
        $sql = "SELECT dp.id, dp.cantidad, dp.precio_unitario, p.nombre 
                FROM detallespedidos dp 
                JOIN productos p ON dp.producto_id = p.id 
                WHERE dp.pedido_id = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $detalles = [];
        while ($fila = $resultado->fetch_assoc()) {
            $detalles[] = $fila;
        }
        return $detalles;
    }
}
?>