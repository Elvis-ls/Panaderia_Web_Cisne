<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/model/ProductoAdminModel.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/model/CategoriaModel.php');

// Configuración de la base de datos
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'panaderiadb';

// Crear conexión
$db = new mysqli($host, $user, $password, $database);

// Verificar conexión
if ($db->connect_error) {
    die("Conexión fallida: " . $db->connect_error);
}

// Crear instancia del controlador y pasar la conexión a la base de datos
$controller = new ProductoAdminController($db);
$controller->handleRequest();
class ProductoAdminController {
    private $productoModel;
    private $categoriaModel;

    public function __construct($db) {
        $this->productoModel = new ProductoAdminModel($db);
        $this->categoriaModel = new CategoriaModel($db);
    }

    public function handleRequest() {
        if (isset($_GET['action'])) {
            $action = $_GET['action'];
            switch ($action) {
                case 'panaderia':
                    $this->showPanaderiaAdmin();
                    break;
                case 'pasteleria':
                    $this->showPasteleriaAdmin();
                    break;
                case 'galleteria':
                    $this->showGalleteriaAdmin();
                    break;
                case 'lacteos':
                    $this->showLacteosAdmin();
                    break;
                case 'agregar':
                    $this->agregarProducto();
                    break;
                case 'editar':
                    $this->editarProducto();
                    break;
                case 'eliminar':
                    $this->eliminarProducto();
                    break;
                case 'inicio':
                    header("Location: /Panaderia_Web/view/admin/dashboard.php");
                    break;
                default:
                    echo "Página no encontrada";
                    break;
            }
        } else {
            $this->showInicioAdmin();
        }
    }

    private function showInicioAdmin() {
        require_once($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/view/admin/dashboard.php');
    }

    private function showPanaderiaAdmin() {
        $categoriaData = $this->categoriaModel->getCategoriaPorNombre('panaderia');
        if ($categoriaData) {
            $productos = $this->productoModel->getProductosPorCategoria($categoriaData['id']);
            $categorias = $this->categoriaModel->getCategorias();
            require_once($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/view/admin/panaderiaAdmin.php');
        } else {
            echo "Categoría no encontrada.";
        }
    }

    private function showPasteleriaAdmin() {
        $categoriaData = $this->categoriaModel->getCategoriaPorNombre('pasteleria');
        if ($categoriaData) {
            $productos = $this->productoModel->getProductosPorCategoria($categoriaData['id']);
            $categorias = $this->categoriaModel->getCategorias();
            require_once($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/view/admin/pasteleriaAdmin.php');
        } else {
            echo "Categoría no encontrada.";
        }
    }

    private function showGalleteriaAdmin() {
        $categoriaData = $this->categoriaModel->getCategoriaPorNombre('galleteria');
        if ($categoriaData) {
            $productos = $this->productoModel->getProductosPorCategoria($categoriaData['id']);
            $categorias = $this->categoriaModel->getCategorias();
            require_once($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/view/admin/galleteriaAdmin.php');
        } else {
            echo "Categoría no encontrada.";
        }
    }

    private function showLacteosAdmin() {
        $categoriaData = $this->categoriaModel->getCategoriaPorNombre('lacteos');
        if ($categoriaData) {
            $productos = $this->productoModel->getProductosPorCategoria($categoriaData['id']);
            $categorias = $this->categoriaModel->getCategorias();
            require_once($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/view/admin/lacteosAdmin.php');
        } else {
            echo "Categoría no encontrada.";
        }
    }

    private function agregarProducto() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $precio = $_POST['precio'];
            $categoriaId = $_POST['categoria_id'];
            $stock = $_POST['stock'];

            // Manejar la subida de la imagen
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/Panaderia_Web/public/images/";
                $imagen = basename($_FILES['imagen']['name']);
                $target_file = $target_dir . $imagen;
                move_uploaded_file($_FILES['imagen']['tmp_name'], $target_file);
            } else {
                $imagen = null;
            }

            $resultado = $this->productoModel->agregarProducto($nombre, $descripcion, $precio, $categoriaId, $imagen, $stock);

            header('Content-Type: application/json');
            if ($resultado) {
                echo json_encode(['success' => true, 'message' => 'Producto agregado con éxito']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al agregar el producto']);
            }
            exit;
        }
    }

    private function editarProducto() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $precio = $_POST['precio'];
            $stock = $_POST['stock'];
            $categoria_id = $_POST['categoria_id'];
            $imagen_actual = $_POST['imagen_actual'];

            // Manejar la subida de la nueva imagen si se proporciona
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/Panaderia_Web/public/images/";
                $imagen = basename($_FILES['imagen']['name']);
                $target_file = $target_dir . $imagen;

                // Mover la imagen subida a la carpeta de destino
                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $target_file)) {
                    // Eliminar la imagen actual si es diferente de la nueva
                    if ($imagen_actual && $imagen_actual !== $imagen) {
                        unlink($target_dir . $imagen_actual);
                    }
                } else {
                    // Manejar error al mover la imagen
                    $imagen = $imagen_actual;
                }
            } else {
                // Si no se subió una nueva imagen, mantener la imagen actual
                $imagen = $imagen_actual;
            }

            $resultado = $this->productoModel->editarProducto($id, $nombre, $descripcion, $precio, $categoria_id, $imagen, $stock);

            header('Content-Type: application/json');
            if ($resultado) {
                echo json_encode(['success' => true, 'message' => 'Producto modificado con éxito']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al modificar el producto']);
            }
            exit;
        }
    }

    private function eliminarProducto() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];

            $resultado = $this->productoModel->eliminarProducto($id);

            header('Content-Type: application/json');
            if ($resultado) {
                echo json_encode(['success' => true, 'message' => 'Producto eliminado con éxito']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al eliminar el producto']);
            }
            exit;
        }
    }
}

?>