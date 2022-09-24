<?php

namespace Packages\Domain\Models\Village\VillageDetails\Policy;

use Packages\Domain\Models\Common\_Entity;

class Policy extends _Entity
{
    protected ?PolicyId $id;
    private string $content;

    function __construct(
        ?PolicyId $id,
        string $content
    ) {
        $this->id = $id;
        $this->content = $content;
    }

    public function setId(int $id)
    {
        if (!is_null($this->id)) {
            throw new \Exception('IDが既に存在しています。');
        }
        $this->id = new PolicyId($id);
    }

    public function content(): string
    {
        return $this->content;
    }
}
