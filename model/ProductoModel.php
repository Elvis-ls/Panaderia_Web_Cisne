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
        $query = "SELECT id, nombre, descripcion, precio, imagen, stock FROM productos WHERE categoria_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $categoria_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Actualiza el stock del producto.
     *
     * @param int $producto_id El ID del producto.
     * @param int $cantidad La cantidad a restar del stock.
     */
    public function actualizarStock($producto_id, $cantidad) {
        $sql = "UPDATE productos SET stock = stock - ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('ii', $cantidad, $producto_id);
        $stmt->execute();
        $stmt->close();
    }

    /**
     * Busca productos por nombre.
     *
     * @param string $query La cadena de búsqueda.
     * @return array
     */
    public function buscarProductos($query) {
        $sql = "SELECT id, nombre, descripcion, precio, imagen, stock FROM productos WHERE nombre LIKE ? LIMIT 10";
        $stmt = $this->db->prepare($sql);
        $likeQuery = '%' . $query . '%';
        $stmt->bind_param('s', $likeQuery);
        $stmt->execute();
        $result = $stmt->get_result();

        $productos = [];
        while ($fila = $result->fetch_assoc()) {
            $productos[] = $fila;
        }

        $stmt->close();
        return $productos;
    }

    /**
     * Obtiene un producto por su ID.
     *
     * @param int $producto_id El ID del producto.
     * @return array
     */
    public function getProductoPorId($producto_id) {
        $sql = "SELECT * FROM productos WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $producto_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $producto = $result->fetch_assoc();
        $stmt->close();
        return $producto;
    }
}
?>