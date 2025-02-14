<?php
// Incluye el modelo que manejará los pedidos
include_once __DIR__ . '/../model/PedidoModel.php';

// Verifica si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoge los datos del formulario
    $usuario_id = 1; // Asegúrate de obtener el usuario_id correcto
    $descripcion = $_POST['descripcion'];
    $fecha_entrega = $_POST['fecha_entrega'];
    $imagen_referencia = $_FILES['imagen_referencia'];

    // Variable para la ruta de la imagen
    $imagen_ruta = null;

    // Verifica si se ha subido una imagen
    if ($imagen_referencia['error'] == 0) {
        // Define el nombre de la imagen y la carpeta de destino
        $carpeta_destino = __DIR__ . '/../img/';
        $imagen_ruta = $carpeta_destino . basename($imagen_referencia['name']);
        
        // Verifica si la carpeta de destino existe, si no, créala
        if (!is_dir($carpeta_destino)) {
            mkdir($carpeta_destino, 0777, true);
        }

        // Mueve el archivo a la carpeta 'img'
        if (move_uploaded_file($imagen_referencia['tmp_name'], $imagen_ruta)) {
            // Guarda la ruta relativa en la base de datos
            $imagen_ruta = 'img/' . basename($imagen_referencia['name']);
        } else {
            // Maneja el error si la imagen no se pudo mover
            echo "Hubo un error al subir la imagen.";
            exit;
        }
    }

    // Llama a la función del modelo para crear el pedido personalizado
    $pedidoModel = new PedidoModel();
    $pedidoCreado = $pedidoModel->crearPedidoPersonalizado($usuario_id, $descripcion, $fecha_entrega, $imagen_ruta);

    // Verifica si el pedido se creó correctamente
    if ($pedidoCreado) {
        // Redirige a una página de éxito o muestra un mensaje
        header('Location: /Panaderia_Web/view/user/pedidos.php');
    } else {
        // Muestra un mensaje de error
        echo "Hubo un error al crear el pedido. Intenta de nuevo.";
    }
}
?>