<?php

namespace Packages\Domain\Models\Village\Topic;

class Topic
{
    private string $title;
    private ?string $content;
    private ?string $note;
    private array $categories;

    function __construct(
        string $title,
        ?string $content,
        ?string $note,
        array $categories = [],
    ) {
        $this->categories = $categories;
        $this->title = $title;
        $this->content = $content;
        $this->note = $note;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function content(): ?string
    {
        return $this->content;
    }

    public function note(): ?string
    {
        return $this->note;
    }

    public function categories(): array
    {
        return $this->categories;
    }
}
