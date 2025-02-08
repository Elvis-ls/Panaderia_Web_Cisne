<?php
session_start();
include '../model/UsuarioModel.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = $_POST['correo'];
    $contraseña = $_POST['contraseña'];

    $usuarioModel = new UsuarioModel();

    $usuario = $usuarioModel->login($correo, $contraseña);

    if ($usuario) {
        $_SESSION['id'] = $usuario['id'];
        $_SESSION['nombre'] = $usuario['nombre'];
        $_SESSION['rol_id'] = $usuario['rol_id'];

        // Redirección basada en el rol del usuario
        if ($usuario['rol_id'] == 1) {
            header("Location: ../view/admin/dashboard.php");
        } else {
            header("Location: ../view/user/inicio.php");
        }
        exit();  // Asegúrate de detener la ejecución después de la redirección
    } else {
        echo "Correo o contraseña incorrectos.";
    }
}
?>
