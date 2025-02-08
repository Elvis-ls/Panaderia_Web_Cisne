<?php
// model/PedidoModel.php
require_once '../config/database.php'; // Incluye la conexión

class PedidoModel {
    private $con;

    public function __construct() {
        global $con; // Usamos la conexión global
        $this->con = $con;
    }

    public function obtenerPedidos($usuario_id) {
        $sql = "SELECT id, fecha, total, estado FROM pedidos WHERE usuario_id = ? ORDER BY fecha DESC";
        $stmt = mysqli_prepare($this->con, $sql);
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
}
?>