<?php
require_once __DIR__ . '/../config/conexion.php';

function obtenerProductosCarrito($usuario_id) {
    global $con;
    $query = "SELECT c.id as carrito_id, c.cantidad, p.nombre, p.precio, p.imagen FROM carrito c JOIN productos p ON c.producto_id = p.id WHERE c.usuario_id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $productos_carrito = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $productos_carrito;
}
?>