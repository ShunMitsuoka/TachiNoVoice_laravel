<?php
namespace Packages\Domain\Models\Village\VillageOpinionInfo;

use Packages\Domain\Models\Common\_Entity;
use Packages\Domain\Models\User\Member;

class Opinion extends _Entity
{
    private ?OpinionId $id;
    private string $content;
    private Member $member;
    private ?array $evaluations;
    private ?Category $category;

    function __construct(
        ?OpinionId $id,
        string $content,
        Member $member,
        ?array $evaluations,
        ?Category $category,
    ) {
        $this->id = $id;
        $this->content = $content;
        $this->member = $member;
        $this->evaluations = $evaluations;
        $this->category = $category;
    }

    public function setId(int $id)
    {
        if (!is_null($this->id)) {
            throw new \Exception('IDが既に存在しています。');
        }
        $this->id = new OpinionId($id);
    }

    public function content() : string{
        return $this->content;
    }

    public function member() : Member{
        return $this->member;
    }

    public function evaluations() : array{
        return $this->evaluations;
    }

    public function category() : Category{
        return $this->category;
    }

}