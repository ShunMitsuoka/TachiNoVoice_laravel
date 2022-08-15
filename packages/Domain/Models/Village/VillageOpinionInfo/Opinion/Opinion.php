<?php
namespace Packages\Domain\Models\Village\VillageOpinionInfo\Opinion;

use Packages\Domain\Models\Common\_Entity;
use Packages\Domain\Models\User\Member;
use Packages\Domain\Models\Village\VillageOpinionInfo\Category\CategoryId;

class Opinion extends _Entity
{
    private ?OpinionId $id;
    private string $content;
    private Member $member;
    private ?array $evaluations;
    private ?CategoryId $category_id;

    function __construct(
        ?OpinionId $id,
        string $content,
        Member $member,
        ?array $evaluations,
        ?CategoryId $category_id = null,
    ) {
        $this->id = $id;
        $this->content = $content;
        $this->member = $member;
        $this->evaluations = is_null($evaluations) ? [] : $evaluations;
        $this->category_id = $category_id;
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

    public function categoryId() : ?CategoryId{
        return $this->category_id;
    }

}