<?php
if (isset($_SESSION['id'])) {
    if ($_SESSION['rol_id'] == 1) {
        include 'nav_admin.php';
    } else {
        include 'nav_user.php';
    }
} else {
    include 'nav_guest.php';
}
?>