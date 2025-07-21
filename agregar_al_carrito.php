<?php
require_once 'config.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_producto'])) {
    $id_producto = (int)$_POST['id_producto'];
    
    // Verificar stock antes de agregar
    $stmt = $conn->prepare("SELECT * FROM productos WHERE id_producto = ? AND stock > 0");
    $stmt->execute([$id_producto]);
    $producto = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($producto) {
        $encontrado = false;
        foreach ($_SESSION['carrito'] as &$item) {
            if ($item['id_producto'] == $id_producto) {
                // Verificar que no exceda el stock al incrementar
                if (($item['cantidad'] + 1) <= $producto['stock']) {
                    $item['cantidad'] += 1;
                    $encontrado = true;
                } else {
                    $_SESSION['error_carrito'] = "No hay suficiente stock para este producto.";
                }
                break;
            }
        }
        
        if (!$encontrado) {
            $_SESSION['carrito'][] = [
                'id_producto' => $producto['id_producto'],
                'nombre'     => $producto['nombre'],
                'precio'     => $producto['precio'],
                'cantidad'   => 1
            ];
        }
    } else {
        $_SESSION['error_carrito'] = "Producto no disponible o sin stock.";
    }
}
$_SESSION['mensaje'] = "El producto ha sido añadido al carrito.";
header("Location: index.php");
header('Location: '.($_SERVER['HTTP_REFERER'] ?? 'index.php'));
exit();
?>
