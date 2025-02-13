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
            <i class="fas fa-glass-whiskey"></i> Lácteos
        </a>
        <a href="/Panaderia_Web/view/guest/ayuda.php" class="<?php echo ($pagina == 'ayuda') ? 'active' : ''; ?>">
            <i class="fas fa-info-circle"></i> Ayuda
        </a>
        <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal">
            <i class="fas fa-sign-in-alt"></i> Iniciar sesión
        </a>
        <a href="#" data-bs-toggle="modal" data-bs-target="#registroModal">
            <i class="fas fa-user-plus"></i> Registrarse
        </a>
    </div>
</nav>

<?php include 'C:/xampp/htdocs/Panaderia_Web/view/guest/login.php'; ?>
<?php include 'C:/xampp/htdocs/Panaderia_Web/view/guest/registro.php'; ?>