<?php
header('Content-Type: application/json');
session_start();

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

if (isset($_POST['ID_libro'])) {
    $ID_libro = $_POST['ID_libro'];

    if (isset($_SESSION['carrito'][$ID_libro])) {
        $_SESSION['carrito'][$ID_libro]++;
    } else {
        $_SESSION['carrito'][$ID_libro] = 1;
    }

    $contadorCarrito = array_sum($_SESSION['carrito']);

    echo json_encode([
        'success' => true,
        'message' => 'Libro agregado al carrito',
        'contador' => $contadorCarrito
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'No se ha enviado un ID válido',
    ]);
}

exit();
