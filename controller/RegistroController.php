<?php
session_start();
require_once '../config/conexion.php';
require_once '../model/UsuarioModel.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $correo = $_POST['email'];
    $contraseña = $_POST['password'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];

    $usuarioModel = new UsuarioModel();

    // Verificar si el correo ya está registrado
    if ($usuarioModel->existeCorreo($correo)) {
        echo json_encode(['success' => false, 'message' => 'El correo electrónico ya está registrado.']);
        exit();
    }

    // Registrar el usuario
    $registroExitoso = $usuarioModel->registrar($nombre, $correo, $contraseña, $telefono, $direccion);

    if ($registroExitoso) {
        echo json_encode(['success' => true, 'message' => 'Registro exitoso. Ahora puedes iniciar sesión.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al registrar el usuario.']);
    }
}
?>