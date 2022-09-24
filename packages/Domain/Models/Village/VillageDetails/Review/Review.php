<?php

namespace Packages\Domain\Models\Village\VillageDetails\Review;

class Review
{
    private array $satisfactions;
    private ?string $comment;

    function __construct(
        array $satisfactions = [],
        ?string $comment,
    ) {
        $this->satisfactions = $satisfactions;
        $this->comment = $comment;
    }

    public function satisfactions(): array
    {
        return $this->satisfactions;
    }

    public function comment(): string
    {
        return $this->comment;
    }
}
