<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/model/ProductoModel.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/model/CategoriaModel.php');
session_start(); // Iniciar sesión para acceder al rol del usuario

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
    if (session_status() === PHP_SESSION_NONE) {
        session_start(); // Solo iniciar la sesión si no está activa
    }

    if (isset($_GET['action'])) {
        $action = $_GET['action'];
        switch ($action) {
            case 'panaderia':
            case 'pasteleria':
            case 'galleteria':
            case 'lacteos':
                $this->showCategoria($action);
                break;
            case 'inicio':
                $this->showInicio();
                break;
            default:
                echo "Página no encontrada";
                break;
        }
    } else {
        $this->showInicio();
    }
}

    
    /**
     * Determina qué vista de inicio mostrar según el rol del usuario.
     */
    private function showInicio() {
        if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'usuario') {
            header("Location: /Panaderia_Web/view/user/inicio.php");
        } else {
            header("Location: /Panaderia_Web/inicio.php");
        }
        exit;
    }
    


    /**
     * Muestra la vista de una categoría según el rol del usuario.
     */
    private function showCategoria($categoria) {
        $categoriaData = $this->categoriaModel->getCategoriaPorNombre($categoria);
        if ($categoriaData) {
            $productos = $this->productoModel->getProductosPorCategoria($categoriaData['id']);
            if ($productos) {
                // Determinar vista según el rol
                $vistaPath = (isset($_SESSION['rol']) && $_SESSION['rol'] === 'usuario') ?
                    "/Panaderia_Web/view/user/$categoria.php" :
                    "/Panaderia_Web/view/guest/$categoria.php";

                require_once($_SERVER['DOCUMENT_ROOT'] . $vistaPath);
            } else {
                echo "No hay productos disponibles en esta categoría.";
            }
        } else {
            echo "Categoría no encontrada.";
        }
    }
}