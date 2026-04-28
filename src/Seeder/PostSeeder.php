<?php

declare(strict_types=1);

namespace App\Seeder;

use App\Entity\Category;
use DateTimeImmutable;
use PDO;
use RuntimeException;

class PostSeeder
{
    private const string IMAGES_SOURCE_DIR = __DIR__ . '/../../database/seeds/images';
    private const string IMAGES_TARGET_DIR = __DIR__ . '/../../public/uploads';

    public function __construct(private PDO $pdo)
    {
    }

    /**
     * @param Category[] $categories
     */
    public function run(array $categories): void
    {
        $images = $this->copyImages();
        $categoryIds = array_map(fn ($category) => $category->id, $categories);

        $insertPost = $this->pdo->prepare(
            'INSERT INTO posts (title, description, content, image, views_count, published_at)
             VALUES (:title, :description, :content, :image, :views, :published_at)'
        );

        $linkCategory = $this->pdo->prepare(
            'INSERT INTO post_category (post_id, category_id) VALUES (:post_id, :category_id)'
        );

        $totalPosts = 16;

        for ($i = 1; $i <= $totalPosts; $i++) {
            $publishedAt = (new DateTimeImmutable())->modify("-{$i} days");
            $image = $images[array_rand($images)];

            $insertPost->execute([
                ':title'        => sprintf('Post #%d', $i),
                ':description'  => sprintf('Short description for post #%d', $i),
                ':content'      => $this->generateContent($i),
                ':image'        => $image,
                ':views'        => random_int(0, 500),
                ':published_at' => $publishedAt->format('Y-m-d H:i:s'),
            ]);

            $postId = (int) $this->pdo->lastInsertId();

            shuffle($categoryIds);
            $count = random_int(1, min(2, count($categoryIds)));

            for ($j = 0; $j < $count; $j++) {
                $linkCategory->execute([
                    ':post_id'     => $postId,
                    ':category_id' => $categoryIds[$j],
                ]);
            }
        }
    }

    /**
     * Copies seed images to public/uploads, returns list of relative paths.
     * @return string[]
     */
    private function copyImages(): array
    {
        if (!is_dir(self::IMAGES_TARGET_DIR) && !mkdir(self::IMAGES_TARGET_DIR, 0755, true)) {
            throw new RuntimeException("Cannot create directory: " . self::IMAGES_TARGET_DIR);
        }

        $files = array_merge(
            glob(self::IMAGES_SOURCE_DIR . '/*.jpg') ?: [],
            glob(self::IMAGES_SOURCE_DIR . '/*.jpeg') ?: [],
            glob(self::IMAGES_SOURCE_DIR . '/*.png') ?: [],
        );
        $relativePaths = [];

        foreach ($files as $file) {
            $name = basename($file);
            $targetPath = self::IMAGES_TARGET_DIR . '/' . $name;

            if (!file_exists($targetPath)) {
                copy($file, $targetPath);
            }
            $relativePaths[] = '/uploads/' . $name;
        }

        return $relativePaths ?: throw new RuntimeException('No seed images found.');
    }

    private function generateContent(int $i): string
    {
        $text = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.';

        return sprintf('<p>Full content #%d.</p><p>%s</p>', $i, $text);
    }
}
