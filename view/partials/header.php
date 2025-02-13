<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['id'])) {
    if ($_SESSION['rol_id'] == 1) {
        include 'header_admin.php';
    } elseif ($_SESSION['rol_id'] == 2) {
        include 'header_user.php';
    }
} else {
    include 'header_guest.php';
}
?>