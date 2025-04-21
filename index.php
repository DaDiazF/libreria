<?php
include_once('conn.php');
session_start();
$query = "SELECT * FROM libros";
$resultadoLibros = mysqli_query($conn, $query);
$libros = [];
if ($resultadoLibros && mysqli_num_rows($resultadoLibros) > 0) {
    while ($fila = mysqli_fetch_assoc($resultadoLibros)) {
        $libros[] = $fila;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web SPA - Proyecto final</title>
    <link rel="stylesheet" href="styles.css"> 
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark sticky-top" id="nav">
    <div class="container">
        <a class="navbar-brand" href="#"> Librería Online</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" href="#">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Catálogo</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="carrito.php">Carrito <span class="badge bg-light text-primary" id="contador"> </span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="nuevos_libros.php">Agregar libro</a>
                </li>
            </ul>
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userMenu" role="button" data-bs-toggle="dropdown">
                        Mi Cuenta
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#">Perfil</a></li>
                        <li><a class="dropdown-item" href="logout.php">Cerrar sesión</a></li>
                    </ul>
                </li>
                <?php 
            if (isset($_SESSION['usuario'])): ?>
            <li class="nav-item">
              <a class="nav-link" href="#">Hola, <?php echo htmlspecialchars($_SESSION['usuario']['nombre']);?></a>
            </li>
          <?php else: ?>
            <li class="nav-item">
              <a class="nav-link" href="login.php">Ingresa aquí</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="sign.php">Regístrate aquí</a>
            </li>
          <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<section class="py-5 text-center bg-light">
    <div class="container">
        <h1 class="display-4">Bienvenido a nuestra Librería</h1>
        <p class="lead">Descubre las mejores novedades y encuentra tu próximo libro favorito.</p>
        <a href="#" class="btn text-white mt-3" id="nav">Ver Catálogo</a>
    </div>
</section>
<section class="py-5">
    <div class="container">
        <h2 class="mb-4">Novedades</h2>
        <div class="row g-4">
        <?php if (!empty($libros)): ?>
            <?php foreach ($libros as $libro): ?>
                <div class="col-md-4">
    <div class="card h-100 shadow">
        <img src="img/libro.jpg" class="card-img-top" alt="Portada del libro">
        <div class="card-body d-flex flex-column">
            <h5 class="card-title"><?php echo htmlspecialchars($libro['titulo']); ?></h5>
            <p class="card-text"><strong>Autor:</strong> <?php echo htmlspecialchars($libro['autor']); ?></p>
            <p class="card-text"><strong>Precio:</strong> $<?php echo number_format($libro['precio'], 0, ',', '.'); ?></p>
            <p class="card-text"><strong>Stock:</strong> <?php echo $libro['stock']; ?></p>
            <div class="row-md-4">
                <button class="btn mt-auto" id="nav">Ver más</button>
                <button class="btn mt-auto" id="nav" type="submit" onclick="agregar(<?php echo $libro['ID']; ?>)">Agregar al carrito</button>
            </div>
        </div>
    </div>
</div>

            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <p class="text-center">No hay libros disponibles en este momento.</p>
            </div>
        <?php endif; ?>
        </div>
    </div>
</section>
<footer class="text-white text-center py-3" id="nav">
    <div class="container">
        <small>© 2025 Librería Online - Todos los derechos reservados.</small>
    </div>
</footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="script.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>