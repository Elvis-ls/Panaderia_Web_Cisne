<nav>
    <div class="nav-container">
        <a href="inicio.php" class="<?php echo ($pagina == 'inicio') ? 'active' : ''; ?>">
            <i class="fas fa-home"></i> Inicio
        </a>
        <a href="panaderia.php" class="<?php echo ($pagina == 'panaderia') ? 'active' : ''; ?>">
            <i class="fas fa-bread-slice"></i> Panadería
        </a>
        <a href="pasteleria.php" class="<?php echo ($pagina == 'pasteleria') ? 'active' : ''; ?>">
            <i class="fas fa-cake"></i> Pastelería
        </a>
        <a href="galleteria.php" class="<?php echo ($pagina == 'galleteria') ? 'active' : ''; ?>">
            <i class="fas fa-cookie"></i> Galletería
        </a>
        <a href="cafeteria.php" class="<?php echo ($pagina == 'cafeteria') ? 'active' : ''; ?>">
            <i class="fas fa-coffee"></i> Lácteos
        </a>
        <a href="ayuda.php" class="<?php echo ($pagina == 'ayuda') ? 'active' : ''; ?>">
            <i class="fas fa-info-circle"></i> Ayuda
        </a>

        <?php if (isset($_SESSION['id'])): ?>  <!-- Usuario logueado -->
        <!-- Opciones para usuarios logueados -->
        <a href="perfil.php" class="<?php echo ($pagina == 'perfil') ? 'active' : ''; ?>">
            <i class="fas fa-user"></i> Mi perfil
        </a>
        <a href="pedidos.php" class="<?php echo ($pagina == 'pedidos') ? 'active' : ''; ?>">
            <i class="fas fa-box"></i> Mis pedidos
        </a>

        <?php if ($_SESSION['rol_id'] == 1): ?>  <!-- Administrador -->
            <a href="../view/admin/dashboard.php" class="<?php echo ($pagina == 'admin') ? 'active' : ''; ?>">
                <i class="fas fa-tachometer-alt"></i> Admin
            </a>
        <?php endif; ?>

        <!-- Cerrar sesión -->
        <a href="../../controller/LogoutController.php">
            <i class="fas fa-sign-out-alt"></i> Cerrar sesión
        </a>

        <?php else: ?>  <!-- Invitado -->
        <!-- Opciones para invitados -->
        <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal">
            <i class="fas fa-sign-in-alt"></i> Iniciar sesión
        </a>
        <a href="#" data-bs-toggle="modal" data-bs-target="#registroModal">
            <i class="fas fa-user-plus"></i> Registrarse
        </a>
        <?php endif; ?>
    </div>
</nav>

<!-- Incluir los modales de inicio de sesión y registro -->
<?php include 'C:/xampp/htdocs/Panaderia_Web/view/guest/login.php'; ?>
<?php include 'C:/xampp/htdocs/Panaderia_Web/view/guest/registro.php'; ?>
