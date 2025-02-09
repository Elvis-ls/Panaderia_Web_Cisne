<?php
require_once(__DIR__ . '/../model/UserModel.php');

class UsuarioController {
    private $usuarioModel;

    public function __construct() {
        $this->usuarioModel = new UsuarioModel();
    }

    public function actualizarPerfil() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['usuario_id'])) {
            header("Location: ../view/user/login.php");
            exit;
        }

        $usuario_id = $_SESSION['usuario_id'];
        $nombre = $_POST['nombre'];
        $correo = $_POST['correo'];
        $telefono = $_POST['telefono'];
        $direccion = $_POST['direccion'];

        $resultado = $this->usuarioModel->actualizarPerfil($usuario_id, $nombre, $correo, $telefono, $direccion);

        if ($resultado) {
            $_SESSION['mensaje'] = "Perfil actualizado correctamente.";
        } else {
            $_SESSION['mensaje'] = "Error al actualizar el perfil.";
        }

        header("Location: ../view/user/perfil.php");
    }
}

// Manejar las solicitudes
$usuarioController = new UsuarioController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuarioController->actualizarPerfil();
}
?>