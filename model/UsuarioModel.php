<?php
include ($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/config/conexion.php');

class UsuarioModel {
    private $con;

    public function __construct($con) {
        $this->con = $con;
    }

    /**
     * Obtiene todos los usuarios registrados con rol_id = 2.
     */
    public function getUsuarios() {
        $query = "SELECT id, nombre, correo, telefono, direccion  FROM usuarios WHERE rol_id = 2";
        $result = $this->con->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Busca usuarios por nombre con rol_id = 2.
     */
    public function buscarUsuariosPorNombre($nombre) {
        $query = "SELECT id, nombre, correo, telefono, direccion FROM usuarios WHERE nombre LIKE ? AND rol_id = 2";
        $stmt = $this->con->prepare($query);
        $nombre = "%$nombre%";
        $stmt->bind_param('s', $nombre);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function eliminarUsuario($id) {
        // Eliminar registros relacionados en otras tablas
        $tablasRelacionadas = [
            'pedidos' => 'usuario_id',
            'recomendaciones' => 'usuario_id',
            'carrito' => 'usuario_id'
        ];
    
        foreach ($tablasRelacionadas as $tabla => $columna) {
            $query = "DELETE FROM $tabla WHERE $columna = ?";
            $stmt = $this->con->prepare($query);
            $stmt->bind_param('i', $id);
            if (!$stmt->execute()) {
                error_log("Error al eliminar registros en $tabla: " . $stmt->error);
                return false;
            }
        }
    
        // Luego eliminar el usuario
        $queryUsuario = "DELETE FROM usuarios WHERE id = ?";
        $stmtUsuario = $this->con->prepare($queryUsuario);
        $stmtUsuario->bind_param('i', $id);
        if (!$stmtUsuario->execute()) {
            error_log("Error al eliminar usuario: " . $stmtUsuario->error);
            return false;
        }
    
        return true;
    }
    // Función para verificar si el correo ya existe
    public function existeCorreo($correo) {
        $query = "SELECT COUNT(*) FROM usuarios WHERE correo = ?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s', $correo);
        $stmt->execute();
        $result = $stmt->get_result();
        $count = $result->fetch_row()[0];
        return $count > 0; // Si es mayor a 0, significa que el correo ya existe
    }

    public function registrar($nombre, $correo, $contraseña, $telefono, $direccion) {
        $contraseñaCifrada = sha1($contraseña); // Cifrado con SHA

        // Primero, verificar si el correo ya está registrado
        if ($this->existeCorreo($correo)) {
            return false; // El correo ya está registrado
        }

        $query = "INSERT INTO usuarios (nombre, correo, contraseña, telefono, direccion, rol_id) 
                  VALUES (?, ?, ?, ?, ?, 2)"; // rol_id 2 = Usuario
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('sssss', $nombre, $correo, $contraseñaCifrada, $telefono, $direccion);
        return $stmt->execute(); // Registra el nuevo usuario si el correo es único
    }

    public function login($correo, $contraseña) {
        $contraseñaCifrada = sha1($contraseña); // Cifrado con SHA
        $query = "SELECT * FROM usuarios WHERE correo = ? AND contraseña = ?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('ss', $correo, $contraseñaCifrada);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc(); // Devuelve los datos del usuario si existe
    }
}
?>