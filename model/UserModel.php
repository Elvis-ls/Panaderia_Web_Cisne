<?php
require_once __DIR__ . '/../config/conexion.php';

class UsuarioModel {
    private $con;

    public function __construct() {
        global $con;
        $this->con = $con;
    }

    public function obtenerUsuario($usuario_id) {
        $sql = "SELECT * FROM usuarios WHERE id = ?";
        $stmt = mysqli_prepare($this->con, $sql);
        mysqli_stmt_bind_param($stmt, "i", $usuario_id);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        $usuario = mysqli_fetch_assoc($resultado);
        mysqli_stmt_close($stmt);
        return $usuario;
    }

    public function actualizarUsuario($usuario_id, $nombre, $correo, $telefono, $direccion) {
        $sql = "UPDATE usuarios SET nombre = ?, correo = ?, telefono = ?, direccion = ? WHERE id = ?";
        $stmt = mysqli_prepare($this->con, $sql);
        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . mysqli_error($this->con));
        }
        mysqli_stmt_bind_param($stmt, "ssssi", $nombre, $correo, $telefono, $direccion, $usuario_id);
        $resultado = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $resultado;
    }
}
?>