<?php include "config.php"; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido Confirmado - Restaurante Gourmet</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600&family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #1a1a1a;
            --secondary-color: #c9a66b;
            --light-color: #f8f5f0;
            --text-color: #333;
            --text-light: #e8d8b8;
            --success-color: #2ecc71;
        }
        
        body {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--light-color);
            color: var(--text-color);
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 40px;
            text-align: center;
        }
        
        .confirmacion {
            background: white;
            padding: 50px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            position: relative;
            overflow: hidden;
        }
        
        .confirmacion::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--secondary-color), var(--primary-color));
        }
        
        .icono {
            width: 80px;
            height: 80px;
            background-color: var(--success-color);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            margin: 0 auto 25px;
            box-shadow: 0 5px 15px rgba(46, 204, 113, 0.3);
        }
        
        h1 {
            font-family: 'Playfair Display', serif;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 20px;
            font-size: 2.5rem;
        }
        
        p {
            font-size: 1.1rem;
            margin-bottom: 15px;
            color: #555;
        }
        
        .numero-pedido {
            font-family: 'Montserrat', sans-serif;
            font-size: 2rem;
            font-weight: 600;
            color: var(--secondary-color);
            margin: 20px 0;
            padding: 15px;
            background-color: var(--light-color);
            border-radius: 5px;
            display: inline-block;
            min-width: 200px;
            letter-spacing: 2px;
        }
        
        button {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 5px;
            font-family: 'Montserrat', sans-serif;
            font-weight: 500;
            font-size: 1rem;
            cursor: pointer;
            margin-top: 30px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        button::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: 0.5s;
        }
        
        button:hover {
            background-color: #333;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        button:hover::after {
            left: 100%;
        }
        
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }
            
            .confirmacion {
                padding: 30px 20px;
            }
            
            h1 {
                font-size: 2rem;
            }
            
            .numero-pedido {
                font-size: 1.5rem;
                min-width: 150px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="confirmacion">
            <div class="icono">✓</div>
            <h1>¡Pedido Confirmado!</h1>
            <p>Gracias por elegir nuestra tienda.</p>
            
            <?php if (isset($_GET['id'])): ?>
                <p>Tu número de pedido es:</p>
                <div class="numero-pedido">#<?php echo htmlspecialchars($_GET['id']); ?></div>
                <p> Hemos recibido tu pedido y lo estamos procesando.</p>
                <p>Recibirás una confirmación por correo electrónico.</p>
            <?php endif; ?>
            
            <button onclick="location.href='index.php'">Volver al Menú Principal</button>
        </div>
    </div>
</body>
</html>