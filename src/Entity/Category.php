<?php

declare(strict_types=1);

namespace App\Entity;

class Category
{
    public function __construct(
        public ?int $id = null,
        public string $name = '',
        public ?string $description = null,
    )
    {}
}
