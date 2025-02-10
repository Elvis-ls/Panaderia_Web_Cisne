<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/model/ProductoAdminModel.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/model/CategoriaModel.php');

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
            if ($productos) {
                require_once($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/view/admin/panaderiaAdmin.php');
            } else {
                echo "No hay productos disponibles en esta categoría.";
            }
        } else {
            echo "Categoría no encontrada.";
        }
    }

    private function showPasteleriaAdmin() {
        $categoriaData = $this->categoriaModel->getCategoriaPorNombre('pasteleria');
        if ($categoriaData) {
            $productos = $this->productoModel->getProductosPorCategoria($categoriaData['id']);
            if ($productos) {
                require_once($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/view/admin/pasteleriaAdmin.php');
            } else {
                echo "No hay productos disponibles en esta categoría.";
            }
        } else {
            echo "Categoría no encontrada.";
        }
    }

    private function showGalleteriaAdmin() {
        $categoriaData = $this->categoriaModel->getCategoriaPorNombre('galleteria');
        if ($categoriaData) {
            $productos = $this->productoModel->getProductosPorCategoria($categoriaData['id']);
            if ($productos) {
                require_once($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/view/admin/galleteriaAdmin.php');
            } else {
                echo "No hay productos disponibles en esta categoría.";
            }
        } else {
            echo "Categoría no encontrada.";
        }
    }

    private function showLacteosAdmin() {
        $categoriaData = $this->categoriaModel->getCategoriaPorNombre('lacteos');
        if ($categoriaData) {
            $productos = $this->productoModel->getProductosPorCategoria($categoriaData['id']);
            if ($productos) {
                require_once($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/view/admin/lacteosAdmin.php');
            } else {
                echo "No hay productos disponibles en esta categoría.";
            }
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
            $imagen = $_POST['imagen']; // Usar el enlace de la imagen en lugar de subir un archivo

            $this->productoModel->agregarProducto($nombre, $descripcion, $precio, $categoriaId, $imagen);
            header("Location: /Panaderia_Web/view/admin/galleteriaAdmin.php");
            exit;
        }
    }

    private function editarProducto() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $precio = $_POST['precio'];
            $categoriaId = $_POST['categoria_id'];
            $imagen = $_POST['imagen']; // Usar el enlace de la imagen en lugar de subir un archivo

            $this->productoModel->editarProducto($id, $nombre, $descripcion, $precio, $categoriaId, $imagen);
            header("Location: /Panaderia_Web/view/admin/galleteriaAdmin.php");
            exit;
        }
    }

    private function eliminarProducto() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $this->productoModel->eliminarProducto($id);
            header("Location: /Panaderia_Web/view/admin/galleteriaAdmin.php");
            exit;
        }
    }
}
?>