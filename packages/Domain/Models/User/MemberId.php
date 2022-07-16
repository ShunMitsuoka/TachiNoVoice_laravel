<?php
namespace Packages\Domain\Models\User;

use Packages\Domain\Models\Common\_Id;

class MemberId extends _Id
{
    function __construct(int $id) {
        parent::__construct($id);
    }
}