<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Restaurante Gourmet - Carrito de Compras</title>
    
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
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.18);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
        }
        
        h1, h2, h3 {
            font-family: 'Cormorant Garamond', serif;
            font-weight: 600;
            color: var(--primary-color);
        }
        
        .page-header {
            position: relative;
            padding-bottom: 15px;
            margin-bottom: 30px;
        }
        
        .page-header:after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, var(--secondary-color), var(--gold-light));
        }
        
        .cart-container {
            max-width: 1200px;
            margin: 40px auto;
        }
        
        .cart-card {
            padding: 2.5rem;
            margin-bottom: 2rem;
            border: none;
            overflow: hidden;
            position: relative;
        }
        
        .cart-card:before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(201, 166, 107, 0.1) 0%, rgba(255,255,255,0) 60%);
            pointer-events: none;
        }
        
        .btn-elegant {
            padding: 0.8rem 1.8rem;
            border-radius: 0.45rem;
            font-weight: 500;
            transition: all var(--transition-speed);
            text-decoration: none;
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
        
        .btn-secondary-elegant {
            background-color: var(--secondary-color);
            color: var(--primary-color);
        }
        
        .btn-secondary-elegant:hover {
            color: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(201, 166, 107, 0.3);
        }
        
        .btn-danger-elegant {
            background-color: #e74c3c;
            color: white;
        }
        
        .btn-danger-elegant:hover {
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(231, 76, 60, 0.3);
        }
        
        .btn-danger-elegant:after {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
        }
        
        .empty-cart {
            text-align: center;
            padding: 3rem 1rem;
        }
        
        .empty-icon {
            font-size: 4rem;
            color: var(--gold-light);
            margin-bottom: 1.5rem;
            opacity: 0.7;
        }
        
        .table-elegant {
            --bs-table-bg: transparent;
            --bs-table-striped-bg: rgba(201, 166, 107, 0.05);
        }
        
        .table-elegant thead th {
            background: linear-gradient(to bottom, var(--primary-color), #2a2a2a);
            color: var(--gold-light);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.85rem;
            padding: 1rem 1.5rem;
            border: none;
        }
        
        .table-elegant tbody td {
            padding: 1.2rem 1.5rem;
            vertical-align: middle;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            font-size: 0.95rem;
        }
        
        .table-elegant tbody tr:last-child td {
            border-bottom: none;
        }
        
        .table-elegant tbody tr:hover td {
            background-color: rgba(248, 245, 240, 0.7);
        }
        
        .quantity-input {
            width: 70px;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 0.5rem;
            font-weight: 500;
        }
        
        .quantity-input:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 0.25rem rgba(201, 166, 107, 0.25);
        }
        
        .total-row {
            font-weight: bold;
            background-color: rgba(201, 166, 107, 0.1);
        }
        
        .total-row td {
            font-size: 1.1rem;
            color: var(--primary-color);
        }
        
        .product-name {
            font-weight: 500;
            color: var(--primary-color);
            transition: color 0.3s ease;
        }
        
        .product-name:hover {
            color: var(--secondary-color);
        }
        
        .action-btn {
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.3s ease;
        }
        
        .action-btn:hover {
            transform: scale(1.1);
        }
        
        .divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(201, 166, 107, 0.5), transparent);
            margin: 1.5rem 0;
        }
        
        @media (max-width: 768px) {
            .cart-card {
                padding: 1.5rem;
            }
            
            .btn-elegant {
                width: 100%;
                margin-bottom: 0.7rem;
            }
            
            .actions-container {
                flex-direction: column;
            }
            
            .table-elegant thead {
                display: none;
            }
            
            .table-elegant tbody tr {
                display: block;
                margin-bottom: 1.5rem;
                border: 1px solid rgba(0,0,0,0.1);
                border-radius: 8px;
                padding: 1rem;
            }
            
            .table-elegant tbody td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 0.75rem;
                border-bottom: 1px solid rgba(0,0,0,0.05);
            }
            
            .table-elegant tbody td:before {
                content: attr(data-label);
                font-weight: 600;
                color: var(--secondary-color);
                margin-right: 1rem;
            }
            
            .table-elegant tbody td:last-child {
                border-bottom: none;
            }
        }
    </style>
</head>
<body>
    <div class="cart-container">
        <div class="glass-card cart-card">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="page-header mb-0">Mi Carrito</h1>
                    <p class="text-muted mb-0">Revise y modifique su selección</p>
                </div>
                <a href="index.php" class="btn btn-elegant btn-secondary-elegant">
                    <i class="fas fa-chevron-left me-1"></i> Continuar Comprando
                </a>
            </div>
            
            <?php if (empty($_SESSION['carrito'])): ?>
                <div class="empty-cart">
                    <div class="empty-icon"><i class="fas fa-shopping-basket"></i></div>
                    <h3 class="h4 mb-3" style="font-family: 'Cormorant Garamond', serif;">Su carrito está vacío</h3>
                    <p class="text-muted mb-4">Parece que aún no ha añadido ningún producto a su carrito.</p>
                    <a href="index.php" class="btn btn-elegant btn-secondary-elegant">
                         Volver al Menú
                    </a>
                </div>
            <?php else: ?>
                <form method="post" action="actualizar_carrito.php">
                    <div class="table-responsive">
                        <table class="table table-elegant">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th class="text-end">Precio</th>
                                    <th class="text-center">Cantidad</th>
                                    <th class="text-end">Subtotal</th>
                                    <th class="text-center">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $total = 0;
                                foreach ($_SESSION['carrito'] as $indice => $producto):
                                    $subtotal = $producto['precio'] * $producto['cantidad'];
                                    $total += $subtotal;
                                ?>
                                <tr>
                                    <td data-label="Producto">
                                        <span class="product-name"><?php echo htmlspecialchars($producto['nombre']); ?></span>
                                    </td>
                                    <td data-label="Precio" class="text-end">
                                        $<?php echo number_format($producto['precio'], 2); ?>
                                    </td>
                                    <td data-label="Cantidad" class="text-center">
                                        <input type="number" class="quantity-input" 
                                               name="cantidad[<?php echo $indice; ?>]"
                                               value="<?php echo $producto['cantidad']; ?>" min="1">
                                    </td>
                                    <td data-label="Subtotal" class="text-end">
                                        $<?php echo number_format($subtotal, 2); ?>
                                    </td>
                                    <td data-label="Acción" class="text-center">
                                        <a href="eliminar_carrito.php?indice=<?php echo $indice; ?>" 
                                           class="action-btn btn btn-sm btn-danger-elegant"
                                           title="Eliminar">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <tr class="total-row">
                                    <td colspan="3" class="text-end"><strong>Total del Pedido:</strong></td>
                                    <td class="text-end"><strong>$<?php echo number_format($total, 2); ?></strong></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="divider"></div>
                    
                    <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap actions-container">
                        <button type="submit" name="actualizar" class="btn-elegant btn-primary-elegant">
                            <i class="fas fa-redo-alt me-2"></i> Actualizar Carrito
                        </button>
                        <div class="d-flex gap-3 flex-wrap">
                            <a href="vaciar_carrito.php" class="btn-elegant btn-danger-elegant">
                                <i class="fas fa-trash-alt me-2"></i> Vaciar Todo
                            </a>
                            <a href="confirmar_pedido.php" class="btn-elegant btn-secondary-elegant">
                                <i class="fas fa-check-circle me-2"></i> Finalizar Compra
                            </a>
                        </div>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>