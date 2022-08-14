<?php

namespace Packages\Domain\Models\Filter;

use Packages\Domain\Models\User\UserId;

class SearchVillageFilter
{
    public readonly ?string $keyword;
    public readonly UserId $user_id;
    public readonly bool $flag;
    public function __construct(
        ?string $keyword,
        UserId $user_id,
        bool $flag,
    ) {
        $this->keyword = $keyword;
        $this->user_id = $user_id;
        $this->flag = $flag;
    }

    public function existkeyword(): bool
    {
        return (!is_null($this->keyword) && $this->keyword != '');
    }
}
