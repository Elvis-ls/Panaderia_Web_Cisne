<?php
class PedidoAdminModel {
    private $con;

    public function __construct($con) {
        $this->con = $con;
    }

    /**
     * Obtiene todos los pedidos con el nombre del usuario asociado.
     */
    public function getPedidos() {
        $query = "SELECT p.id, u.nombre AS nombre_usuario, p.fecha_pedido, p.estado, p.total 
                  FROM pedidos p 
                  JOIN usuarios u ON p.usuario_id = u.id";
        $result = $this->con->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
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
    public function actualizarEstadoPedido($id, $estado) {
        $query = "UPDATE pedidos SET estado = ? WHERE id = ?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('si', $estado, $id);
        return $stmt->execute();
    }
}
?>