<?php
namespace Packages\Domain\Models\Village\Topic;

class Topic
{
    private string $title;
    private string $content;
    private string $note;

    function __construct(
        string $title,
        ?string $content,
        ?string $note,
    ) {
        $this->title = $title;
        $this->content = $content;
        $this->note = $note;
    }

    public function title():string{
        return $this->title;
    }

    public function content():string{
        return $this->content;
    }

    public function note():string{
        return $this->note;
    }

}