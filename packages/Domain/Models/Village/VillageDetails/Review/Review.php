<?php

namespace Packages\Domain\Models\Village\VillageDetails\Review;

class Review
{
    private array $satisfactions;
    private ?string $comment;
    private bool $comment_public_flg;

    function __construct(
        array $satisfactions = [],
        ?string $comment,
        bool $comment_public_flg
    ) {
        $this->satisfactions = $satisfactions;
        $this->comment = $comment;
        $this->comment_public_flg = $comment_public_flg;
    }

    public function satisfactions(): array
    {
        return $this->satisfactions;
    }

    public function comment(): string
    {
        return $this->comment;
    }

    public function isCommentPublic(): bool
    {
        return $this->comment_public_flg;
    }

    public function hasComment(): bool
    {
        return !is_null($this->comment) && $this->comment_public_flg;
    }
}
