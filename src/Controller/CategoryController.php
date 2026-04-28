<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use App\Service\Paginator;
use PDO;
use Smarty\Smarty;

class CategoryController
{
    private const PER_PAGE = 2;
    private const ALLOWED_SORTS = ['date', 'views'];

    public function __construct(
        private readonly PDO $pdo,
        private readonly Smarty $smarty,
    ) {}

    public function show(string $id): void
    {
        $categoryId = (int) $id;

        $categoryRepo = new CategoryRepository($this->pdo);
        $category = $categoryRepo->findById($categoryId);

        if ($category === null) {
            http_response_code(404);
            $this->smarty->display('404.tpl');

            return;
        }

        $sort = $_GET['sort'] ?? PostRepository::DEFAULT_SORT;
        if (!isset(PostRepository::ALLOWED_SORTS[$sort])) {
            $sort = PostRepository::DEFAULT_SORT;
        }

        $page = max(1, (int) ($_GET['page'] ?? 1));

        $postRepo = new PostRepository($this->pdo);
        $totalPosts = $postRepo->countByCategory($categoryId);
        $paginator = new Paginator($totalPosts, $page, self::PER_PAGE);
        $posts = $postRepo->findByCategory($categoryId, $sort, $paginator->perPage, $paginator->offset);

        $this->smarty->assign('category', $category);
        $this->smarty->assign('posts', $posts);
        $this->smarty->assign('paginator', $paginator);
        $this->smarty->assign('current_sort', $sort);
        $this->smarty->display('category.tpl');
    }
}
