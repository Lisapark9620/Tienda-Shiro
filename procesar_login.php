<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    try {
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($password, $usuario['password'])) {
            $_SESSION['usuario'] = $usuario;
            
            // Перенаправление администратора в панель управления
            if ($usuario['rol'] === 'admin') {
                header('Location: admin_productos.php');
            } else {
                header('Location: index.php');
            }
            exit();
        } else {
            header('Location: login.php?error=1');
            exit();
        }
    } catch (PDOException $e) {
        header('Location: login.php?error=1');
        exit();
    }
} else {
    header('Location: login.php');
    exit();
}
?>