<?php
require_once __DIR__ . '/../config/conexion.php';

class PedidoPersonalizadoModel {
    private $db;

    public function __construct() {
        // Aquí debes configurar tu conexión a la base de datos
        $this->db = new mysqli('localhost', 'root', '', 'panaderiadb');

        // Verifica la conexión
        if ($this->db->connect_error) {
            die("Error de conexión: " . $this->db->connect_error);
        }
    }

    // Método para crear un pedido personalizado (torta bajo pedido)
    public function crearPedidoPersonalizado($pedido_id, $descripcion, $fecha_entrega, $imagen_ruta) {
        // Escapamos los valores para evitar inyecciones SQL
        $pedido_id = $this->db->real_escape_string($pedido_id);
        $descripcion = $this->db->real_escape_string($descripcion);
        $fecha_entrega = $this->db->real_escape_string($fecha_entrega);
        $imagen_ruta = $imagen_ruta ? $this->db->real_escape_string($imagen_ruta) : null;

        // Inserta el pedido personalizado en la tabla `pedidospersonalizados`
        $sql = "INSERT INTO pedidospersonalizados (pedido_id, descripcion, fecha_entrega, imagen_path) 
                VALUES ('$pedido_id', '$descripcion', '$fecha_entrega', '$imagen_ruta')";

        return $this->db->query($sql);
    }
}
?>