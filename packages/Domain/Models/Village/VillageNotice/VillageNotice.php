<?php

namespace Packages\Domain\Models\Village\VillageNotice;

use Packages\Domain\Models\Village\VillageDetails\Category\Category;
use Packages\Domain\Models\Village\VillageDetails\Category\CategoryId;
use Packages\Domain\Services\Casts\CategoryCast;

class VillageNotice
{
    private string $content;
    private int $notice_type;

    function __construct(
        string $content,
        int $notice_type,
    ) {
        $this->content = $content;
        $this->notice_type = $notice_type;
    }

    public function content(): ?string
    {
        return $this->content;
    }

    public function noticeType(): int
    {
        return $this->notice_type;
    }
}
