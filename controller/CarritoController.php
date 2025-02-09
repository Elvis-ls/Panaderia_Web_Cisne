<?php
session_start();
require_once __DIR__ . '/../config/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['accion']) && $_POST['accion'] == 'eliminar') {
        $carrito_id = $_POST['carrito_id'];
        $query = "DELETE FROM carrito WHERE id = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $carrito_id);
        $stmt->execute();
        $stmt->close();

        // Actualizar el total de productos en el carrito después de eliminar
        $usuario_id = $_SESSION['id'];
        $query = "SELECT SUM(cantidad) AS total_productos FROM carrito WHERE usuario_id = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $_SESSION['total_productos'] = $row['total_productos'] ?? 0;

        $_SESSION['mensaje'] = 'Producto eliminado del carrito.';
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }

    $producto_id = $_POST['producto_id'];
    $cantidad = $_POST['cantidad'];
    $usuario_id = $_SESSION['id'];

    // Verificar si el producto ya está en el carrito
    $query = "SELECT * FROM carrito WHERE usuario_id = ? AND producto_id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("ii", $usuario_id, $producto_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Si el producto ya está en el carrito, actualizar la cantidad
        $query = "UPDATE carrito SET cantidad = cantidad + ? WHERE usuario_id = ? AND producto_id = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("iii", $cantidad, $usuario_id, $producto_id);
    } else {
        // Si el producto no está en el carrito, insertarlo
        $query = "INSERT INTO carrito (usuario_id, producto_id, cantidad) VALUES (?, ?, ?)";
        $stmt = $con->prepare($query);
        $stmt->bind_param("iii", $usuario_id, $producto_id, $cantidad);
    }

    if ($stmt->execute()) {
        $_SESSION['mensaje'] = 'Producto añadido al carrito correctamente.';
    } else {
        $_SESSION['mensaje'] = 'Error al añadir el producto al carrito.';
    }

    // Actualizar el total de productos en el carrito
    $query = "SELECT SUM(cantidad) AS total_productos FROM carrito WHERE usuario_id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $_SESSION['total_productos'] = $row['total_productos'];

    $stmt->close();
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
}
?>