<?php
session_start();
include_once('conn.php');

if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    header('Location: carrito.php');
    exit();
}

$carrito = $_SESSION['carrito'];

$total = 0;
foreach ($carrito as $id_libro => $cantidad) {
    $query = "SELECT precio FROM libros WHERE ID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id_libro);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $libro = $resultado->fetch_assoc();
    
    $total += $libro['precio'] * $cantidad;
}

$cliente_id = 1;  

$conn->begin_transaction();

try {
    $query = "INSERT INTO pedidos (cliente_id, total) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('id', $cliente_id, $total);
    $stmt->execute();

    $pedido_id = $stmt->insert_id;

    foreach ($carrito as $id_libro => $cantidad) {
        $query = "SELECT precio FROM libros WHERE ID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $id_libro);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $libro = $resultado->fetch_assoc();

        $precio = $libro['precio'];
        $total_libro = $precio * $cantidad;

        $query = "INSERT INTO detalle_pedido (pedido_id, libro_id, cantidad, precio, total) 
                  VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('iiidi', $pedido_id, $id_libro, $cantidad, $precio, $total_libro);
        $stmt->execute();
    }

    $conn->commit();

    unset($_SESSION['carrito']);

    header('Location: confirmacion.php');
    exit();

} catch (Exception $e) {
    $conn->rollback();
    echo "Error al procesar el pedido: " . $e->getMessage();
}
?>
