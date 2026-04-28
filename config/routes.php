<?php

declare(strict_types=1);

use App\Controller\CategoryController;
use App\Controller\IndexController;
use App\Controller\PostController;
use App\Http\Router;
use Smarty\Smarty;

return function (Router $router, PDO $pdo, Smarty $smarty): void
{
    $index = new IndexController($pdo, $smarty);
    $category = new CategoryController($pdo, $smarty);
    $post = new PostController($pdo, $smarty);

    $router->get('/', [$index, 'index']);
    $router->get('/category/{id}', [$category, 'show']);
    $router->get('/post/{id}', [$post, 'show']);

    $router->setNotFoundHandler(function () use ($smarty) {
        $smarty->display('404.tpl');
    });
};
