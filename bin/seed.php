<?php

declare(strict_types=1);

require __DIR__ . '/../config/bootstrap.php';

use App\Seeder\CategorySeeder;
use App\Seeder\PostSeeder;

/** @var PDO $pdo */

try {
    $pdo->exec('SET FOREIGN_KEY_CHECKS = 0');
    $pdo->exec('TRUNCATE TABLE post_category');
    $pdo->exec('TRUNCATE TABLE posts');
    $pdo->exec('TRUNCATE TABLE categories');
    $pdo->exec('SET FOREIGN_KEY_CHECKS = 1');

    $categories = (new CategorySeeder($pdo))->run();
    $postSeeder = new PostSeeder($pdo);
    $postSeeder->run($categories);

    echo 'Seed completed: ' . count($categories) . ' categories and posts' . PHP_EOL;
} catch (\Throwable $e) {
    fwrite(STDERR, "Seed failed: " . $e->getMessage() . PHP_EOL);
    exit();
}
