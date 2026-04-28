<?php

declare(strict_types=1);

namespace App\Entity;

use DateTimeImmutable;

class Post
{
    /** @var int[] */
    public array $categoryIds = [];

    public function __construct(
        public ?int $id = null,
        public string $title = '',
        public string $description = '',
        public string $content = '',
        public ?string $image = null,
        public int $viewsCount = 0,
        public ?DateTimeImmutable $publishedAt = null,
    )
    {}
}
