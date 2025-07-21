aquí es todos bien ? <?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: recuperar_password.php');
    exit();
}

$email = clean_input($_POST['email']);

try {
    // Verificar si el email existe
    $stmt = $conn->prepare("SELECT id_usuario, nombre FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch();

    if (!$usuario) {
        header('Location: recuperar_password.php?error=No existe una cuenta con este correo electrónico');
        exit();
    }

    // Generar token de recuperación (válido por 1 hora)
    $token = bin2hex(random_bytes(32));
    $expiracion = date('Y-m-d H:i:s', strtotime('+1 hour'));

    // Guardar token en la base de datos
    $stmt = $conn->prepare("UPDATE usuarios SET token_recuperacion = ?, token_expiracion = ? WHERE id_usuario = ?");
    $stmt->execute([$token, $expiracion, $usuario['id_usuario']]);

    // Enviar email con el enlace (simulado en este ejemplo)
    $enlace_recuperacion = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/recuperar_password.php?token=$token";
    
    // En un entorno real, aquí enviarías el email:
    /*
    $asunto = "Restablecer tu contraseña";
    $mensaje = "Hola {$usuario['nombre']},\n\n";
    $mensaje .= "Para restablecer tu contraseña, haz clic en el siguiente enlace:\n";
    $mensaje .= $enlace_recuperacion . "\n\n";
    $mensaje .= "Si no solicitaste este cambio, ignora este mensaje.\n";
    $mensaje .= "El enlace expirará en 1 hora.\n\n";
    $mensaje .= "Saludos,\nEl equipo de Restaurante Gourmet";
    
    mail($email, $asunto, $mensaje);
    */

    // Redirigir con mensaje de éxito
    header('Location: recuperar_password.php?success=1');
    exit();

} catch (PDOException $e) {
    error_log("Error en recuperación: " . $e->getMessage());
    header('Location: recuperar_password.php?error=Ocurrió un error al procesar tu solicitud');
    exit();
}