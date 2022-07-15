<?php
namespace Packages\Domain\Models\Village;

use Packages\Domain\Models\Common\_Id;

class VillageId extends _Id
{
    function __construct(int $id) {
        parent::__construct($id);
    }
}