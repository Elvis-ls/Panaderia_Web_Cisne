<?php
session_start(); // Iniciar la sesión al inicio del script
include '../model/UsuarioModel.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $correo = $_POST['email'];
    $contraseña = $_POST['password'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];

    $usuarioModel = new UsuarioModel();

    // Verificar si el correo ya está registrado
    if ($usuarioModel->existeCorreo($correo)) {
        // Si el correo ya existe, devolver un mensaje de error
        echo json_encode(['success' => false, 'message' => 'El correo electrónico ya está registrado.']);
        exit();
    } else {
        // Si el correo no está registrado, proceder con el registro
        $registroExitoso = $usuarioModel->registrar($nombre, $correo, $contraseña, $telefono, $direccion);

        // Devolver un mensaje de éxito o error
        if ($registroExitoso) {
            echo json_encode(['success' => true, 'message' => 'Registro exitoso. Ahora puedes iniciar sesión.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al registrar el usuario.']);
        }
        exit();
    }
}
?>

