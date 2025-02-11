<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/config/conexion.php'); // Incluir la conexión
require_once($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/model/UsuarioModel.php'); // Incluir el modelo

$response = array('success' => false, 'message' => '');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = $_POST['correo'];
    $contraseña = $_POST['contraseña'];

    // Depuración: Verificar los datos de entrada
    error_log("Correo: $correo");
    error_log("Contraseña: $contraseña");

    // Instanciar el modelo y pasar la conexión
    $usuarioModel = new UsuarioModel($con);

    // Llamar al método login
    $usuario = $usuarioModel->login($correo, $contraseña);

    // Depuración: Verificar la respuesta del método login
    error_log("Usuario: " . print_r($usuario, true));

    if ($usuario) {
        $_SESSION['id'] = $usuario['id'];
        $_SESSION['nombre'] = $usuario['nombre'];
        $_SESSION['rol_id'] = $usuario['rol_id'];

        $response['success'] = true;
        $response['message'] = 'Inicio de sesión exitoso.';

        // Redirección basada en el rol del usuario
        if ($usuario['rol_id'] == 1) {
            $response['redirect'] = 'http://localhost/Panaderia_Web/view/admin/dashboard.php';
        } else {
            $response['redirect'] = 'http://localhost/Panaderia_Web/view/user/inicio.php';
        }
    } else {
        $response['message'] = 'Correo o contraseña incorrectos.';
    }
}

echo json_encode($response);
?>