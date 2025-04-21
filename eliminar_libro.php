<?php
session_start();

if (isset($_POST['ID_libro'])) {
    $ID_libro = $_POST['ID_libro'];

    if (isset($_SESSION['carrito'][$ID_libro])) {
        unset($_SESSION['carrito'][$ID_libro]);
    }
}

header('Location: carrito.php');
exit();
?>
