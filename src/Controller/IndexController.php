<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\CategoryRepository;
use PDO;
use Smarty\Smarty;

class IndexController
{
    public function __construct(
        private PDO $pdo,
        private Smarty $smarty,
    )
    {}

    public function index(): void
    {
        $repository = new CategoryRepository($this->pdo);
        $categories = $repository->findAllWithLatestPosts();

        $this->smarty->assign('categories', $categories);
        $this->smarty->display('home.tpl');
    }
}
