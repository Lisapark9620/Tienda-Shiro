<?php
include 'config.php';

if (empty($_SESSION['carrito'])) {
    header('Location: carrito.php');
    exit();
}

try {
    // Calcular total
    $total = 0;
    foreach ($_SESSION['carrito'] as $producto) {
        $total += $producto['precio'] * $producto['cantidad'];
    }

    // Iniciar transacción
    $conn->beginTransaction();

    // Insertar pedido
    $stmt = $conn->prepare("INSERT INTO pedidos (total) VALUES (?)");
    $stmt->execute([$total]);
    $id_pedido = $conn->lastInsertId();

    // Insertar detalles del pedido
    $stmt = $conn->prepare("INSERT INTO detalles_pedido
                           (id_pedido, id_producto, cantidad, precio_unitario, subtotal) 
                           VALUES (?, ?, ?, ?, ?)");

    foreach ($_SESSION['carrito'] as $producto) {
        $subtotal = $producto['precio'] * $producto['cantidad'];
        $stmt->execute([
            $id_pedido,
            $producto['id_producto'],
            $producto['cantidad'],
            $producto['precio'],
            $subtotal
        ]);
    }

    // Confirmar transacción
    $conn->commit();

    // Vaciar carrito
    $_SESSION['carrito'] = array();

    // Mostrar confirmación
    header('Location: pedido_confirmado.php?id=' . $id_pedido);
    exit();

} catch (Exception $e) {
    // Revertir transacción en caso de error
    $conn->rollBack();
    echo "Error al confirmar el pedido: " . $e->getMessage();
}

    // catch: Atrapa errores

    // rollBack(): Deshace cambios para mantener la BD consistente

    // $e->getMessage(): Da información del error (útil para depurar)
?>