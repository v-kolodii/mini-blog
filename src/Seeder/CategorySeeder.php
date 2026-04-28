<?php
declare(strict_types=1);

namespace App\Seeder;

use App\Entity\Category;
use PDO;

class CategorySeeder
{
    public function __construct(private PDO $pdo) {}

    /**
     * @return Category[] Seeded categories with assigned IDs
     */
    public function run(): array
    {
        $data = [
            ['Technology', 'Articles about software development, gadgets and digital trends.'],
            ['Lifestyle', 'Daily routines, habits and personal growth.'],
            ['Travel', 'Destinations, travel tips and cultural experiences.'],
            ['Food', 'Recipes, restaurant reviews and culinary stories.'],
        ];

        $stmt = $this->pdo->prepare(
            'INSERT INTO categories (name, description) VALUES (:name, :description)'
        );

        $categories = [];
        foreach ($data as [$name, $description]) {
            $stmt->execute([':name' => $name, ':description' => $description]);
            $categories[] = new Category(
                id: (int) $this->pdo->lastInsertId(),
                name: $name,
                description: $description,
            );
        }

        return $categories;
    }
}
