<?php
namespace Packages\Domain\Interfaces\Services;

use Packages\Domain\Models\Village\Village;

interface SendNextPhaseEmailServiceInterface
{
    public function sendNextPhaseEmail(Village $village) : bool;
}