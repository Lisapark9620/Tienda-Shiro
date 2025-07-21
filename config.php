<?php

// Configuración de reporte de errores
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/php_errors.log');

// Configuración de zona horaria
date_default_timezone_set('America/Mexico_City');
// Configuración de la base de datos
$host = 'sql310.infinityfree.com';
$dbname = 'if0_39279617_tiendaonline1';
$username = 'if0_39279617';
$password = 'nQaRrO5WLY1fiO';

// Configuración de sesión segura
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1); // Solo si estás usando HTTPS
ini_set('session.use_strict_mode', 1);
// Генерация CSRF-токена
function generateCsrfToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Проверка CSRF-токена
function verifyCsrfToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Iniciar sesión
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Проверка авторизации пользователя
function estaAutenticado() {
    return isset($_SESSION['usuario']);
}

function esAdmin() {
    return estaAutenticado() && $_SESSION['usuario']['rol'] === 'admin';
}

// Хеширование паролей
function hashPassword($password) {
    return password_hash($password, PASSWORD_BCRYPT);
} 
// После инициализации сессии
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = array();
}

// Проверка авторизации для защищенных страниц
function requerirAutenticacion() {
    if (!estaAutenticado()) {
        header('Location: login.php');
        exit();
    }
}

function requerirAdmin() {
    requerirAutenticacion();
    if (!esAdmin()) {
        header('Location: index.php');
        exit();
    }
}
// Regenerar ID de sesión periódicamente
if (!isset($_SESSION['created'])) {
    $_SESSION['created'] = time();
} elseif (time() - $_SESSION['created'] > 1800) {
    session_regenerate_id(true);
    $_SESSION['created'] = time();
}

// Inicializar carrito
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = array();
}

// Conexión a la base de datos
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    error_log("Error de conexión: " . $e->getMessage());
    die("Error al conectar con la base de datos. Por favor, inténtelo más tarde.");
}

// Función para escapar datos
function clean_input($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}
function obtenerEstadoPedido($estado) {
    $estados = [
        'pendiente' => 'Pendiente',
        'completado' => 'Completado',
        'cancelado' => 'Cancelado',
        'en_proceso' => 'En proceso',
        'enviado' => 'Enviado'
    ];
    
    return $estados[strtolower($estado)] ?? ucfirst($estado);
}
?>