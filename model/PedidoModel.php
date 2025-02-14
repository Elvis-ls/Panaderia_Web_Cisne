<?php
require_once __DIR__ . '/../config/conexion.php';

class PedidoModel {
    private $con;

    public function __construct() {
        global $con;
        $this->con = $con;
    }

    public function obtenerPedidos($usuario_id) {
        $sql = "SELECT p.id, p.fecha_pedido, p.total, p.estado 
                FROM pedidos p 
                WHERE p.usuario_id = ? 
                AND NOT EXISTS (SELECT 1 FROM pedidospersonalizados pp WHERE pp.pedido_id = p.id)
                ORDER BY p.fecha_pedido DESC";
        $stmt = mysqli_prepare($this->con, $sql);
        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . mysqli_error($this->con));
        }
        mysqli_stmt_bind_param($stmt, "i", $usuario_id);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);

        $pedidos = [];
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $pedidos[] = $fila;
        }

        mysqli_stmt_close($stmt);
        return $pedidos;
    }

    public function obtenerPedidoPorId($pedido_id) {
        $sql = "SELECT p.id, p.fecha_pedido, p.total, p.estado, u.nombre AS cliente 
                FROM pedidos p 
                JOIN usuarios u ON p.usuario_id = u.id 
                WHERE p.id = ?";
        $stmt = mysqli_prepare($this->con, $sql);
        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . mysqli_error($this->con));
        }
        mysqli_stmt_bind_param($stmt, "i", $pedido_id);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        $pedido = mysqli_fetch_assoc($resultado);
        mysqli_stmt_close($stmt);
        return $pedido;
    }

    public function obtenerDetallesPedido($pedido_id) {
        $sql = "SELECT dp.id, dp.cantidad, dp.precio_unitario, p.nombre 
                FROM detallespedidos dp 
                JOIN productos p ON dp.producto_id = p.id 
                WHERE dp.pedido_id = ?";
        $stmt = mysqli_prepare($this->con, $sql);
        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . mysqli_error($this->con));
        }
        mysqli_stmt_bind_param($stmt, "i", $pedido_id);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);

        $detalles = [];
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $detalles[] = $fila;
        }

        mysqli_stmt_close($stmt);
        return $detalles;
    }

    public function crearPedido($usuario_id) {
        // Calcular el total del pedido
        $sql = "SELECT SUM(p.precio * c.cantidad) AS total 
                FROM carrito c 
                JOIN productos p ON c.producto_id = p.id 
                WHERE c.usuario_id = ?";
        $stmt = mysqli_prepare($this->con, $sql);
        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . mysqli_error($this->con));
        }
        mysqli_stmt_bind_param($stmt, "i", $usuario_id);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($resultado);
        $total = $row['total'];
        mysqli_stmt_close($stmt);

        // Insertar el pedido en la tabla pedidos
        $sql = "INSERT INTO pedidos (usuario_id, fecha_pedido, total) VALUES (?, NOW(), ?)";
        $stmt = mysqli_prepare($this->con, $sql);
        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . mysqli_error($this->con));
        }
        mysqli_stmt_bind_param($stmt, "id", $usuario_id, $total);
        mysqli_stmt_execute($stmt);
        $pedido_id = mysqli_stmt_insert_id($stmt);
        mysqli_stmt_close($stmt);
        return $pedido_id;
    }

    public function obtenerProductosCarrito($usuario_id) {
        $sql = "SELECT producto_id, cantidad FROM carrito WHERE usuario_id = ?";
        $stmt = mysqli_prepare($this->con, $sql);
        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . mysqli_error($this->con));
        }
        mysqli_stmt_bind_param($stmt, "i", $usuario_id);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);

        $productos_carrito = [];
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $productos_carrito[] = $fila;
        }

        mysqli_stmt_close($stmt);
        return $productos_carrito;
    }

    public function agregarProductoAPedido($pedido_id, $producto_id, $cantidad) {
        $sql = "INSERT INTO detallespedidos (pedido_id, producto_id, cantidad, precio_unitario) 
                SELECT ?, ?, ?, precio FROM productos WHERE id = ?";
        $stmt = mysqli_prepare($this->con, $sql);
        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . mysqli_error($this->con));
        }
        mysqli_stmt_bind_param($stmt, "iiii", $pedido_id, $producto_id, $cantidad, $producto_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    public function vaciarCarrito($usuario_id) {
        $sql = "DELETE FROM carrito WHERE usuario_id = ?";
        $stmt = mysqli_prepare($this->con, $sql);
        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . mysqli_error($this->con));
        }
        mysqli_stmt_bind_param($stmt, "i", $usuario_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    // Método para crear un pedido personalizado
    public function crearPedidoPersonalizado($usuario_id, $descripcion, $fecha_entrega, $imagen_path) {
        // Crear el pedido en la tabla pedidos
        $sql = "INSERT INTO pedidos (usuario_id, total, estado) VALUES (?, NULL, 'pendiente')";
        $stmt = mysqli_prepare($this->con, $sql);
        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . mysqli_error($this->con));
        }
        mysqli_stmt_bind_param($stmt, "i", $usuario_id);
        mysqli_stmt_execute($stmt);
        $pedido_id = mysqli_stmt_insert_id($stmt);
        mysqli_stmt_close($stmt);

        // Crear el pedido personalizado en la tabla pedidospersonalizados
        $sql = "INSERT INTO pedidospersonalizados (pedido_id, descripcion, fecha_entrega, imagen_path) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($this->con, $sql);
        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . mysqli_error($this->con));
        }
        mysqli_stmt_bind_param($stmt, "isss", $pedido_id, $descripcion, $fecha_entrega, $imagen_path);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        return $pedido_id;
    }

    public function obtenerPedidosPersonalizados($usuario_id) {
        $sql = "SELECT pp.id, pp.descripcion, pp.fecha_entrega, pp.imagen_path, p.estado, p.total 
                FROM pedidospersonalizados pp 
                JOIN pedidos p ON pp.pedido_id = p.id 
                WHERE p.usuario_id = ? 
                ORDER BY pp.fecha_entrega DESC";
        $stmt = mysqli_prepare($this->con, $sql);
        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . mysqli_error($this->con));
        }
        mysqli_stmt_bind_param($stmt, "i", $usuario_id);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);

        $pedidos_personalizados = [];
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $pedidos_personalizados[] = $fila;
        }

        mysqli_stmt_close($stmt);
        return $pedidos_personalizados;
    }
    
    public function obtenerPedidoPersonalizadoPorId($pedido_personalizado_id) {
        $sql = "SELECT pp.id, pp.descripcion, pp.fecha_entrega, pp.pedido_id, pp.imagen_path, p.estado, p.total 
                FROM pedidospersonalizados pp 
                JOIN pedidos p ON pp.pedido_id = p.id 
                WHERE pp.id = ?";
        $stmt = mysqli_prepare($this->con, $sql);
        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . mysqli_error($this->con));
        }
        mysqli_stmt_bind_param($stmt, "i", $pedido_personalizado_id);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        $pedido_personalizado = mysqli_fetch_assoc($resultado);
        mysqli_stmt_close($stmt);
        return $pedido_personalizado;
    }

}
?>