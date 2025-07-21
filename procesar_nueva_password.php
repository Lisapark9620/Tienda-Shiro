<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: recuperar_password.php');
    exit();
}

$token = clean_input($_POST['token']);
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

// Validar que las contraseñas coincidan
if ($password !== $confirm_password) {
    header('Location: recuperar_password.php?token='.$token.'&error=Las contraseñas no coinciden');
    exit();
}

try {
    // Verificar token válido y no expirado
    $stmt = $conn->prepare("SELECT id_usuario FROM usuarios WHERE token_recuperacion = ? AND token_expiracion > NOW()");
    $stmt->execute([$token]);
    $usuario = $stmt->fetch();

    if (!$usuario) {
        header('Location: recuperar_password.php?error=El enlace de recuperación no es válido o ha expirado');
        exit();
    }

    // Actualizar contraseña
    $password_hash = hashPassword($password);
    $stmt = $conn->prepare("UPDATE usuarios SET password = ?, token_recuperacion = NULL, token_expiracion = NULL WHERE id_usuario = ?");
    $stmt->execute([$password_hash, $usuario['id_usuario']]);

    // Redirigir al login con mensaje de éxito
    header('Location: login.php?success=Tu contraseña ha sido actualizada correctamente');
    exit();

} catch (PDOException $e) {
    error_log("Error al actualizar contraseña: " . $e->getMessage());
    header('Location: recuperar_password.php?token='.$token.'&error=Ocurrió un error al actualizar tu contraseña');
    exit();
}