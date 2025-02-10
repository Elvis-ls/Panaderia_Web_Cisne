<?php
session_start();
require_once __DIR__ . '/../model/UserModel.php';

$usuarioModel = new UsuarioModel();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verificar si el usuario está logueado
    if (!isset($_SESSION['id'])) {
        header("Location: ../view/guest/login.php");
        exit;
    }

    $usuario_id = $_SESSION['id'];
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];

    $resultado = $usuarioModel->actualizarUsuario($usuario_id, $nombre, $correo, $telefono, $direccion);

    if ($resultado) {
        $_SESSION['mensaje'] = 'Perfil actualizado correctamente.';
    } else {
        $_SESSION['mensaje'] = 'Error al actualizar el perfil.';
    }

    header("Location: ../view/user/perfil.php");
    exit;
}
?>