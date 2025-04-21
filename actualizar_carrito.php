<?php
session_start();

if (isset($_POST['ID_libro']) && isset($_POST['cantidad'])) {
    $ID_libro = $_POST['ID_libro'];
    $cantidad = $_POST['cantidad'];

    if ($cantidad > 0) {
        if (isset($_SESSION['carrito'][$ID_libro])) {
            $_SESSION['carrito'][$ID_libro] = $cantidad;
        } else {
            echo "El libro no está en el carrito.";
        }
    } else {
        echo "La cantidad debe ser mayor a cero.";
    }
}

header('Location: carrito.php');
exit();
?>
