<nav>
    <div class="nav-container">
        <a href="/Panaderia_Web/inicio.php?action=inicio" class="<?php echo ($pagina == 'inicio') ? 'active' : ''; ?>">
            <i class="fas fa-home"></i> Inicio
        </a>
        <a href="/Panaderia_Web/inicio.php?action=panaderia" class="<?php echo ($pagina == 'panaderia') ? 'active' : ''; ?>">
            <i class="fas fa-bread-slice"></i> Panadería
        </a>
        <a href="/Panaderia_Web/inicio.php?action=pasteleria" class="<?php echo ($pagina == 'pasteleria') ? 'active' : ''; ?>">
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
        <a href="perfil.php" class="<?php echo ($pagina == 'perfil') ? 'active' : ''; ?>">
            <i class="fas fa-user"></i> Mi perfil
        </a>
        <a href="pedidos.php" class="<?php echo ($pagina == 'pedidos') ? 'active' : ''; ?>">
            <i class="fas fa-box"></i> Mis pedidos
        </a>
        <a href="notificaciones.php" class="<?php echo ($pagina == 'notificaciones') ? 'active' : ''; ?>">
            <i class="fas fa-bell"></i> Notificaciones
        </a>
        <a href="../../controller/LogoutController.php">
            <i class="fas fa-sign-out-alt"></i> Cerrar sesión
        </a>
    </div>
</nav>