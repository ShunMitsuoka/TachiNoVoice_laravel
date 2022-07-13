<?php
namespace Packages\Domain\Models\Topic;

class Topic
{
    protected ?TopicId $id;
    private string $title;
    private string $content;
    private string $note;

    function __construct(
        ?TopicId $id,
        string $title,
        ?string $content,
        ?string $note,
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->note = $note;
    }

    public function getId():int{
        if(is_null($this->id)){
            throw new \Exception('IDが存在しません。');
        }
        return $this->id->getId();
    }

    public function getTitle():string{
        return $this->title;
    }

    public function getContent():string{
        return $this->content;
    }

    public function getNote():string{
        return $this->note;
    }

}