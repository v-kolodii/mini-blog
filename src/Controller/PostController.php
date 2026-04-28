<?php
declare(strict_types=1);

namespace App\Controller;

use App\Repository\PostRepository;
use PDO;
use Smarty\Smarty;

class PostController
{
    public function __construct(
        private PDO $pdo,
        private Smarty $smarty,
    )
    {}

    public function show(string $id): void
    {
        $postId = (int) $id;
        $repository = new PostRepository($this->pdo);

        $post = $repository->findById($postId);

        if ($post === null) {
            http_response_code(404);
            $this->smarty->display('404.tpl');

            return;
        }

        $repository->incrementViews($postId);

        $related = $repository->findRelated($postId);

        $this->smarty->assign('post', $post);
        $this->smarty->assign('related', $related);
        $this->smarty->display('post.tpl');
    }
}
