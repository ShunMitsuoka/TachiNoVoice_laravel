<?php

namespace Packages\Infrastructure\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Packages\Domain\Models\Collections\BaseCollection;

abstract class LaravelRepository
{

    public function makeBaseCollection(array $items, LengthAwarePaginator $pagenator): BaseCollection
    {
        return new BaseCollection($items, $this->getPaganationInfo($pagenator));
    }

    public function getPaganationInfo(LengthAwarePaginator $pagenator): array
    {
        return [
            'current_page' => $pagenator->currentPage(),
            'last_page' => $pagenator->lastPage(),
            'per_page' => $pagenator->perPage(),
            'total' => $pagenator->total(),
            'has_pages' => $pagenator->hasPages(),
            'next_url' => $pagenator->nextPageUrl(),
            'previous_url' => $pagenator->previousPageUrl(),
            'page_name' => $pagenator->getPageName(),
        ];
    }
}
