<?php
ob_start();
session_start();
include 'config.php';
requerirAdmin();

if (isset($_GET['eliminar'])) {
    $id_producto = (int)$_GET['eliminar'];

    try {
        $stmt = $conn->prepare("DELETE FROM productos WHERE id_producto = ?");
        $stmt->execute([$id_producto]);

        if ($stmt->rowCount() > 0) {
            $_SESSION['mensaje'] = "Producto eliminado correctamente.";
            $_SESSION['mensaje_tipo'] = "exito";
        } else {
            $_SESSION['mensaje'] = "No se encontró el producto.";
            $_SESSION['mensaje_tipo'] = "error";
        }

        header("Location: admin_productos.php");
        exit;
    } catch (PDOException $e) {
        $_SESSION['mensaje'] = "Error: " . $e->getMessage();
        $_SESSION['mensaje_tipo'] = "error";
        header("Location: admin_productos.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Productos - Tienda Shiro</title>
    
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
            --success-color: #4CAF50;
            --error-color: #f44336;
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
        
        .admin-section {
            background: white;
            border-radius: 0;
            padding: 2rem;
            margin-bottom: 2rem;
            border: 1px solid rgba(0,0,0,0.05);
        }
        
        .admin-header {
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
        
        .btn-admin {
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
        
        .btn-primary-admin {
            background-color: var(--primary-color);
            color: var(--light-color);
            border: 1px solid var(--primary-color);
        }
        
        .btn-primary-admin:hover {
            background-color: #333;
            color: var(--secondary-color);
        }
        
        .btn-secondary-admin {
            background-color: var(--secondary-color);
            color: var(--primary-color);
            border: 1px solid var(--secondary-color);
        }
        
        .btn-secondary-admin:hover {
            background-color: var(--primary-color);
            color: var(--secondary-color);
            border-color: var(--primary-color);
        }
        
        .btn-danger-admin {
            background-color: var(--error-color);
            color: white;
            border: 1px solid var(--error-color);
        }
        
        .btn-danger-admin:hover {
            background-color: #d32f2f;
            border-color: #d32f2f;
        }
        
        .product-image {
            max-width: 80px;
            max-height: 60px;
            border-radius: 4px;
            border: 1px solid #eee;
        }
        
        .mensaje {
            padding: 1rem;
            margin-bottom: 1.5rem;
            border-radius: 0.45rem;
            font-weight: 500;
        }
        
        .mensaje-exito {
            background-color: rgba(76, 175, 80, 0.1);
            color: var(--success-color);
            border-left: 3px solid var(--success-color);
        }
        
        .mensaje-error {
            background-color: rgba(244, 67, 54, 0.1);
            color: var(--error-color);
            border-left: 3px solid var(--error-color);
        }
        
        .file-input-label {
            display: block;
            padding: 1rem;
            border: 2px dashed #ddd;
            border-radius: 0.45rem;
            text-align: center;
            cursor: pointer;
            transition: all var(--transition-speed);
            background-color: rgba(201, 166, 107, 0.05);
            position: relative;
            overflow: hidden;
        }
        
        .file-input-label:hover {
            border-color: var(--secondary-color);
            background-color: rgba(201, 166, 107, 0.1);
        }
        
        .form-control, .form-select, .form-check-input {
            border-radius: 0.45rem;
            padding: 0.75rem;
            border: 1px solid #ddd;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 0.25rem rgba(201, 166, 107, 0.25);
        }
        
        .form-check-input:checked {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        
        .table th {
            background-color: var(--primary-color);
            color: var(--text-light);
            font-weight: 500;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
        }
        
        .table td {
            vertical-align: middle;
        }
        
        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }
        
        .image-preview {
            transition: all 0.3s ease;
        }
        
        #preview-image {
            max-width: 150px;
            max-height: 150px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        @media (max-width: 768px) {
            .admin-section {
                padding: 1.5rem;
            }
            
            .btn-admin {
                width: 100%;
                margin-bottom: 0.5rem;
            }
            
            .action-buttons {
                flex-direction: column;
            }
            
            .table-responsive {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }
            
            .table th, .table td {
                padding: 0.75rem;
                font-size: 0.9rem;
            }
            
            .product-image {
                max-width: 60px;
                max-height: 45px;
            }
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Administrar Productos</h1>
            <a href="index.php" class="btn btn-sm btn-secondary-admin">
                <i class="fas fa-arrow-left me-1"></i> Inicio
            </a>
        </div>

        <?php
        // Mostrar mensajes
        if (isset($_SESSION['mensaje'])) {
            echo '<div class="mensaje mensaje-'.$_SESSION['mensaje_tipo'].'">'.$_SESSION['mensaje'].'</div>';
            unset($_SESSION['mensaje']);
            unset($_SESSION['mensaje_tipo']);
        }

        // Procesar formulario de agregar/editar producto
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_producto = isset($_POST['id_producto']) ? (int)$_POST['id_producto'] : 0;
            $nombre = trim($_POST['nombre']);
            $descripcion = trim($_POST['descripcion']);
            $precio = (float)$_POST['precio'];
            $stock = (int)$_POST['stock'];
            $destacado = isset($_POST['destacado']) ? 1 : 0;
            $categoria = $_POST['categoria'];
            
            // Validar campos requeridos
            if (empty($nombre) || empty($descripcion) || empty($categoria)) {
                $_SESSION['mensaje'] = "Todos los campos son obligatorios.";
                $_SESSION['mensaje_tipo'] = "error";
                header("Location: admin_productos.php");
                exit;
            }
            
            // Проверка для новых товаров
            if ($id_producto == 0 && (!isset($_FILES['imagen']) || $_FILES['imagen']['error'] != 0)) {
                $_SESSION['mensaje'] = "Debe subir una imagen para el producto.";
                $_SESSION['mensaje_tipo'] = "error";
                header("Location: admin_productos.php");
                exit;
            }
            
            // Procesar imagen
            $imagen = '';
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
                $target_dir = "imagenes/";
                $imageFileType = strtolower(pathinfo($_FILES["imagen"]["name"], PATHINFO_EXTENSION));
                
                // Проверка типа файла
                $check = getimagesize($_FILES["imagen"]["tmp_name"]);
                if ($check === false) {
                    $_SESSION['mensaje'] = "El archivo no es una imagen válida.";
                    $_SESSION['mensaje_tipo'] = "error";
                    header("Location: admin_productos.php");
                    exit;
                }

                // Генерация уникального имени
                $imagen = uniqid() . '.' . $imageFileType;
                $target_file = $target_dir . $imagen;
                
                // Mover el archivo subido
                if (!move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file)) {
                    $_SESSION['mensaje'] = "Hubo un error al subir la imagen.";
                    $_SESSION['mensaje_tipo'] = "error";
                    header("Location: admin_productos.php");
                    exit;
                }
            } elseif ($id_producto > 0) {
                // Mantener la imagen existente al editar
                $stmt = $conn->prepare("SELECT imagen FROM productos WHERE id_producto = ?");
                $stmt->execute([$id_producto]);
                $producto = $stmt->fetch(PDO::FETCH_ASSOC);
                $imagen = $producto['imagen'];
            }
            
            $fecha_creacion = date('Y-m-d H:i:s');
            
            try {
                if ($id_producto > 0) {
                    // Actualizar producto existente
                    $stmt = $conn->prepare("UPDATE productos SET 
                        nombre = ?, 
                        descripcion = ?, 
                        precio = ?, 
                        stock = ?,
                        imagen = ?,
                        destacado = ?,
                        categoria = ?
                        WHERE id_producto = ?");
                    $stmt->execute([
                        $nombre, 
                        $descripcion, 
                        $precio, 
                        $stock,
                        $imagen,
                        $destacado,
                        $categoria,
                        $id_producto
                    ]);
                    $_SESSION['mensaje'] = "Producto actualizado correctamente.";
                    $_SESSION['mensaje_tipo'] = "exito";
                } else {
                    // Insertar nuevo producto
                    $stmt = $conn->prepare("INSERT INTO productos (
                        nombre, 
                        descripcion, 
                        precio, 
                        stock,
                        imagen,
                        destacado,
                        fecha_creacion,
                        categoria
                    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->execute([
                        $nombre, 
                        $descripcion, 
                        $precio, 
                        $stock,
                        $imagen,
                        $destacado,
                        $fecha_creacion,
                        $categoria
                    ]);
                    $_SESSION['mensaje'] = "Producto agregado correctamente.";
                    $_SESSION['mensaje_tipo'] = "exito";
                }
                
                header("Location: admin_productos.php");
                exit;
            } catch (PDOException $e) {
                $_SESSION['mensaje'] = "Error al guardar el producto: " . $e->getMessage();
                $_SESSION['mensaje_tipo'] = "error";
                header("Location: admin_productos.php");
                exit;
            }
        }
        
        // Verificar si estamos editando un producto
        $editar_producto = null;
        if (isset($_GET['editar'])) {
            $id_producto = (int)$_GET['editar'];
            $stmt = $conn->prepare("SELECT * FROM productos WHERE id_producto = ?");
            $stmt->execute([$id_producto]);
            $editar_producto = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$editar_producto) {
                $_SESSION['mensaje'] = "No se encontró el producto a editar.";
                $_SESSION['mensaje_tipo'] = "error";
                header("Location: admin_productos.php");
                exit;
            }
        }
        ?>

        <!-- Sección de Formulario -->
        <section class="admin-section">
            <div class="admin-header">
                <h2 class="h4"><?php echo $editar_producto ? 'Editar Producto' : 'Agregar Nuevo Producto'; ?></h2>
                <p class="mb-0 text-muted"><?php echo $editar_producto ? 'Modifica los datos del producto' : 'Completa el formulario para agregar un nuevo producto'; ?></p>
            </div>
            
            <form method="post" enctype="multipart/form-data">
                <?php if ($editar_producto): ?>
                    <input type="hidden" name="id_producto" value="<?php echo $editar_producto['id_producto']; ?>">
                <?php endif; ?>
                
                <div class="mb-3">
                    <label for="nombre" class="form-label info-label">Nombre del Producto</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required 
                           value="<?php echo isset($editar_producto['nombre']) ? htmlspecialchars($editar_producto['nombre']) : ''; ?>">
                </div>
                
                <div class="mb-3">
                    <label for="descripcion" class="form-label info-label">Descripción</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required><?php 
                        echo isset($editar_producto['descripcion']) ? htmlspecialchars($editar_producto['descripcion']) : ''; 
                    ?></textarea>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="precio" class="form-label info-label">Precio</label>
                        <input type="number" class="form-control" id="precio" name="precio" step="0.01" min="0" required 
                               value="<?php echo isset($editar_producto['precio']) ? $editar_producto['precio'] : ''; ?>">
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="stock" class="form-label info-label">Stock</label>
                        <input type="number" class="form-control" id="stock" name="stock" min="0" required 
                               value="<?php echo isset($editar_producto['stock']) ? $editar_producto['stock'] : ''; ?>">
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="categoria" class="form-label info-label">Categoría</label>
                    <select class="form-select" id="categoria" name="categoria" required>
                        <option value="">Seleccione una categoría</option>
                        <option value="Calzado" <?php if (isset($editar_producto['categoria']) && $editar_producto['categoria'] == 'Calzado') echo 'selected'; ?>>Calzado</option>
                        <option value="Accesorios" <?php if (isset($editar_producto['categoria']) && $editar_producto['categoria'] == 'Accesorios') echo 'selected'; ?>>Accesorios</option>
                        <option value="Tecnología" <?php if (isset($editar_producto['categoria']) && $editar_producto['categoria'] == 'Tecnología') echo 'selected'; ?>>Tecnología</option>
                        <option value="Hogar" <?php if (isset($editar_producto['categoria']) && $editar_producto['categoria'] == 'Hogar') echo 'selected'; ?>>Hogar</option>
                        <option value="Comida" <?php if (isset($editar_producto['categoria']) && $editar_producto['categoria'] == 'Comida') echo 'selected'; ?>>Comida</option>
                        <option value="Casa" <?php if (isset($editar_producto['categoria']) && $editar_producto['categoria'] == 'Casa') echo 'selected'; ?>>Casa</option>
                        <option value="Ropa" <?php if (isset($editar_producto['categoria']) && $editar_producto['categoria'] == 'Ropa') echo 'selected'; ?>>Ropa</option>
                        <option value="Zapatos" <?php if (isset($editar_producto['categoria']) && $editar_producto['categoria'] == 'Zapatos') echo 'selected'; ?>>Zapatos</option>
                        <option value="Juguete" <?php if (isset($editar_producto['categoria']) && $editar_producto['categoria'] == 'Juguete') echo 'selected'; ?>>Juguete</option>
                    </select>
                </div>
                
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="destacado" name="destacado" value="1"
                        <?php if (isset($editar_producto['destacado']) && $editar_producto['destacado'] == 1) echo 'checked'; ?>>
                    <label class="form-check-label" for="destacado">Producto destacado</label>
                </div>
                
                <!-- En la sección del formulario, modifica el input de la imagen así: -->
<div class="mb-4">
    <label class="form-label info-label">Imagen del Producto</label>
    <label for="imagen" class="file-input-label">
        <i class="fas fa-cloud-upload-alt me-2"></i>
        <span id="file-name"><?php echo isset($editar_producto['imagen']) ? 'Cambiar imagen (opcional)' : 'Seleccionar archivo (requerido)'; ?></span>
        <input type="file" id="imagen" name="imagen" accept="image/*" class="d-none" <?php echo !isset($editar_producto) ? 'required' : ''; ?>>
    </label>
    <?php if (isset($editar_producto['imagen']) && $editar_producto['imagen']): ?>
        <div class="mt-3">
            <p class="mb-2">Imagen actual:</p>
            <img src="imagenes/<?php echo htmlspecialchars($editar_producto['imagen']); ?>" alt="Imagen actual" class="product-image">
        </div>
    <?php endif; ?>
    <div class="image-preview mt-3" id="image-preview-container" style="display: none;">
        <p class="mb-2">Vista previa:</p>
        <img id="preview-image" class="product-image">
    </div>
</div>
                <div class="d-flex gap-2 flex-wrap">
                    <button type="submit" class="btn-admin btn-primary-admin">
                        <i class="fas fa-save me-1"></i>
                        <?php echo $editar_producto ? 'Actualizar Producto' : 'Agregar Producto'; ?>
                    </button>
                    
                    <?php if ($editar_producto): ?>
                        <a href="admin_productos.php" class="btn-admin btn-secondary-admin">
                            <i class="fas fa-times me-1"></i> Cancelar
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </section>

        <!-- Sección de Lista de Productos -->
        <section class="admin-section">
            <div class="admin-header">
                <h2 class="h4">Lista de Productos</h2>
                <p class="mb-0 text-muted">Todos los productos disponibles en la tienda</p>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th>Imagen</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stmt = $conn->query("SELECT * FROM productos ORDER BY id_producto");
                        
                        while ($producto = $stmt->fetch(PDO::FETCH_ASSOC)):
                        ?>
                            <tr>
                                <td><?php echo $producto['id_producto']; ?></td>
                                <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                                <td>$<?php echo number_format($producto['precio'], 2); ?></td>
                                <td><?php echo $producto['stock']; ?></td>
                                <td>
                                    <?php if ($producto['imagen']): ?>
                                        <img src="imagenes/<?php echo htmlspecialchars($producto['imagen']); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>" class="product-image">
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="admin_productos.php?editar=<?php echo $producto['id_producto']; ?>" class="btn-admin btn-secondary-admin btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="admin_productos.php?eliminar=<?php echo $producto['id_producto']; ?>" class="btn-admin btn-danger-admin btn-sm" onclick="return confirm('¿Estás seguro de eliminar este producto?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
    
    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
    // Mostrar nombre de archivo seleccionado y vista previa
   document.getElementById('imagen').addEventListener('change', function(e) {
    const fileName = e.target.files[0]?.name || (<?php echo isset($editar_producto) ? "'Cambiar imagen (opcional)'" : "'Seleccionar archivo (requerido)'"; ?>);
    document.getElementById('file-name').textContent = fileName;
        
        // Mostrar vista previa si es una nueva imagen
        if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const previewContainer = document.getElementById('image-preview-container');
                const previewImage = document.getElementById('preview-image');
                
                previewImage.src = event.target.result;
                previewContainer.style.display = 'block';
            }
            reader.readAsDataURL(e.target.files[0]);
        }
    });

    
    // Confirmación antes de eliminar
    document.querySelectorAll('.btn-danger-admin').forEach(btn => {
        btn.addEventListener('click', function(e) {
            if (!confirm('¿Estás seguro de eliminar este producto?\nEsta acción no se puede deshacer.')) {
                e.preventDefault();
            }
        });
    });
    
    // Validación del formulario
    document.querySelector('form').addEventListener('submit', function(e) {
        const nombre = document.getElementById('nombre').value.trim();
        const descripcion = document.getElementById('descripcion').value.trim();
        const precio = document.getElementById('precio').value;
        const stock = document.getElementById('stock').value;
        const categoria = document.getElementById('categoria').value;
        
        if (!nombre || !descripcion || !precio || !stock || !categoria) {
            alert('Todos los campos son obligatorios');
            e.preventDefault();
            return false;
        }
        
        <?php if (!isset($editar_producto)): ?>
        if (document.getElementById('imagen').files.length === 0) {
            alert('Debe seleccionar una imagen para el producto');
            e.preventDefault();
            return false;
        }
        <?php endif; ?>
    });
    </script>
    <?php ob_end_flush(); ?>
</body>
</html>
