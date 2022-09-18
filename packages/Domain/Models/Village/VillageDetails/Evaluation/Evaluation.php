<?php

namespace Packages\Domain\Models\Village\VillageDetails\Evaluation;

use Packages\Domain\Models\Village\VillageDetails\Opinion\OpinionId;

class Evaluation
{
    /**
     * 評価：良い
     */
    public const EVALUATION_GOOD = 1;
    /**
     * 評価：悪い
     */
    public const EVALUATION_BAD = 50;
    /**
     * 評価：不明
     */
    public const EVALUATION_UNCERTAIN = 100;

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
