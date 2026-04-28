<?php

declare(strict_types=1);

namespace App\Controller;

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
        $this->smarty->assign('message', 'Hello from IndexController');
        $this->smarty->display('home.tpl');
    }
}
