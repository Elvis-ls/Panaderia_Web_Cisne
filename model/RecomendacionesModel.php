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
}
?>