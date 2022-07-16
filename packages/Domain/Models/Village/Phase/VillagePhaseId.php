<?php
namespace Packages\Domain\Models\Village\Phase;

use Packages\Domain\Models\Common\_Id;

class VillagePhaseId extends _Id
{
    function __construct(int $id) {
        parent::__construct($id);
    }
}