<?php
session_start();
include_once('conn.php');
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

$carrito = $_SESSION['carrito'];

$libros = [];
if (!empty($carrito)) {
    $placeholders = implode(',', array_fill(0, count($carrito), '?'));
    $query = "SELECT * FROM libros WHERE ID IN ($placeholders)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param(str_repeat('i', count($carrito)), ...array_keys($carrito)); 
    $stmt->execute();
    $resultado = $stmt->get_result();

    while ($fila = $resultado->fetch_assoc()) {
        $libros[] = $fila;
    }
}

$total = 0;
foreach ($libros as $libro) {
    if (isset($_SESSION['carrito'][$libro['ID']])) {
        $total += $libro['precio'] * $_SESSION['carrito'][$libro['ID']];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark sticky-top" id="nav">
    <div class="container">
        <a class="navbar-brand" href="index.php"> Librería Online</a>
    </div>
</nav>
<section class="py-5">
    <div class="container">
        <h2 class="mb-4">Tu Carrito</h2>

        <?php if (empty($libros)): ?>
            <p>No hay libros en el carrito.</p>
        <?php else: ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Libro</th>
                        <th>Autor</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($libros as $libro): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($libro['titulo']); ?></td>
                            <td><?php echo htmlspecialchars($libro['autor']); ?></td>
                            <td>$<?php echo number_format($libro['precio'], 0, ',', '.'); ?></td>
                            <td>
                                <form action="actualizar_carrito.php" method="POST">
                                    <input type="number" name="cantidad" value="<?php echo $_SESSION['carrito'][$libro['ID']]; ?>" min="1" max="<?php echo $libro['stock']; ?>" />
                                    <input type="hidden" name="ID_libro" value="<?php echo $libro['ID']; ?>" />
                                    <button type="submit" class="btn btn-primary btn-sm">Actualizar</button>
                                </form>
                            </td>
                            <td>
                                <form action="eliminar_libro.php" method="POST">
                                    <input type="hidden" name="ID_libro" value="<?php echo $libro['ID']; ?>" />
                                    <button type="submit" class="btn btn-secondary btn-sm">Eliminar</button>
                                </form>
                            </td>
                            <td>$<?php echo number_format($libro['precio'] * $_SESSION['carrito'][$libro['ID']], 0, ',', '.'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <h4>Total: $<?php echo number_format($total, 0, ',', '.'); ?></h4>

            <div class="d-flex justify-content-between mt-4">
                <form action="#" method="POST">
                    <button type="submit" class="btn btn-danger">Vaciar Carrito</button>
                </form>

                <form action="#" method="POST">
                    <button type="submit" class="btn">Confirmar Pedido</button>
                </form>
            </div>
        <?php endif; ?>
    </div>
</section>
<footer class="text-white text-center py-3" id="nav">
    <div class="container">
        <small>© 2025 Librería Online - Todos los derechos reservados.</small>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
