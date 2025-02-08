<?php

class ProductoModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * Obtiene los productos por categoría.
     *
     * @param int $categoria_id El ID de la categoría.
     * @return array
     */
    public function getProductosPorCategoria($categoria_id) {
        $query = "SELECT * FROM productos WHERE categoria_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $categoria_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}