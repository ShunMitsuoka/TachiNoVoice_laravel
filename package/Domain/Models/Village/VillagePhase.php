<?php
namespace Packages\Domain\Models\Village;

class VillagePhase
{
    private int $phase;

    function __construct(
        int $phase,
    ) {
        $this->phase = $phase;
    }

    public function phase() : int{
        return $this->phase;
    }

}