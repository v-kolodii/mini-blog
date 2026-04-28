<?php

declare(strict_types=1);

require __DIR__ . '/../config/bootstrap.php';

/** @var PDO $pdo */
/** @var Smarty\Smarty $smarty */

$router = new App\Http\Router();

$registerRoutes = require __DIR__ . '/../config/routes.php';
$registerRoutes($router, $pdo, $smarty);

$router->dispatch($_SERVER['REQUEST_URI']);
