<?php
require_once __DIR__ . '/../helpers/Env.php';

Env::load();

$driver = Env::get('DB_CONNECTION', 'mysql');
$host = Env::get('DB_HOST', '127.0.0.1');
$port = Env::get('DB_PORT', '3306');
$db = Env::get('DB_DATABASE', 'tintuc');
$user = Env::get('DB_USERNAME', 'tintuc');
$pass = Env::get('DB_PASSWORD', '');

$dsn = sprintf('%s:host=%s;port=%s;dbname=%s;charset=utf8mb4', $driver, $host, $port, $db);

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    http_response_code(500);
    die('Database connection failed: ' . htmlspecialchars($e->getMessage()));
}
