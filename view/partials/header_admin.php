<header>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&family=Lora:wght@400;600&display=swap" rel="stylesheet">

    <div class="container">
        <div class="row align-items-center py-3">
            <div class="col-md-4 text-center text-md-start">
                <div class="logo">
                    <img src="http://localhost/Panaderia_Web/public/images/logo.png" alt="Logo Panadería" class="img-fluid" style="max-width: 150px;">
                    <h1 class="d-inline-block align-middle ms-3">Panadería Don Juan</h1>
                </div>
            </div>
            <div class="col-md-8 text-center text-md-end">
                <div class="header-extras d-flex justify-content-end align-items-center">
                    <!-- Mostrar barra de búsqueda para rol 1 -->
                    <form class="d-flex me-3" action="/Panaderia_Web/controller/SearchController.php" method="GET">
                        <input class="form-control me-2" type="search" placeholder="Buscar" aria-label="Buscar" name="query" style="background-color: #ffffff; color: #000000;">
                        <button class="btn btn-outline-light" type="submit" style="border-color: #ffffff; color: #ffffff;">Buscar</button>
                    </form>
                    <p class="badge text-white ms-3" style="font-size: 1.2em; background-color: #d4a373;">Administrador</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col text-center">
                <p>El arte de hornear con amor</p>
            </div>
        </div>
    </div>
</header>

<style>
.badge {
    padding: 10px 20px;
    border-radius: 20px;
    font-weight: 600;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    background-color: #d4a373; /* Color marrón claro */
    color: #ffffff; /* Texto blanco */
}
</style>
