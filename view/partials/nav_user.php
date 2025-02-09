<nav>
    <div class="nav-container">
        <a href="inicio.php" class="<?php echo ($pagina == 'inicio_user') ? 'active' : ''; ?>">
            <i class="fas fa-home"></i> Inicio
        </a>
        <a href="panaderia_user.php" class="<?php echo ($pagina == 'panaderia_user') ? 'active' : ''; ?>">
            <i class="fas fa-bread-slice"></i> Panadería
        </a>
        <a href="pasteleria_user.php" class="<?php echo ($pagina == 'pasteleria_user') ? 'active' : ''; ?>">
            <i class="fas fa-cake"></i> Pastelería
        </a>
        <a href="/Panaderia_Web/inicio.php?action=galleteria" class="<?php echo ($pagina == 'galleteria') ? 'active' : ''; ?>">
            <i class="fas fa-cookie"></i> Galletería
        </a>
        <a href="/Panaderia_Web/inicio.php?action=lacteos" class="<?php echo ($pagina == 'lacteos') ? 'active' : ''; ?>">
            <i class="fas fa-coffee"></i> Lácteos
        </a>
        <a href="/Panaderia_Web/view/user/ayuda.php" class="<?php echo ($pagina == 'ayuda') ? 'active' : ''; ?>">
            <i class="fas fa-info-circle"></i> Ayuda
        </a>
        <a href="/Panaderia_Web/view/user/perfil.php" class="<?php echo ($pagina == 'perfil') ? 'active' : ''; ?>">
            <i class="fas fa-user"></i> Mi perfil
        </a>
        <a href="/Panaderia_Web/view/user/pedidos.php" class="<?php echo ($pagina == 'pedidos') ? 'active' : ''; ?>">
            <i class="fas fa-box"></i> Mis pedidos
        </a>
        <a href="/Panaderia_Web/view/user/notificaciones.php" class="<?php echo ($pagina == 'notificaciones') ? 'active' : ''; ?>">
            <i class="fas fa-bell"></i> Notificaciones
        </a>
        <a href="/Panaderia_Web/controller/LogoutController.php">
            <i class="fas fa-sign-out-alt"></i> Cerrar sesión
        </a>
    </div>
</nav>