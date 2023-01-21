<?php

namespace Packages\Domain\Models\Filter;

class JoinningVillageFilter
{
    public readonly int $record_number;
    public readonly bool $finished_flg;

    public function __construct(
        int $record_number,
        bool $finished_flg,
    ) {
        $this->record_number = $record_number;
        $this->finished_flg = $finished_flg;
    }
}
