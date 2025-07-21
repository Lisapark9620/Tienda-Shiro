<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $direccion = trim($_POST['direccion']);
    $telefono = trim($_POST['telefono']);

    try {
        // Проверка существования email
        $stmt = $conn->prepare("SELECT id_usuario FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        
        if ($stmt->rowCount() > 0) {
            header('Location: register.php?error=email_exists');
            exit();
        }

        // Создание пользователя
        $stmt = $conn->prepare("INSERT INTO usuarios 
                              (nombre, email, password, direccion, telefono) 
                              VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([
            $nombre,
            $email,
            hashPassword($password),
            $direccion,
            $telefono
        ]);

        // Автоматический вход после регистрации
        $id_usuario = $conn->lastInsertId();
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE id_usuario = ?");
        $stmt->execute([$id_usuario]);
        $_SESSION['usuario'] = $stmt->fetch(PDO::FETCH_ASSOC);

        header('Location: index.php');
        exit();

    } catch (PDOException $e) {
        header('Location: register.php?error=db_error');
        exit();
    }
} else {
    header('Location: register.php');
    exit();
}
?>