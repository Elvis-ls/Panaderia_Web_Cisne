<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/config/conexion.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/model/NotificacionModel.php');

class Controlador {
    private $modelo;

    public function __construct($con) {
        $this->modelo = new Modelo($con);
    }

    public function mostrarNotificaciones() {
        return $this->modelo->obtenerNotificaciones();
    }

    public function manejarAcciones() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['action'])) {
                $imagen = null;
    
                switch ($_POST['action']) {
                    case 'agregar':
                        if (isset($_POST['mensaje'])) {
                            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
                                $imagen = $this->subirImagen($_FILES['imagen']);
                            }
                            $this->modelo->agregarNotificacion($_POST['mensaje'], $imagen);
                        }
                        break;
                    case 'editar':
                        if (isset($_POST['id']) && isset($_POST['mensaje'])) {
                            $imagen_actual = $_POST['imagen_actual'] ?? null;
    
                            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
                                $imagen = $this->subirImagen($_FILES['imagen']);
                            } else {
                                $imagen = $imagen_actual; // Mantener la imagen actual
                            }
    
                            $this->modelo->editarNotificacion($_POST['id'], $_POST['mensaje'], $imagen);
                        }
                        break;
                }
            }
        } elseif (isset($_GET['action']) && $_GET['action'] === 'eliminar' && isset($_GET['id'])) {
            $this->modelo->eliminarNotificacion($_GET['id']);
        }
    }
    
    private function subirImagen($imagen) {
        // Sanitiza el nombre del archivo
        $nombre_archivo = basename($imagen['name']);
        $nombre_archivo = preg_replace('/[^a-zA-Z0-9._-]/', '_', $nombre_archivo); // Reemplaza caracteres no válidos
    
        // Define la ruta de destino
        $carpeta_destino = $_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/public/images/notificaciones/';
        if (!is_dir($carpeta_destino)) {
            mkdir($carpeta_destino, 0777, true); // Crea la carpeta si no existe
        }
        $ruta_imagen = $carpeta_destino . $nombre_archivo;
    
        // Mueve el archivo a la carpeta de destino
        if (move_uploaded_file($imagen['tmp_name'], $ruta_imagen)) {
            return '/Panaderia_Web/public/images/notificaciones/' . $nombre_archivo; // Ruta relativa para la base de datos
        } else {
            echo "Error al subir la imagen.";
            exit;
        }
    }
}
?>