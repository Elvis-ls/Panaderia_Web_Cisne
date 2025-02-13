<nav>
    <div class="nav-container">
        <a href="/Panaderia_Web/view/admin/dashboard.php?action=inicio" class="<?php echo ($pagina == 'inicio') ? 'active' : ''; ?>">
            <i class="fas fa-home"></i> Inicio
        </a>
        <div class="dropdown">
            <a href="#" class="dropdown-toggle <?php echo ($pagina == 'gestproductos') ? 'active' : ''; ?>" id="reportesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-box-open"></i> Gestionar Productos
            </a>
            <ul class="dropdown-menu" aria-labelledby="reportesDropdown">
                <li><a class="dropdown-item" href="/Panaderia_Web/view/admin/dashboard.php?action=panaderia">Panadería</a></li>
                <li><a class="dropdown-item" href="/Panaderia_Web/view/admin/dashboard.php?action=pasteleria">Pastelería</a></li>
                <li><a class="dropdown-item" href="/Panaderia_Web/view/admin/dashboard.php?action=galleteria">Galletería</a></li>
                <li><a class="dropdown-item" href="/Panaderia_Web/view/admin/dashboard.php?action=lacteos">Lácteos</a></li>
            </ul>
        </div>
        <a href="/Panaderia_Web/view/admin/gestionar_pedidos.php" class="<?php echo ($pagina == 'gestPedidos') ? 'active' : ''; ?>">
            <i class="fas fa-box"></i> Gestionar Pedidos
        </a>
        <a href="/Panaderia_Web/view/admin/gestionar_usuarios.php" class="<?php echo ($pagina == 'gestUsuarios') ? 'active' : ''; ?>">
            <i class="fas fa-users"></i> Gestionar Usuarios
        </a>
        <a href="/Panaderia_Web/view/admin/gestionar_notificaciones.php" class="<?php echo ($pagina == 'notificaciones') ? 'active' : ''; ?>">
            <i class="fas fa-bell"></i> Generar Notificaciones
        </a>
        <div class="dropdown">
            <a href="#" class="dropdown-toggle <?php echo ($pagina == 'reportes') ? 'active' : ''; ?>" id="reportesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-chart-bar"></i> Generar Reportes
            </a>
            <ul class="dropdown-menu" aria-labelledby="reportesDropdown">
                <li><a class="dropdown-item" href="/Panaderia_Web/view/admin/reportes_notificaciones.php">Reportes de Notificaciones</a></li>
                <li><a class="dropdown-item" href="/Panaderia_Web/view/admin/reportes_productos.php">Reportes de Productos</a></li>
                <li><a class="dropdown-item" href="/Panaderia_Web/view/admin/reportes_pedidos.php">Reportes de Pedidos</a></li>
            </ul>
        </div>
        <a href="perfil.php" class="<?php echo ($pagina == 'perfil') ? 'active' : ''; ?>">
            <i class="fas fa-user"></i> Mi perfil
        </a>
        <a href="/Panaderia_Web/controller/LogoutController.php">
            <i class="fas fa-sign-out-alt"></i> Cerrar sesión
        </a>
    </div>
</nav>
