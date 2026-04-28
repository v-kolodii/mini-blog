<?php

declare(strict_types=1);

namespace App\Controller;

use PDO;
use Smarty\Smarty;

class CategoryController
{
    public function __construct(
        private PDO $pdo,
        private Smarty $smarty,
    )
    {}

    public function show(string $id): void
    {
        $this->smarty->assign('message', "Hello from CategoryController, id={$id}");
        $this->smarty->display('category.tpl');
    }
}
