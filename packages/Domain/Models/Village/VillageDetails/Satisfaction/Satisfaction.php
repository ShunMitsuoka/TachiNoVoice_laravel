<?php

namespace Packages\Domain\Models\Village\VillageDetails\Satisfaction;

class Satisfaction
{
    private int $level;
    private ?string $comment;

    function __construct(
        int $level,
        ?string $comment,
    ) {
        $this->level = $level;
        $this->comment = $comment;
    }

    public function level(): int
    {
        return $this->level;
    }

    public function comment(): string
    {
        return $this->comment;
    }
}
