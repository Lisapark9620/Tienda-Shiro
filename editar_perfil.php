<?php
include 'config.php';
requerirAutenticacion();

$usuario = $_SESSION['usuario'];
$mensaje = '';

// Procesar el formulario cuando se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
    $direccion = filter_input(INPUT_POST, 'direccion', FILTER_SANITIZE_STRING);
    $telefono = filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_STRING);
    
    if (empty($nombre)) {
        $mensaje = "El nombre no puede estar vacío";
    } else {
        try {
            $stmt = $conn->prepare("UPDATE usuarios SET nombre = ?, direccion = ?, telefono = ? WHERE id_usuario = ?");
            $stmt->execute([$nombre, $direccion, $telefono, $usuario['id_usuario']]);
            
            $_SESSION['usuario']['nombre'] = $nombre;
            $_SESSION['usuario']['direccion'] = $direccion;
            $_SESSION['usuario']['telefono'] = $telefono;
            
            $mensaje = "Perfil actualizado correctamente";
        } catch (PDOException $e) {
            $mensaje = "Error al actualizar el perfil: " . $e->getMessage();
        }
    }
}

// Obtener datos actualizados
$stmt = $conn->prepare("SELECT * FROM usuarios WHERE id_usuario = ?");
$stmt->execute([$usuario['id_usuario']]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);
$_SESSION['usuario'] = $usuario;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar perfil - Tienda Shiro</title>
    
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
        
        .profile-section {
            background: white;
            border-radius: 0;
            padding: 2rem;
            margin-bottom: 2rem;
            border: 1px solid rgba(0,0,0,0.05);
        }
        
        .profile-header {
            border-bottom: 1px solid var(--secondary-color);
            padding-bottom: 1rem;
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            font-weight: 500;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }
        
        .form-control {
            padding: 0.75rem;
            background-color: var(--light-color);
            border-left: 3px solid var(--secondary-color);
            margin-bottom: 1.5rem;
            border-radius: 0.45rem;
            border: 1px solid rgba(0,0,0,0.1);
        }
        
        .form-control:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 0.25rem rgba(201, 166, 107, 0.25);
        }
        
        .btn-save {
            background-color: var(--secondary-color);
            color: var(--primary-color);
            padding: 0.75rem 1.5rem;
            border-radius: 0.45rem;
            font-weight: 500;
            transition: all var(--transition-speed);
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
            border: 1px solid var(--secondary-color);
        }
        
        .btn-save:hover {
            background-color: var(--primary-color);
            color: var(--secondary-color);
        }
        
        .btn-back {
            background-color: var(--secondary-color);
            color: var(--primary-color);
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
            text-decoration: none;
        }
        
        .btn-back:hover {
            background-color: var(--primary-color);
            color: var(--secondary-color);
        }
        
        .email-note {
            font-size: 0.85rem;
            color: #666;
            margin-top: -1rem;
            margin-bottom: 1.5rem;
        }
        
        .alert {
            border-radius: 0.45rem;
            padding: 1rem;
        }
        
        @media (max-width: 768px) {
            .profile-section {
                padding: 1.5rem;
                border-left: none;
                border-right: none;
            }
            
            .container {
                padding: 0;
            }
            
            .btn-back, .btn-save {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Editar Perfil</h1>
            <a href="perfil.php" class="btn-back">
                <i class="fas fa-arrow-left me-1"></i> Volver
            </a>
        </div>
        
        <!-- Mensajes -->
        <?php if (!empty($mensaje)): ?>
            <div class="alert <?php echo strpos($mensaje, 'correctamente') !== false ? 'alert-success' : 'alert-danger'; ?>">
                <?php echo htmlspecialchars($mensaje); ?>
            </div>
        <?php endif; ?>
        
        <!-- Formulario -->
        <section class="profile-section ">
            <div class="profile-header">
                <h2 class="h4">Información personal</h2>
                <p class="mb-0 text-muted">Actualiza tus datos de contacto</p>
            </div>
            
            <form method="POST">
                <!-- Nombre -->
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre completo</label>
                    <input type="text" id="nombre" name="nombre" class="form-control" 
                           value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>
                </div>
                
                <!-- Email (solo lectura) -->
                <div class="mb-3">
                    <label for="email" class="form-label">Correo electrónico</label>
                    <input type="email" id="email" class="form-control" 
                           value="<?php echo htmlspecialchars($usuario['email']); ?>" readonly>
                    <p class="email-note">Para cambiar el email, contacta con soporte</p>
                </div>
                
                <!-- Dirección -->
                <div class="mb-3">
                    <label for="direccion" class="form-label">Dirección</label>
                    <input type="text" id="direccion" name="direccion" class="form-control" 
                           value="<?php echo htmlspecialchars($usuario['direccion'] ?? ''); ?>">
                </div>
                
                <!-- Teléfono -->
                <div class="mb-4">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="tel" id="telefono" name="telefono" class="form-control" 
                           value="<?php echo htmlspecialchars($usuario['telefono'] ?? ''); ?>">
                </div>
                
                <!-- Botón de guardar -->
                <button type="submit" class="btn btn-save">
                    <i class="fas fa-save me-2"></i> Guardar cambios
                </button>
            </form>
        </section>
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>