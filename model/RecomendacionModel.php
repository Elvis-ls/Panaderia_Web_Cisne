<?php
require_once __DIR__ . '/../config/conexion.php';

class RecomendacionesModel {
    private $con;

    public function __construct() {
        global $con;
        $this->con = $con;
    }

    public function obtenerProductosRecomendados($usuario_id) {
        $query = "SELECT r.producto_id, p.nombre, p.precio, p.imagen, r.num_pedidos
                  FROM recomendados r
                  JOIN productos p ON r.producto_id = p.id
                  WHERE r.usuario_id = ?";
        
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('i', $usuario_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function eliminarRecomendacion($usuario_id, $producto_id) {
        $query = "DELETE FROM recomendados WHERE usuario_id = ? AND producto_id = ?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('ii', $usuario_id, $producto_id);
        $stmt->execute();
    }

    public function actualizarRecomendaciones($usuario_id) {
        // Eliminar recomendaciones existentes
        $query = "DELETE FROM recomendados WHERE usuario_id = ?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('i', $usuario_id);
        $stmt->execute();

        // Insertar nuevas recomendaciones
        $query = "INSERT INTO recomendados (usuario_id, producto_id, num_pedidos)
                  SELECT ?, dp.producto_id, COUNT(DISTINCT dp.pedido_id) as num_pedidos
                  FROM detallespedidos dp
                  JOIN pedidos pe ON dp.pedido_id = pe.id
                  WHERE pe.usuario_id = ?
                  GROUP BY dp.producto_id
                  HAVING num_pedidos >= 2";
        
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('ii', $usuario_id, $usuario_id);
        $stmt->execute();
    }
}
?>