<?php
// Incluye el modelo que manejará los pedidos
include_once "../model/PedidoModel.php";

// Verifica si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoge los datos del formulario
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $cantidad = $_POST['cantidad'];
    $fecha_entrega = $_POST['fecha_entrega'];
    $imagen_referencia = $_FILES['imagen_referencia'];

    // Variable para la ruta de la imagen
    $imagen_ruta = null;

    // Verifica si se ha subido una imagen
    if ($imagen_referencia['error'] == 0) {
        // Define el nombre de la imagen y la carpeta de destino
        $carpeta_destino = 'uploads/';
        $imagen_ruta = $carpeta_destino . basename($imagen_referencia['name']);
        
        // Mueve el archivo a la carpeta 'uploads'
        move_uploaded_file($imagen_referencia['tmp_name'], $imagen_ruta);
    }

    // Llama a la función del modelo para crear el pedido
    $pedido = new PedidoModel();
    $pedidoCreado = $pedido->crearPedidoPersonalizado($nombre, $descripcion, $cantidad, $fecha_entrega, $imagen_ruta);

    // Verifica si el pedido se creó correctamente
    if ($pedidoCreado) {
        // Redirige a una página de éxito o muestra un mensaje
        header('Location: /Panaderia_Web/view/pedido_exitoso.php');
    } else {
        // Muestra un mensaje de error
        echo "Hubo un error al crear el pedido. Intenta de nuevo.";
    }
}
?>
