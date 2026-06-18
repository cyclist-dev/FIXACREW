<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();


require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/app.php';


$pagina = $_GET['page'] ?? 'home';


if ($pagina === 'api/crews') {
    $api = new \App\Controllers\ApiController();
    $api->crews();
    exit;
}

// rotas tabeladas com nomespace
$rotas = [
    'home'     => ['App\Controllers\CrewController', 'index'],
    'crew'     => ['App\Controllers\CrewController', 'show'],
    'map'      => ['App\Controllers\CrewController', 'map'],
    'register' => ['App\Controllers\CrewController', 'create'],
    'login'    => ['App\Controllers\AuthController', 'loginForm'],
    'logout'   => ['App\Controllers\AuthController', 'logout'],
    'admin'    => ['App\Controllers\AuthController', 'dashboard'],
];

// não encontrou a rota
if (!array_key_exists($pagina, $rotas)) {
    http_response_code(404);
    require_once __DIR__ . '/../views/404.php';
    exit;
}


[$classe, $metodo] = $rotas[$pagina];
(new $classe())->$metodo();