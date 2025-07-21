<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Restaurante Gourmet</title>
    
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
            --transition-speed: 0.4s;
            --gold-light: #e8d8b8;
            --gold-dark: #b8934e;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: var(--light-color);
            color: var(--text-color);
            background-image: url('https://html5book.ru/wp-content/uploads/2015/05/svetlye_fony.jpg');
            background-size: cover;
            background-attachment: fixed;
            background-position: center;
            background-blend-mode: overlay;
            background-color: rgba(248, 245, 240, 0.9);
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 2rem;
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.18);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
            width: 100%;
            max-width: 450px;
            margin: 0 auto;
            overflow: hidden;
        }
        
        .form-header {
            background: linear-gradient(to right, var(--primary-color), #2a2a2a);
            color: var(--gold-light);
            padding: 1.5rem;
            text-align: center;
            position: relative;
        }
        
        .form-header h2 {
            font-family: 'Cormorant Garamond', serif;
            font-weight: 600;
            margin: 0;
            letter-spacing: 1px;
        }
        
        .form-header:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 3px;
            background: linear-gradient(90deg, var(--secondary-color), var(--gold-light));
        }
        
        .form-body {
            padding: 2rem 2.5rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: var(--primary-color);
            font-size: 0.9rem;
        }
        
        .form-control {
            border: 1px solid #ddd;
            border-radius: 0.45rem;
            padding: 0.75rem 1rem;
            transition: all var(--transition-speed);
        }
        
        .form-control:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 0.25rem rgba(201, 166, 107, 0.25);
        }
        
        .btn-elegant {
            padding: 0.8rem 1.8rem;
            border-radius: 0.45rem;
            font-weight: 500;
            transition: all var(--transition-speed);
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 1px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.7rem;
            border: none;
            position: relative;
            overflow: hidden;
            z-index: 1;
            width: 100%;
        }
        
        .btn-elegant:after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--secondary-color), var(--gold-dark));
            z-index: -1;
            transition: all 0.3s ease;
            opacity: 0;
        }
        
        .btn-elegant:hover:after {
            opacity: 1;
        }
        
        .btn-primary-elegant {
            background-color: var(--primary-color);
            color: var(--text-light);
        }
        
        .btn-primary-elegant:hover {
            color: var(--text-light);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .btn-primary-elegant:after {
            background: linear-gradient(135deg, #333, #000);
        }
        
        .alert-danger {
            background-color: rgba(231, 76, 60, 0.1);
            border-left: 3px solid #e74c3c;
            color: #721c24;
            padding: 0.75rem 1.25rem;
            border-radius: 0.25rem;
            margin-bottom: 1.5rem;
        }
        
        .form-footer {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(0,0,0,0.1);
            color: var(--text-color);
        }
        
        .form-footer a {
            color: var(--secondary-color);
            font-weight: 500;
            transition: color var(--transition-speed);
        }
        
        .form-footer a:hover {
            color: var(--gold-dark);
            text-decoration: none;
        }
        
        .password-container {
            position: relative;
        }
        
        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: var(--secondary-color);
        }
        
        @media (max-width: 576px) {
            body {
                padding: 1rem;
            }
            
            .glass-card {
                border-radius: 8px;
            }
            
            .form-body {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="glass-card">
        <div class="form-header">
            <h2>Iniciar Sesión</h2>
        </div>
        
        <div class="form-body">
            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i> Correo electrónico o contraseña incorrectos
                </div>
            <?php endif; ?>

            <form action="procesar_login.php" method="post">
                <div class="form-group">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                
                <div class="form-group password-container">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                    <i class="fas fa-eye toggle-password" onclick="togglePassword()"></i>
                </div>
                
                <div class="d-flex justify-content-end mb-4">
                    <a href="recuperar_password.php" style="font-size: 0.85rem; color: var(--secondary-color);">¿Olvidaste tu contraseña?</a>
                </div>
                
                <button type="submit" class="btn-elegant btn-primary-elegant">
                    <i class="fas fa-sign-in-alt me-2"></i> Iniciar Sesión
                </button>
            </form>
            
            <div class="form-footer">
                ¿No tienes una cuenta? <a href="register.php">Regístrate aquí</a>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const icon = document.querySelector('.toggle-password');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>