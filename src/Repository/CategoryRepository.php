<?php

declare(strict_types=1);

namespace App\Repository;

use PDO;

class CategoryRepository
{
    public function __construct(private PDO $pdo)
    {
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare(
            'SELECT id, name, description FROM categories WHERE id = :id'
        );
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch();

        return $row === false ? null : $row;
    }

    /**
     * Returns categories that have at least one post,
     * each with up to $perCategory latest posts.
     *
     * @return array<int, array{
     *     id: int,
     *     name: string,
     *     description: ?string,
     *     posts: array<int, array<string, mixed>>
     * }>
     */
    public function findAllWithLatestPosts(int $perCategory = 3): array
    {
        $sql = '
            WITH ranked_posts AS (
                SELECT
                    p.id, p.title, p.description, p.image, p.published_at,
                    pc.category_id,
                    ROW_NUMBER() OVER (
                        PARTITION BY pc.category_id
                        ORDER BY p.published_at DESC
                    ) AS rn
                FROM posts p
                INNER JOIN post_category pc ON pc.post_id = p.id
            )
            SELECT
                rp.id, rp.title, rp.description, rp.image, rp.published_at,
                c.id AS category_id,
                c.name AS category_name,
                c.description AS category_description
            FROM ranked_posts rp
            INNER JOIN categories c ON c.id = rp.category_id
            WHERE rp.rn <= :per_category
            ORDER BY c.id, rp.published_at DESC
        ';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':per_category', $perCategory, PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll();

        $grouped = [];
        foreach ($rows as $row) {
            $catId = (int) $row['category_id'];
            if (!isset($grouped[$catId])) {
                $grouped[$catId] = [
                    'id' => $catId,
                    'name' => $row['category_name'],
                    'description' => $row['category_description'],
                    'posts' => [],
                ];
            }
            $grouped[$catId]['posts'][] = [
                'id' => (int) $row['id'],
                'title' => $row['title'],
                'description' => $row['description'],
                'image' => $row['image'],
                'published_at' => $row['published_at'],
            ];
        }

        return array_values($grouped);
    }
}
