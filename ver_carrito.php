<?php
session_start();

if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    $contadorCarrito = 0;
} else {
    $_SESSION['carrito'] = array_filter($_SESSION['carrito'], function($cantidad) {
        return $cantidad > 0;
    });

    $contadorCarrito = array_sum($_SESSION['carrito']);
}

echo json_encode([
    'count' => $contadorCarrito
]);
exit();
