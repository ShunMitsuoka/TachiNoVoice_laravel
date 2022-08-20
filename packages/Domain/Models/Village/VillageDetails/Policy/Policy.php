<?php

namespace Package\Domain\Models\Village\VillageDetais\Policy;

class Policy
{
    private string $content;

    function __construct(
        string $content
    ) {
        $this->content = $content;
    }

    public function content(): string
    {
        return $this->content;
    }
}
