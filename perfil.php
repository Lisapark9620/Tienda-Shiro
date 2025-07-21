<?php
include 'config.php';
requerirAutenticacion();

$usuario = $_SESSION['usuario'];

// Obtener pedidos del usuario
$pedidos = [];
try {
    $stmt = $conn->prepare("SELECT * FROM pedidos WHERE id_usuario = ? ORDER BY fecha DESC");
    $stmt->execute([$usuario['id_usuario']]);
    $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    error_log("Error al obtener pedidos: " . $e->getMessage());
    $error_pedidos = "Error al cargar el historial de pedidos";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi perfil - Tienda Shiro</title>
    
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
        
        .info-label {
            font-weight: 500;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }
        
        .info-value {
            padding: 0.75rem;
            background-color: var(--light-color);
            border-left: 3px solid var(--secondary-color);
            margin-bottom: 1.5rem;
            border-radius: 0.45rem;
        }
        
        .role-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            background-color: var(--secondary-color);
            color: var(--primary-color);
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: uppercase;
        }
        
        .btn-profile {
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
        
        .btn-edit {
            background-color: var(--secondary-color);
            color: var(--primary-color);
            border: 1px solid var(--secondary-color);
        }
        
        .btn-secondary {
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
        }
        
        .btn-secondary:hover {
            background-color: var(--primary-color);
            color: var(--secondary-color);
        }
        
        .btn-edit:hover {
            background-color: var(--primary-color);
            color: var(--secondary-color);
            border-color: var(--primary-color);
        }
        
        .btn-change {
            background-color: transparent;
            color: var(--primary-color);
            border: 1px solid var(--secondary-color);
        }
        
        .btn-change:hover {
            background-color: var(--secondary-color);
            color: var(--primary-color);
        }
        
        .empty-state {
            text-align: center;
            padding: 2rem 1rem;
        }
        
        .empty-icon {
            font-size: 2.5rem;
            color: rgba(0,0,0,0.1);
            margin-bottom: 1rem;
        }
        
        .order-status {
            padding: 0.25rem 0.75rem;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .status-completed {
            background-color: #d4edda;
            color: #155724;
        }
        
        .status-cancelled {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .status-processing {
            background-color: #cce5ff;
            color: #004085;
        }
        
        .status-shipped {
            background-color: #e2e3e5;
            color: #383d41;
        }
        
        @media (max-width: 768px) {
            .profile-section {
                padding: 1.5rem;
            }
            
            .btn-profile {
                width: 100%;
            }
            
            .table-responsive {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }
            
            .table th, .table td {
                padding: 0.75rem;
                font-size: 0.9rem;
            }
        }
        
        .alert-warning {
            background-color: #fff3cd;
            border-color: #ffeeba;
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Mi Perfil</h1>
            <a href="index.php" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Inicio
            </a>
        </div>
        
        <!-- Sección de Datos Personales -->
        <section class="profile-section">
            <div class="profile-header">
                <h2 class="h4">Datos personales</h2>
                <p class="mb-0 text-muted">Administra tu información de contacto</p>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="info-label">Nombre completo</div>
                    <div class="info-value"><?php echo htmlspecialchars($usuario['nombre']); ?></div>
                </div>
                
                <div class="col-md-6">
                    <div class="info-label">Correo electrónico</div>
                    <div class="info-value"><?php echo htmlspecialchars($usuario['email']); ?></div>
                </div>
                
                <div class="col-md-6">
                    <div class="info-label">Dirección</div>
                    <div class="info-value">
                        <?php echo $usuario['direccion'] ? htmlspecialchars($usuario['direccion']) : '<span class="text-muted">No especificada</span>'; ?>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="info-label">Teléfono</div>
                    <div class="info-value">
                        <?php echo $usuario['telefono'] ? htmlspecialchars($usuario['telefono']) : '<span class="text-muted">No especificado</span>'; ?>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="info-label">Tipo de cuenta</div>
                    <div class="info-value">
                        <span class="role-badge"><?php echo $usuario['rol'] === 'admin' ? 'Administrador' : 'Cliente'; ?></span>
                    </div>
                </div>
            </div>
            
            <div class="d-flex gap-2 mt-3 flex-wrap">
                <a href="editar_perfil.php" class="btn btn-profile btn-edit">
                    <i class="fas fa-user-edit"></i> Editar perfil
                </a>
                <a href="cambiar_password.php" class="btn btn-profile btn-change">
                    <i class="fas fa-key"></i> Cambiar contraseña
                </a>
            </div>
        </section>
        
        <!-- Sección de Pedidos -->
        <section class="profile-section">
            <div class="profile-header">
                <h2 class="h4">Historial de pedidos</h2>
                <p class="mb-0 text-muted">Tus compras recientes en nuestra tienda</p>
            </div>
            
            <?php if (isset($error_pedidos)): ?>
                <div class="alert alert-warning">
                    <?php echo $error_pedidos; ?>
                </div>
            <?php elseif (!empty($pedidos)): ?>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nº Pedido</th>
                                <th>Fecha</th>
                                <th>Total</th>
                                <th>Estado</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pedidos as $pedido): 
                                $statusClass = 'status-' . str_replace('_', '-', $pedido['estado']);
                            ?>
                            <tr>
                                <td>#<?php echo $pedido['id_pedido']; ?></td>
                                <td><?php echo date('d/m/Y H:i', strtotime($pedido['fecha'])); ?></td>
                                <td>$<?php echo number_format($pedido['total'], 2); ?></td>
                                <td>
                                    <span class="order-status <?php echo $statusClass; ?>">
                                        <?php echo obtenerEstadoPedido($pedido['estado']); ?>
                                    </span>
                                </td>
                            
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <div class="empty-icon"><i class="fas fa-shopping-bag"></i></div>
                    <h3 class="h5">Aún no tienes pedidos</h3>
                    <p class="text-muted">Cuando realices tu primera compra, aparecerá aquí.</p>
                    <a href="index.php" class="btn btn-profile btn-change mt-3">
                        <i class="fas fa-store"></i> Explorar productos
                    </a>
                </div>
            <?php endif; ?>
        </section>
    </div>
    
    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>