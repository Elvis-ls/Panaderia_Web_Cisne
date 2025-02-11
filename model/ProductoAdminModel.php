<?php

class ProductoAdminModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getProductosPorCategoria($categoria_id) {
        $query = "SELECT * FROM productos WHERE categoria_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $categoria_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function agregarProducto($nombre, $descripcion, $precio, $categoria_id, $imagen, $stock = 0) {
        $query = "INSERT INTO productos (nombre, descripcion, precio, categoria_id, imagen, stock) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ssdisi", $nombre, $descripcion, $precio, $categoria_id, $imagen, $stock);
        return $stmt->execute();
    }

    public function editarProducto($id, $nombre, $descripcion, $precio, $categoria_id, $imagen, $stock = 0) {
        $query = "UPDATE productos SET nombre = ?, descripcion = ?, precio = ?, categoria_id = ?, imagen = ?, stock = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ssdisii", $nombre, $descripcion, $precio, $categoria_id, $imagen, $stock, $id);
        return $stmt->execute();
    }

    public function eliminarProducto($id) {
        $query = "DELETE FROM productos WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function getProductoPorId($id) {
        $query = "SELECT * FROM productos WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}
?>