<?php

namespace Packages\Domain\Village\VillageDetails\Evaluation;

use Packages\Domain\Models\Village\VillageOpinionInfo\Opinion\OpinionId;

class Evaluation
{
    private OpinionId $opinion;
    private int $value;

    function __construct(
        OpinionId $opinion,
        int $value,
    ) {
        $this->opinion = $opinion;
        $this->value = $value;
    }

    public function opinion(): OpinionId
    {
        return $this->opinion;
    }

    public function value(): int
    {
        return $this->value;
    }
}
