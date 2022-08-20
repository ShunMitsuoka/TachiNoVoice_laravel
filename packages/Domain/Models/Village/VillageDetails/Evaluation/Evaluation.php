<?php

namespace Packages\Domain\Village\VillageDetails\Evaluation;

use Packages\Domain\Models\Village\VillageOpinionInfo\Opinion\OpinionId;

class Evaluation
{
    private OpinionId $opinion_id;
    private int $value;

    function __construct(
        OpinionId $opinion_id,
        int $value,
    ) {
        $this->opinion_id = $opinion_id;
        $this->value = $value;
    }

    public function opinionId(): OpinionId
    {
        return $this->opinion_id;
    }

    public function value(): int
    {
        return $this->value;
    }
}
