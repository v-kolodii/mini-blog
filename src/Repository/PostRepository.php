<?php

declare(strict_types=1);

namespace App\Repository;

use PDO;

class PostRepository
{
    public const array ALLOWED_SORTS = [
        'date'  => 'p.published_at DESC',
        'views' => 'p.views_count DESC',
    ];
    public const string DEFAULT_SORT = 'date';


    public function __construct(private PDO $pdo) {}

    public function findById(int $id): ?array
    {
        $sql = '
            SELECT p.id, p.title, p.description, p.content, p.image,
                   p.views_count, p.published_at
            FROM posts p
            WHERE p.id = :id
        ';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $post = $stmt->fetch();
        if ($post === false) {
            return null;
        }

        $categoriesStmt = $this->pdo->prepare('
            SELECT c.id, c.name
            FROM categories c
            INNER JOIN post_category pc ON pc.category_id = c.id
            WHERE pc.post_id = :post_id
        ');
        $categoriesStmt->bindValue(':post_id', $id, PDO::PARAM_INT);
        $categoriesStmt->execute();

        $post['categories'] = $categoriesStmt->fetchAll();

        return $post;
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function findByCategory(int $categoryId, string $sort, int $limit, int $offset): array
    {
        $orderBy = self::ALLOWED_SORTS[$sort] ?? self::ALLOWED_SORTS[self::DEFAULT_SORT];

        $sql = "
            SELECT p.id, p.title, p.description, p.image, p.published_at, p.views_count
            FROM posts p
            INNER JOIN post_category pc ON pc.post_id = p.id
            WHERE pc.category_id = :category_id
            ORDER BY {$orderBy}
            LIMIT :limit OFFSET :offset
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':category_id', $categoryId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function countByCategory(int $categoryId): int
    {
        $stmt = $this->pdo->prepare(
            'SELECT COUNT(*) FROM post_category WHERE category_id = :category_id'
        );
        $stmt->bindValue(':category_id', $categoryId, PDO::PARAM_INT);
        $stmt->execute();

        return (int) $stmt->fetchColumn();
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function findRelated(int $postId, int $limit = 3): array
    {
        $sql = '
            SELECT DISTINCT p.id, p.title, p.description, p.image, p.published_at
            FROM posts p
            INNER JOIN post_category pc ON pc.post_id = p.id
            WHERE pc.category_id IN (
                SELECT category_id
                FROM post_category
                WHERE post_id = :current_id_1
            )
            AND p.id != :current_id_2
            ORDER BY p.published_at DESC
            LIMIT :limit
        ';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':current_id_1', $postId, PDO::PARAM_INT);
        $stmt->bindValue(':current_id_2', $postId, PDO::PARAM_INT);        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function incrementViews(int $id): void
    {
        $stmt = $this->pdo->prepare(
            'UPDATE posts SET views_count = views_count + 1 WHERE id = :id'
        );
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
}
