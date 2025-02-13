<?php
class Modelo {
    private $con;

    public function __construct($con) {
        $this->con = $con;
    }

    public function obtenerNotificaciones() {
        $query = "SELECT id, mensaje, fecha_creacion, imagen FROM notificaciones WHERE fecha_eliminacion IS NULL";
        $result = mysqli_query($this->con, $query);

        if ($result) {
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        } else {
            return [];
        }
    }

    public function agregarNotificacion($mensaje, $imagen = null) {
        $query = "INSERT INTO notificaciones (mensaje, imagen) VALUES (?, ?)";
        $stmt = mysqli_prepare($this->con, $query);
        mysqli_stmt_bind_param($stmt, 'ss', $mensaje, $imagen);
        return mysqli_stmt_execute($stmt);
    }

    public function editarNotificacion($id, $mensaje, $imagen = null) {
        $query = "UPDATE notificaciones SET mensaje = ?, imagen = ? WHERE id = ?";
        $stmt = mysqli_prepare($this->con, $query);
        mysqli_stmt_bind_param($stmt, 'ssi', $mensaje, $imagen, $id);
        return mysqli_stmt_execute($stmt);
    }

    public function eliminarNotificacion($id) {
        $query = "UPDATE notificaciones SET fecha_eliminacion = CURRENT_TIMESTAMP WHERE id = ?";
        $stmt = mysqli_prepare($this->con, $query);
        mysqli_stmt_bind_param($stmt, 'i', $id);
        return mysqli_stmt_execute($stmt);
    }
}
?>