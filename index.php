<?php include 'config.php';?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Descubre los mejores productos en la tienda online Shiro. Compra segura, envíos rápidos y atención personalizada. ¡Tu satisfacción garantizada!">
    <title>Tienda online Shiro</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- Google Ads -->
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7072861211555240" crossorigin="anonymous"></script>
    
    <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-KMWS6QEVKZ"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'G-KMWS6QEVKZ');
    </script>
    
    <style>
        :root {
    --primary-color: #1a1a1a;
    --secondary-color: #c9a66b;
    --light-color: #f8f5f0;
    --text-color: #333;
    --text-light: #e8d8b8;
    --success-color: #4CAF50;
    --error-color: #f44336;
    --transition-speed: 0.3s;
}


        body {
            font-family: 'Montserrat', sans-serif;
            background-color: var(--light-color);
        }
        
        h1, h2, h3 {
            font-family: 'Playfair Display', serif;
        }
        
        .header {
            background-color: var(--primary-color);
            color: var(--text-light);
            padding: 1rem 0;
            margin-bottom: 2rem;
            border-bottom: 3px solid var(--secondary-color);
        }
        
        .carrito-link {
            background-color: var(--secondary-color);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.45rem;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            
        }
        
        .carrito-link:hover {
            background-color: var(--primary-color);
            color: var(--secondary-color);
            transform: translateY(-2px);
        }
        
        .admin-button {
            background-color: #d9534f;
            color: white;
            padding: 0.5rem 1rem;
             border-radius: 0.45rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .admin-button:hover {
            background-color: #c9302c;
            color: white;
        }
        
        .producto-card {
            height: 300px;
            transition: transform 0.3s ease;
            border: 1px solid rgba(0,0,0,0.1);
            border-radius: 0.5rem;
            overflow: hidden;
        }
        
        .producto-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        .producto-imagen-container {
            width: auto;
            height: 350px;
            overflow: hidden;
        }
        
        .producto-imagen-container img {
            width: 100%;
            height: auto;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        
        .producto-descripcion {
            color: #666;
            font-size: 0.9rem;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            height: 60px;
        }
        .mb-0{
            font-family: 'Montserrat', serif;

        }
        .producto-precio {
            font-weight: 600;
            color: var(--primary-color);
            font-size: 1.2rem;
            margin: 0.5rem 0;
        }
        .btn, .carrito-link{
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
        .btn-agregar {
            background-color: var(--secondary-color);
            color: var(--primary-color);
            font-weight: 550;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.55rem;
        }
        
        .btn-agregar:hover {
            background-color: var(--primary-color);
            color: var(--text-light);
        }
        
        .user-nav {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            justify-content: flex-end;
        }
        .mb-3{
            text-align: center;
            justify-content: center;
            color: #666;
        }
        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .user-nav {
                width: 100%;
                margin-top: 1rem;
                justify-content: center;
            }
            
            .producto-imagen-container {
                height: auto;
                width: 100%;
            }
        }
        .card {
  border-radius: 1rem;
}

.form-label {
    
    font-weight: 500;
    transition: all var(--transition-speed);
    text-transform: uppercase;
    font-size: 0.8rem;
    letter-spacing: 0.5px;
    display: inline-flex;
  
}
.btn-secondary{
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
.btn-secondary{
    background-color: black;
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 0.45rem;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}
input::placeholder {
  color: #aaa;
  font-style: italic;
}

    </style>
</head>
<body>
    <div class="container-fluid px-0">
        <div class="header">
            <div class="container">
                <div class="d-flex flex-wrap justify-content-between align-items-center header-content">
                    <h1 class="mb-0">Tienda Shiro</h1>
                    
                    <div class="user-nav">
                        <?php if (estaAutenticado()): ?>
                            <?php if (esAdmin()): ?>
                                <a href="admin_productos.php" class="admin-button">
                                    <i class="fas fa-cog"></i> Panel Admin
                                </a>
                            <?php endif; ?>
                            <a href="perfil.php" class="carrito-link">
                                <i class="fas fa-user"></i> Mi perfil
                            </a>
                            <a href="logout.php" class="carrito-link">
                                <i class="fas fa-sign-out-alt"></i> Salir
                            </a>
                        <?php else: ?>
                            <a href="login.php" class="carrito-link">
                                <i class="fas fa-sign-in-alt"></i> Ingresar
                            </a>
                            <a href="register.php" class="carrito-link">
                                <i class="fas fa-user-plus"></i> Registrarse
                            </a>
                        <?php endif; ?>
                        
                        <a href="carrito.php" class="carrito-link">
                            <i class="fas fa-shopping-cart"></i>Carrito (<?php echo count($_SESSION['carrito']); ?>)
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <main class="container my-4">
            <h2 class="mb-3 ">Nuestros Productos Destacados</h2>
            <?php if (isset($_SESSION['mensaje'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['mensaje']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['mensaje']); ?>
<?php endif; ?>

            <form method="GET" class="mb-4">
    <div class="row g-3 align-items-end">
        <div class="col-md-4">
            <label for="categoria" class="form-label">Categoría</label>
            <select name="categoria" id="categoria" class="form-select">
                <option value="">Todas</option>
                <option value="Ropa" <?= ($_GET['categoria'] ?? '') == 'Ropa' ? 'selected' : '' ?>>Ropa</option>
                <option value="Accesorios" <?= ($_GET['categoria'] ?? '') == 'Accesorios' ? 'selected' : '' ?>>Accesorios</option>
                <option value="Hogar" <?= ($_GET['categoria'] ?? '') == 'Hogar' ? 'selected' : '' ?>>Hogar</option>
                <option value="Tecnología" <?= ($_GET['categoria'] ?? '') == 'Tecnología' ? 'selected' : '' ?>>Tecnología</option>
                <option value="Comida" <?= ($_GET['categoria'] ?? '') == 'Comida' ? 'selected' : '' ?>>Comida</option>
                <option value="Casa" <?= ($_GET['categoria'] ?? '') == 'Casa' ? 'selected' : '' ?>>Casa</option>
                <option value="Ropa" <?= ($_GET['categoria'] ?? '') == 'Ropa' ? 'selected' : '' ?>>Ropa</option>
                <option value="Zapatos" <?= ($_GET['categoria'] ?? '') == 'Zapatos' ? 'selected' : '' ?>>Zapatos</option>
                <option value="Juguete" <?= ($_GET['categoria'] ?? '') == 'Juguete' ? 'selected' : '' ?>>Juguete</option>
            </select>
        </div>
        
        <div class="col-md-3">
            <label for="precio_max" class="form-label">Precio máximo</label>
            <input type="number" name="precio_max" id="precio_max" class="form-control" 
                   placeholder="Ej: 1000" value="<?= htmlspecialchars($_GET['precio_max'] ?? '') ?>">
        </div>
        
        <div class="col-md-3">
            <label for="buscar" class="form-label">Buscar por nombre</label>
            <input type="text" name="buscar" id="buscar" class="form-control" 
                   placeholder="Nombre del producto" value="<?= htmlspecialchars($_GET['buscar'] ?? '') ?>">
        </div>
        <div class="col-md-2 d-grid">
  <button type="submit" class="btn btn-secondary mb-2">
    <i class="fas fa-filter me-1"></i> Filtrar
  </button>
  <a href="index.php" class="btn btn-secondary">
    <i class="fas fa-times me-1"></i> Limpiar
  </a>
</div>

    </div>
</form>
<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                <?php
                $stmt = $conn->query("SELECT * FROM productos");
$where = [];
$params = [];

if (!empty($_GET['categoria'])) {
    $where[] = "categoria = :categoria";
    $params[':categoria'] = $_GET['categoria'];
}

if (!empty($_GET['precio_max'])) {
    $where[] = "precio <= :precio_max";
    $params[':precio_max'] = $_GET['precio_max'];
}

if (!empty($_GET['buscar'])) {
    $where[] = "nombre LIKE :buscar";
    $params[':buscar'] = "%" . $_GET['buscar'] . "%";
}

$sql = "SELECT * FROM productos";
if ($where) {
    $sql .= " WHERE " . implode(" AND ", $where);
}

$stmt = $conn->prepare($sql);
$stmt->execute($params);

                while ($producto = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo '<div class="col">';
                    echo '<div class="card producto-card h-100">';
                    echo '<div class="producto-imagen-container">';
                    echo '<img src="imagenes/' . $producto['imagen'] . '" class="card-img-top" alt="' . htmlspecialchars($producto['nombre']) . '" loading="lazy">';
                    echo '</div>';
                    echo '<div class="card-body d-flex flex-column">';
                    echo '<h3 class="card-title">' . htmlspecialchars($producto['nombre']) . '</h3>';
                    echo '<p class="card-text producto-descripcion">' . htmlspecialchars($producto['descripcion']) . '</p>';
                    echo '<div class="producto-precio mt-auto">$' . number_format($producto['precio'], 2) . '</div>';
                    echo '<form method="post" action="agregar_al_carrito.php" class="mt-2">';
                    echo '<input type="hidden" name="id_producto" value="' . $producto['id_producto'] . '">';
                    echo '<button type="submit" class="btn btn-agregar">';
                    echo ' Agregar';
                    echo '</button>';
                    echo '</form>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
                ?>
            </div>
        </main>
    </div>
    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</body>
</html>