<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cantidad'])) {
    foreach ($_POST['cantidad'] as $indice => $cantidad) {
        $indice = (int)$indice; // Asegurar que es un entero
        $cantidad = max(1, (int)$cantidad); // Validar cantidad mínima
        
        if (isset($_SESSION['carrito'][$indice])) {
            // Verificar stock disponible antes de actualizar
            $id_producto = $_SESSION['carrito'][$indice]['id_producto'];
            $stmt = $conn->prepare("SELECT stock FROM productos WHERE id_producto = ?");
            $stmt->execute([$id_producto]);
            $producto = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($producto && $cantidad <= $producto['stock']) {
                $_SESSION['carrito'][$indice]['cantidad'] = $cantidad;
            } else {
                $_SESSION['error_carrito'] = "La cantidad solicitada excede el stock disponible para algunos productos.";
            }
        }
    }
}

header('Location: carrito.php');
exit();
?>