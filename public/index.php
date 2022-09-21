<?php

use App\Config;
use App\Router;
use App\Controllers;
use App\Controllers\Api;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

const VIEW_PATH = __DIR__ . '/../views';
const LAYOUT_VIEW_PATH = __DIR__ . '/../views' . '/layout.php';


$router = new App\Router();
$routerAPI = new App\RouterAPI();

$router
    ->get('/', [Controllers\UserController::class, 'index'])
    ->get('/create', [Controllers\UserController::class, 'create'])
    ->get('/auth', [Controllers\UserController::class, 'auth'])
    ->get('/update', [Controllers\UserController::class, 'update'])
    ->post('/upgrade', [Controllers\UserController::class, 'upgrade'])
    ->post('/login', [Controllers\UserController::class, 'login'])
    ->post('/store', [Controllers\UserController::class, 'store']);



$routerAPI
    ->get('/api', [App\Controllers\Api\HomeController::class, 'checkAPI']);




(new App\App($router, $routerAPI,
    [
        'uri' => $_SERVER['REQUEST_URI'],
        'method' => $_SERVER['REQUEST_METHOD'],
    ],
    new Config($_ENV)

))->run();

