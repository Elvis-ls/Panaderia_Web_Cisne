<?php
$host = 'localhost'; // Cambia esto según tu configuración
$usuario = 'root';   // Cambia esto según tu configuración
$contraseña = '';    // Cambia esto según tu configuración
$base_de_datos = 'panaderiadb';

$con = mysqli_connect($host, $usuario, $contraseña, $base_de_datos);

if (!$con) {
    die("Conexión fallida: " . mysqli_connect_error());
}
?>
