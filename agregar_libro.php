<?php
session_start();
include_once('conn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];

    $query = "INSERT INTO libros (titulo, autor, precio, stock) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssds', $titulo, $autor, $precio, $stock);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        $_SESSION['mensaje'] = 'Libro agregado exitosamente';
    } else {
        $_SESSION['mensaje'] = 'Hubo un error al agregar el libro';
    }

    header('Location: index.php'); 
    exit();
}
?>
