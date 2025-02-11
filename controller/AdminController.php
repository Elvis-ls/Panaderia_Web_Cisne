<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/model/UsuarioModel.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/Panaderia_Web/model/PedidoAdminModel.php');


class AdminController {
    private $usuarioModel;
    private $pedidoModel;

    public function __construct($con) {
        $this->usuarioModel = new UsuarioModel($con);
        $this->pedidoModel = new PedidoAdminModel($con);
    }

    public function getUsuarios() {
        return $this->usuarioModel->getUsuarios();
    }

    public function buscarUsuariosPorNombre($nombre) {
        return $this->usuarioModel->buscarUsuariosPorNombre($nombre);
    }

    public function eliminarUsuario($id) {
        return $this->usuarioModel->eliminarUsuario($id);
    }
    public function getPedidos() {
        return $this->pedidoModel->getPedidos();
    }

    /**
     * Elimina un pedido.
     */
    public function eliminarPedido($id) {
        return $this->pedidoModel->eliminarPedido($id);
    }

    /**
     * Actualiza el estado de un pedido.
     */
    public function actualizarEstadoPedido($id, $estado) {
        return $this->pedidoModel->actualizarEstadoPedido($id, $estado);
    }
}
?>