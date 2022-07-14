<?php
namespace Packages\Domain\Models\Village;

class VillageMemberRequirement
{
    private string $requirement;

    function __construct(
        string $requirement,
    ) {
        $this->requirement = $requirement;
    }

    public function requirement() : string{
        return $this->requirement;
    }

}