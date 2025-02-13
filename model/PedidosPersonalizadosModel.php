<?php
require_once __DIR__ . '/../config/conexion.php';
class PedidoPersonalizadoModel {
    private $db;

    public function __construct() {
        // Aquí debes configurar tu conexión a la base de datos
        $this->db = new mysqli('localhost', 'usuario', 'contraseña', 'base_de_datos');
    }

    // Método para crear un pedido personalizado (torta bajo pedido)
    public function crearPedidoPersonalizado($pedido_id, $descripcion, $fecha_entrega, $imagen_referencia) {
        // Escapamos los valores para evitar inyecciones SQL
        $descripcion = $this->db->real_escape_string($descripcion);
        $fecha_entrega = $this->db->real_escape_string($fecha_entrega);
        $imagen_referencia = $imagen_referencia ? $this->db->real_escape_string($imagen_referencia) : null;

        // Inserta el pedido personalizado en la tabla `pedidospersonalizados`
        $sql = "INSERT INTO pedidospersonalizados (pedido_id, descripcion, fecha_entrega, imagen_referencia) 
                VALUES ($pedido_id, '$descripcion', '$fecha_entrega', '$imagen_referencia')";

        return $this->db->query($sql);
    }
}
?>
