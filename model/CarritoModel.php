<?php
class CarritoModel {
    private $con;

    public function __construct($con) {
        $this->con = $con;
    }

    public function eliminarProducto($carrito_id) {
        $query = "DELETE FROM carrito WHERE id = ?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param("i", $carrito_id);
        $stmt->execute();
        $stmt->close();
    }

    public function actualizarTotalProductos($usuario_id) {
        $query = "SELECT SUM(cantidad) AS total_productos FROM carrito WHERE usuario_id = ?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        return $row['total_productos'] ?? 0;
    }

    public function obtenerProductoEnCarrito($usuario_id, $producto_id) {
        $query = "SELECT * FROM carrito WHERE usuario_id = ? AND producto_id = ?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param("ii", $usuario_id, $producto_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result;
    }

    public function actualizarCantidadProducto($cantidad, $usuario_id, $producto_id) {
        $query = "UPDATE carrito SET cantidad = ? WHERE usuario_id = ? AND producto_id = ?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param("iii", $cantidad, $usuario_id, $producto_id);
        $stmt->execute();
        $stmt->close();
    }

    public function insertarProducto($usuario_id, $producto_id, $cantidad) {
        $query = "INSERT INTO carrito (usuario_id, producto_id, cantidad) VALUES (?, ?, ?)";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param("iii", $usuario_id, $producto_id, $cantidad);
        $stmt->execute();
        $stmt->close();
    }

    public function obtenerProductosEnCarrito($usuario_id) {
        $query = "SELECT c.*, p.precio AS precio_unitario FROM carrito c JOIN productos p ON c.producto_id = p.id WHERE c.usuario_id = ?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $productos = [];
        while ($row = $result->fetch_assoc()) {
            $productos[] = $row;
        }
        $stmt->close();
        return $productos;
    }

    public function actualizarStockProducto($producto_id, $cantidad) {
        $query = "UPDATE productos SET stock = stock - ? WHERE id = ?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param("ii", $cantidad, $producto_id);
        $stmt->execute();
        $stmt->close();
    }

    public function limpiarCarrito($usuario_id) {
        $query = "DELETE FROM carrito WHERE usuario_id = ?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
        $stmt->close();
    }

    public function obtenerProductoPorCarritoId($carrito_id) {
        $query = "SELECT producto_id FROM carrito WHERE id = ?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param("i", $carrito_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $producto = $result->fetch_assoc();
        $stmt->close();
        return $producto;
    }
}
?>