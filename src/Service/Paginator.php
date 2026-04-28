<?php

declare(strict_types=1);

namespace App\Service;

readonly class Paginator
{
    public int $perPage;
    public int $totalPages;
    public int $currentPage;
    public int $offset;
    public bool $hasPrev;
    public bool $hasNext;

    public function __construct(
        int $totalItems,
        int $currentPage,
        int $perPage,
    ) {
        $this->perPage = max(1, $perPage);
        $this->totalPages = max(1, (int) ceil($totalItems / $this->perPage));
        $this->currentPage = max(1, min($currentPage, $this->totalPages));
        $this->offset = ($this->currentPage - 1) * $this->perPage;
        $this->hasPrev = $this->currentPage > 1;
        $this->hasNext = $this->currentPage < $this->totalPages;
    }
}
