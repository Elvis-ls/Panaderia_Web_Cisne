<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/model/ProductoModel.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/model/CategoriaModel.php');

class ProductoController {
    private $productoModel;
    private $categoriaModel;

    public function __construct($db) {
        $this->productoModel = new ProductoModel($db);
        $this->categoriaModel = new CategoriaModel($db);
    }

    /**
     * Maneja las solicitudes y llama a los métodos correspondientes.
     */
    public function handleRequest() {
        if (isset($_GET['action'])) {
            $action = $_GET['action'];
            switch ($action) {
                case 'panaderia':
                    $this->showPanaderia();
                    break;
                case 'pasteleria':
                    $this->showPasteleria();
                    break;
                case 'galleteria':
                    $this->showGalleteria();
                    break;
                case 'lacteos':
                    $this->showLacteos();
                    break;
                case 'inicio':
                    header("Location: /Panaderia_Web/inicio.php");
                    exit;
                default:
                    echo "Página no encontrada";
                    break;
            }
        } else {
            $this->showInicio();
        }
    }
    /**
     * Muestra la vista de inicio.
     */
    private function showInicio() {
        require_once($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/inicio.php');
    }

    /**
     * Muestra la vista de Panadería.
     */
    private function showPanaderia() {
        $categoriaData = $this->categoriaModel->getCategoriaPorNombre('panaderia');
        if ($categoriaData) {
            $productos = $this->productoModel->getProductosPorCategoria($categoriaData['id']);
            if ($productos) {
                require_once($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/view/guest/panaderia.php');
            } else {
                echo "No hay productos disponibles en esta categoría.";
            }
        } else {
            echo "Categoría no encontrada.";
        }
    }

    /**
     * Muestra la vista de Pastelería.
     */
    private function showPasteleria() {
        $categoriaData = $this->categoriaModel->getCategoriaPorNombre('pasteleria');
        if ($categoriaData) {
            $productos = $this->productoModel->getProductosPorCategoria($categoriaData['id']);
            if ($productos) {
                require_once($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/view/guest/pasteleria.php');
            } else {
                echo "No hay productos disponibles en esta categoría.";
            }
        } else {
            echo "Categoría no encontrada.";
        }
    }

    /**
     * Muestra la vista de Galletería.
     */
    private function showGalleteria() {
        $categoriaData = $this->categoriaModel->getCategoriaPorNombre('galleteria');
        if ($categoriaData) {
            $productos = $this->productoModel->getProductosPorCategoria($categoriaData['id']);
            if ($productos) {
                require_once($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/view/guest/galleteria.php');
            } else {
                echo "No hay productos disponibles en esta categoría.";
            }
        } else {
            echo "Categoría no encontrada.";
        }
    }

    /**
     * Muestra la vista de Lácteos.
     */
    private function showLacteos() {
        $categoriaData = $this->categoriaModel->getCategoriaPorNombre('lacteos');
        if ($categoriaData) {
            $productos = $this->productoModel->getProductosPorCategoria($categoriaData['id']);
            if ($productos) {
                require_once($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/view/guest/lacteos.php');
            } else {
                echo "No hay productos disponibles en esta categoría.";
            }
        } else {
            echo "Categoría no encontrada.";
        }
    }
}