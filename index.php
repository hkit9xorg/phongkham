<?php
session_start();
$page = $_GET['page'] ?? 'home';

switch ($page) {
    case 'login':
        require __DIR__ . '/controllers/LoginController.php';
        break;
    case 'register':
        require __DIR__ . '/controllers/RegisterController.php';
        break;
    case 'dashboard':
        require __DIR__ . '/controllers/DashboardController.php';
        break;
    case 'logout':
        session_destroy();
        header('Location: /index.php');
        exit;
    case 'home':
    default:
        require __DIR__ . '/controllers/HomeController.php';
        break;
}
