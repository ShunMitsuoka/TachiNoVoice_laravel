<?php
namespace Packages\Domain\Models\Topic;

use Packages\Domain\Models\Common\_Id;

class TopicId extends _Id
{
    function __construct(int $id) {
        parent::__construct($id);
    }
}