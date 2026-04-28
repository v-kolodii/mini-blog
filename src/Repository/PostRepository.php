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
}
