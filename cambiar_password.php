<?php
include 'config.php';
requerirAutenticacion();

$usuario = $_SESSION['usuario'];
$mensaje = '';
$error = '';
$fortaleza = '';

// Función para evaluar fortaleza de contraseña (igual que en tu código original)
function evaluarFortaleza($password) {
    $fortaleza = 0;
    if (strlen($password) >= 8) $fortaleza += 1;
    if (preg_match('/[0-9]/', $password)) $fortaleza += 1;
    if (preg_match('/[A-Z]/', $password)) $fortaleza += 1;
    if (preg_match('/[^a-zA-Z0-9]/', $password)) $fortaleza += 1;
    if (strlen($password) >= 12) $fortaleza += 1;
    
    switch($fortaleza) {
        case 0: case 1: return 'Muy débil';
        case 2: return 'Débil';
        case 3: return 'Moderada';
        case 4: return 'Fuerte';
        case 5: return 'Muy fuerte';
        default: return '';
    }
}

// Procesamiento del formulario (igual que en tu código original)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password_actual = $_POST['password_actual'] ?? '';
    $nueva_password = $_POST['nueva_password'] ?? '';
    $confirmar_password = $_POST['confirmar_password'] ?? '';
    
    if (empty($password_actual) || empty($nueva_password) || empty($confirmar_password)) {
        $error = "Todos los campos son obligatorios";
    } elseif (!password_verify($password_actual, $usuario['password'])) {
        $error = "La contraseña actual es incorrecta";
    } elseif ($nueva_password !== $confirmar_password) {
        $error = "Las nuevas contraseñas no coinciden";
    } elseif (password_verify($nueva_password, $usuario['password'])) {
        $error = "La nueva contraseña debe ser diferente a la actual";
    } elseif (strlen($nueva_password) < 8) {
        $error = "La contraseña debe tener al menos 8 caracteres";
    } else {
        $fortaleza = evaluarFortaleza($nueva_password);
        
        if (in_array($fortaleza, ['Muy débil', 'Débil']) && !isset($_POST['confirm_weak'])) {
            $error = "Tu contraseña es considerada $fortaleza. ¿Estás seguro de que deseas usarla?";
        } else {
            try {
                $hashed_password = password_hash($nueva_password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("UPDATE usuarios SET password = ?, ultimo_cambio_pass = NOW() WHERE id_usuario = ?");
                $stmt->execute([$hashed_password, $usuario['id_usuario']]);
                
                $_SESSION['usuario']['password'] = $hashed_password;
                
                if (function_exists('enviarEmail')) {
                    $asunto = "Contraseña actualizada - Tienda Shiro";
                    $mensaje_email = "Hola ".$usuario['nombre'].",\n\n";
                    $mensaje_email .= "Tu contraseña ha sido actualizada correctamente.\n";
                    $mensaje_email .= "Fecha: ".date('d/m/Y H:i:s')."\n";
                    $mensaje_email .= "IP: ".$_SERVER['REMOTE_ADDR']."\n\n";
                    $mensaje_email .= "Saludos,\nEl equipo de Tienda Shiro";
                    
                    enviarEmail($usuario['email'], $asunto, $mensaje_email);
                }
                
                $mensaje = "Contraseña cambiada correctamente. Se ha enviado una confirmación a tu email.";
                $_POST = array();
            } catch (PDOException $e) {
                $error = "Error al cambiar la contraseña: " . $e->getMessage();
            }
        }
    }
    
    if (!empty($nueva_password) && empty($fortaleza)) {
        $fortaleza = evaluarFortaleza($nueva_password);
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar contraseña - Tienda Shiro</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #1a1a1a;
            --secondary-color: #c9a66b;
            --light-color: #f8f5f0;
            --text-color: #333;
            --text-light: #f8f8f8;
            --success-color: #28a745;
            --error-color: #dc3545;
            --warning-color: #ffc107;
            --info-color: #17a2b8;
            --transition-speed: 0.4s;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: var(--light-color);
            color: var(--text-color);
        }
        
        h1, h2, h3 {
            font-family: 'Cormorant Garamond', serif;
            font-weight: 600;
        }
         .btn-secondary{
             background-color: var(--secondary-color);
            color: var(--primary-color);
        }
        .btn-secondary:hover{
background-color: var(--primary-color);
            color: var(--secondary-color);
            
        }
        .password-card {
            background: white;
            border-radius: 0;
            border: 1px solid rgba(0,0,0,0.05);
            margin-bottom: 2rem;
            padding: 1.5rem;
        }
        .form-control{
            padding: 0.75rem;
            background-color: var(--light-color);
            border-left: 3px solid var(--secondary-color);
            margin-bottom: 1.5rem;
            border-radius: 0.45rem;
        }
         .form-control:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 0.25rem rgba(201, 166, 107, 0.25);
        }
        
        .btn-dark, .btn-secondary{
        
    background-color: var(--secondary-color);
    color: var(--primary-color);
    border: 1px solid var(--secondary-color);
    
    padding: 0.75rem 1.5rem;
    border-radius: 0.45rem;
    font-weight: 500;
    transition: all var(--transition-speed);
    text-transform: uppercase;
    font-size: 0.8rem;
    letter-spacing: 0.5px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

        
        .btn-dark:hover{
            background-color: var(--primary-color);
    color: var(--secondary-color);
    border: var(--primary-color);
        }
        .password-header {
    border-bottom: 1px solid var(--secondary-color);
    padding-bottom: 1rem;
    margin-bottom: 1.5rem;

        }
        #req-number, #req-length, #req-upper, #req-special {
            font-size: 0.8rem;
        }
        .fa-eye{
            justify-content: center;
        }
       
        .strength-indicator {
            height: 6px;
            background-color: #e9ecef;
            border-radius: 3px;
            margin-top: 0.5rem;
            overflow: hidden;
        }
        
        .strength-meter {
            height: 100%;
            width: 0;
            transition: width 0.4s ease;
        }
        
        .strength-weak .strength-meter {
            background-color: var(--error-color);
            width: 25%;
        }
        
        .strength-moderate .strength-meter {
            background-color: var(--warning-color);
            width: 50%;
        }
        
        .strength-good .strength-meter {
            background-color: var(--info-color);
            width: 75%;
        }
        
        .strength-strong .strength-meter {
            background-color: var(--success-color);
            width: 100%;
        }
        
        .strength-text {
            font-size: 0.8rem;
            margin-top: 0.3rem;
            font-weight: 500;
            text-align: right;
        }
        
        .strength-weak .strength-text {
            color: var(--error-color);
        }
        
        .strength-moderate .strength-text {
            color: var(--warning-color);
        }
        
        .strength-good .strength-text {
            color: var(--info-color);
        }
        
        .strength-strong .strength-text {
            color: var(--success-color);
        }
        
        .requirement-met {
            color: var(--success-color);
        }
        
        .requirement-met::before {
            content: "✓ ";
            color: var(--success-color);
        }
        
        .password-toggle {
            cursor: pointer;
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--secondary-color);
        }
        
        @media (max-width: 768px) {
            .password-card {
                border-left: none;
                border-right: none;
            }
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Cambiar Contraseña</h1>
            <a href="perfil.php" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Volver
            </a>
        </div>
        
        <!-- Tarjeta de contraseña -->
        <div class="password-card">
            <div class="password-header">
                <h2 class="h4 mb-0">Seguridad de la cuenta</h2>
            </div>
            
            <div class="card-body">
                <?php if (!empty($mensaje)): ?>
                    <div class="alert alert-success">
                        <?php echo htmlspecialchars($mensaje); ?>
                    </div>
                <?php endif; ?>
                
                <?php if (!empty($error)): ?>
                    <div class="alert <?php echo strpos($error, '¿Estás seguro') !== false ? 'alert-warning' : 'alert-danger'; ?>">
                        <?php echo htmlspecialchars($error); ?>
                        
                        <?php if (strpos($error, '¿Estás seguro') !== false): ?>
                            <form method="POST" class="mt-3">
                                <input type="hidden" name="password_actual" value="<?php echo htmlspecialchars($_POST['password_actual'] ?? ''); ?>">
                                <input type="hidden" name="nueva_password" value="<?php echo htmlspecialchars($_POST['nueva_password'] ?? ''); ?>">
                                <input type="hidden" name="confirmar_password" value="<?php echo htmlspecialchars($_POST['confirmar_password'] ?? ''); ?>">
                                <input type="hidden" name="confirm_weak" value="1">
                                <button type="submit" class="btn btn-warning me-2">
                                    Sí, usar esta contraseña
                                </button>
                                <a href="cambiar_password.php" class="btn btn-outline-secondary">
                                    No, elegir otra
                                </a>
                            </form>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <form method="POST" id="passwordForm">
                    <!-- Contraseña actual -->
                    <div class="mb-4 position-relative">
                        <label for="password_actual" class="form-label">Contraseña actual</label>
                        <input type="password" id="password_actual" name="password_actual" class="form-control" required>
                        <span class="password-toggle" onclick="togglePassword('password_actual')">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                    
                    <!-- Nueva contraseña -->
                    <div class="mb-4 position-relative">
                        <label for="nueva_password" class="form-label">Nueva contraseña</label>
                        <input type="password" id="nueva_password" name="nueva_password" class="form-control" required 
                               oninput="checkPasswordStrength(this.value)">
                        <span class="password-toggle" onclick="togglePassword('nueva_password')">
                            <i class="fas fa-eye"></i>
                        </span>
                        
                        <div id="strengthContainer" class="<?php 
                            echo !empty($fortaleza) ? 'strength-' . strtolower(str_replace(' ', '-', $fortaleza)) : ''; 
                        ?>">
                            <div class="strength-indicator">
                                <div class="strength-meter"></div>
                            </div>
                            <div class="strength-text">
                                <?php echo !empty($fortaleza) ? "Fortaleza: $fortaleza" : ''; ?>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Confirmar contraseña -->
                    <div class="mb-4 position-relative">
                        <label for="confirmar_password" class="form-label">Confirmar nueva contraseña</label>
                        <input type="password" id="confirmar_password" name="confirmar_password" class="form-control" required>
                        <span class="password-toggle" onclick="togglePassword('confirmar_password')">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                    
                    <!-- Requisitos -->
                    <div class="mb-4">
                        <h6 class="mb-2">Requisitos de contraseña:</h6>
                        <ul class="list-unstyled">
                            <li id="req-length" class=" text-muted <?php echo !empty($_POST['nueva_password']) && strlen($_POST['nueva_password']) >= 8 ? 'requirement-met' : ''; ?>">
                                Mínimo 8 caracteres
                            </li>
                            <li id="req-number" class=" text-muted <?php echo !empty($_POST['nueva_password']) && preg_match('/[0-9]/', $_POST['nueva_password']) ? 'requirement-met' : ''; ?>">
                                Al menos un número
                            </li>
                            <li id="req-upper" class=" text-muted <?php echo !empty($_POST['nueva_password']) && preg_match('/[A-Z]/', $_POST['nueva_password']) ? 'requirement-met' : ''; ?>">
                                Al menos una mayúscula
                            </li>
                            <li id="req-special" class=" text-muted <?php echo !empty($_POST['nueva_password']) && preg_match('/[^a-zA-Z0-9]/', $_POST['nueva_password']) ? 'requirement-met' : ''; ?>">
                                Al menos un carácter especial
                            </li>
                        </ul>
                    </div>
                    
                    <?php if (strpos($error, '¿Estás seguro') !== false): ?>
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" id="confirm_weak" name="confirm_weak" required>
                            <label class="form-check-label" for="confirm_weak">
                                Entiendo que mi contraseña es considerada <?php echo $fortaleza; ?> y deseo usarla de todos modos
                            </label>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Botón de enviar -->
                    <button type="submit" class="btn btn-dark w-100">
                        <i class="fas fa-key me-2"></i> Cambiar contraseña
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Mostrar/ocultar contraseña
        function togglePassword(id) {
            const input = document.getElementById(id);
            const icon = input.nextElementSibling.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
        
        // Evaluar fortaleza de la contraseña
        function checkPasswordStrength(password) {
            const container = document.getElementById('strengthContainer');
            const meter = container.querySelector('.strength-meter');
            const text = container.querySelector('.strength-text');
            
            let strength = 0;
            container.className = '';
            
            // Longitud mínima
            if (password.length >= 8) strength += 1;
            
            // Contiene números
            if (/\d/.test(password)) {
                document.getElementById('req-number').classList.add('requirement-met');
                strength += 1;
            } else {
                document.getElementById('req-number').classList.remove('requirement-met');
            }
            
            // Contiene mayúsculas
            if (/[A-Z]/.test(password)) {
                document.getElementById('req-upper').classList.add('requirement-met');
                strength += 1;
            } else {
                document.getElementById('req-upper').classList.remove('requirement-met');
            }
            
            // Contiene caracteres especiales
            if (/[^a-zA-Z0-9]/.test(password)) {
                document.getElementById('req-special').classList.add('requirement-met');
                strength += 1;
            } else {
                document.getElementById('req-special').classList.remove('requirement-met');
            }
            
            // Longitud muy buena
            if (password.length >= 12) strength += 1;
            
            // Actualizar longitud
            if (password.length >= 8) {
                document.getElementById('req-length').classList.add('requirement-met');
            } else {
                document.getElementById('req-length').classList.remove('requirement-met');
            }
            
            // Determinar nivel de fortaleza
            let strengthClass, strengthText;
            
            switch(strength) {
                case 0: case 1:
                    strengthClass = 'strength-weak';
                    strengthText = 'Muy débil';
                    break;
                case 2:
                    strengthClass = 'strength-moderate';
                    strengthText = 'Débil';
                    break;
                case 3:
                    strengthClass = 'strength-good';
                    strengthText = 'Moderada';
                    break;
                case 4: case 5:
                    strengthClass = 'strength-strong';
                    strengthText = strength === 4 ? 'Fuerte' : 'Muy fuerte';
                    break;
                default:
                    strengthClass = '';
                    strengthText = '';
            }
            
            // Aplicar clases y texto
            container.classList.add(strengthClass);
            text.textContent = strengthText ? `Fortaleza: ${strengthText}` : '';
            
            // Animar la barra de progreso
            setTimeout(() => {
                switch(strengthClass) {
                    case 'strength-weak': meter.style.width = '25%'; break;
                    case 'strength-moderate': meter.style.width = '50%'; break;
                    case 'strength-good': meter.style.width = '75%'; break;
                    case 'strength-strong': meter.style.width = '100%'; break;
                    default: meter.style.width = '0%';
                }
            }, 10);
        }
        
        // Validar que las contraseñas coincidan
        document.getElementById('passwordForm').addEventListener('submit', function(e) {
            const nueva = document.getElementById('nueva_password').value;
            const confirmar = document.getElementById('confirmar_password').value;
            
            if (nueva !== confirmar) {
                e.preventDefault();
                alert('Las contraseñas no coinciden');
            }
        });
    </script>
</body>
</html>