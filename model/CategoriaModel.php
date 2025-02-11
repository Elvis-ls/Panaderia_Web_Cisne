<?php

class CategoriaModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * Obtiene una categoría por su nombre.
     *
     * @param string $nombre El nombre de la categoría.
     * @return array|null
     */
    public function getCategoriaPorNombre($nombre) {
        $query = "SELECT * FROM categorias WHERE nombre = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $nombre);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    /**
     * Obtiene todas las categorías.
     *
     * @return array
     */
    public function getCategorias() {
        $query = "SELECT * FROM categorias";
        $result = $this->db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>