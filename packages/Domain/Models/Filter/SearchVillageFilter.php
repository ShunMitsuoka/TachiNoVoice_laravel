<?php
class SearchVillageFilter
{
    public readonly string $keyword;
    public readonly int $village_id;
    public readonly int $member_id;
    public function __construct(
        string $keyword,
        int $village_id,
        int $member_id,
    ) {
        $this->keyword = $keyword;
        $this->village_id = $village_id;
        $this->member_id = $member_id;
    }

    public function existkeyword(): bool
    {
        return (!is_null($this->keyword) && $this->keyword != '');
    }
}
