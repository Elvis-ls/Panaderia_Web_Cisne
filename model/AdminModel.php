<?php
require_once '../../config/conexion.php';

class AdminModel {
    private $db;

    public function __construct() {
        $this->db = Conexion::conectar();
    }

    public function obtenerAdmin($admin_id) {
        $query = "SELECT * FROM usuarios WHERE id = :admin_id AND rol_id = 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':admin_id', $admin_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizarAdmin($admin_id, $nombre, $correo, $telefono, $direccion) {
        $query = "UPDATE usuarios SET nombre = :nombre, correo = :correo, telefono = :telefono, direccion = :direccion WHERE id = :admin_id AND rol_id = 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':admin_id', $admin_id, PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
        $stmt->bindParam(':telefono', $telefono, PDO::PARAM_STR);
        $stmt->bindParam(':direccion', $direccion, PDO::PARAM_STR);
        return $stmt->execute();
    }
}
?>