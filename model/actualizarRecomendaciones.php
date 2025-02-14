<?php
require_once __DIR__ . '/../config/conexion.php';

function actualizarRecomendacionesParaTodosLosUsuarios() {
    global $con;

    // Obtener todos los usuarios que han realizado pedidos
    $queryUsuarios = "SELECT DISTINCT usuario_id FROM pedidos";
    $resultUsuarios = $con->query($queryUsuarios);

    while ($rowUsuario = $resultUsuarios->fetch_assoc()) {
        $usuario_id = $rowUsuario['usuario_id'];

        // Eliminar recomendaciones existentes para el usuario
        $queryEliminarRecomendaciones = "DELETE FROM recomendados WHERE usuario_id = ?";
        $stmtEliminarRecomendaciones = $con->prepare($queryEliminarRecomendaciones);
        $stmtEliminarRecomendaciones->bind_param('i', $usuario_id);
        $stmtEliminarRecomendaciones->execute();

        // Obtener productos que están en dos o más pedidos del usuario
        $queryProductos = "
            SELECT dp.producto_id, p.nombre, p.precio, p.imagen, COUNT(dp.producto_id) as num_pedidos
            FROM detallespedidos dp
            JOIN productos p ON dp.producto_id = p.id
            JOIN pedidos pe ON dp.pedido_id = pe.id
            WHERE pe.usuario_id = ?
            GROUP BY dp.producto_id
            HAVING num_pedidos >= 2
        ";

        $stmtProductos = $con->prepare($queryProductos);
        $stmtProductos->bind_param('i', $usuario_id);
        $stmtProductos->execute();
        $resultProductos = $stmtProductos->get_result();

        while ($rowProducto = $resultProductos->fetch_assoc()) {
            $producto_id = $rowProducto['producto_id'];
            $num_pedidos = $rowProducto['num_pedidos'];

            // Insertar en la tabla de recomendaciones
            $queryRecomendacion = "
                INSERT INTO recomendados (usuario_id, producto_id, num_pedidos)
                VALUES (?, ?, ?)
                ON DUPLICATE KEY UPDATE num_pedidos = VALUES(num_pedidos)
            ";

            $stmtRecomendacion = $con->prepare($queryRecomendacion);
            $stmtRecomendacion->bind_param('iii', $usuario_id, $producto_id, $num_pedidos);
            $stmtRecomendacion->execute();
        }
    }
}

actualizarRecomendacionesParaTodosLosUsuarios();
?>