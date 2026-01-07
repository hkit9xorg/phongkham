<?php
require_once __DIR__ . '/../helpers/Env.php';
Env::load();

$title = 'Giới thiệu phòng khám';
$isHomePage = false;

ob_start();
include __DIR__ . '/../views/about.php';
$content = ob_get_clean();
include __DIR__ . '/../views/layout.php';
