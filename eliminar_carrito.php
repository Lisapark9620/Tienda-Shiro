<?php
require_once 'config.php';

// Asegúrate de que la sesión esté iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_GET['indice'])) {
    $indice = (int)$_GET['indice'];

    // Verificamos si el carrito existe y el índice es válido
    if (isset($_SESSION['carrito']) && isset($_SESSION['carrito'][$indice])) {
        unset($_SESSION['carrito'][$indice]);

        // Reindexar el array para evitar huecos
        $_SESSION['carrito'] = array_values($_SESSION['carrito']);

        // Mensaje de confirmación opcional
        $_SESSION['mensaje'] = 'Producto eliminado del carrito.';
        $_SESSION['mensaje_tipo'] = 'exito';
    } else {
        $_SESSION['mensaje'] = 'Índice inválido o producto no encontrado en el carrito.';
        $_SESSION['mensaje_tipo'] = 'error';
    }
} else {
    $_SESSION['mensaje'] = 'No se proporcionó ningún índice para eliminar.';
    $_SESSION['mensaje_tipo'] = 'error';
}

// Redirigir al carrito
header('Location: carrito.php');
exit;
?>
