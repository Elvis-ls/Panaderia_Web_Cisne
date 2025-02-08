<?php
include '../config/conexion.php';

class UsuarioModel {

    // Función para verificar si el correo ya existe
    public function existeCorreo($correo) {
        $query = "SELECT COUNT(*) FROM usuarios WHERE correo = '$correo'"; // Cuenta los correos con el mismo valor
        $result = mysqli_query($GLOBALS['con'], $query);
        $count = mysqli_fetch_row($result)[0]; // Obtenemos el número de filas
        return $count > 0; // Si es mayor a 0, significa que el correo ya existe
    }

    public function registrar($nombre, $correo, $contraseña, $telefono, $direccion) {
        $contraseñaCifrada = sha1($contraseña); // Cifrado con SHA

        // Primero, verificar si el correo ya está registrado
        if ($this->existeCorreo($correo)) {
            return false; // El correo ya está registrado
        }

        $query = "INSERT INTO usuarios (nombre, correo, contraseña, telefono, direccion, rol_id) 
                  VALUES ('$nombre', '$correo', '$contraseñaCifrada', '$telefono', '$direccion', 2)"; // rol_id 2 = Usuario

        return mysqli_query($GLOBALS['con'], $query); // Registra el nuevo usuario si el correo es único
    }

    public function login($correo, $contraseña) {
        $contraseñaCifrada = sha1($contraseña); // Cifrado con SHA
        $query = "SELECT * FROM usuarios WHERE correo = '$correo' AND contraseña = '$contraseñaCifrada'";
        $result = mysqli_query($GLOBALS['con'], $query);
        return mysqli_fetch_assoc($result); // Devuelve los datos del usuario si existe
    }
}
?>
