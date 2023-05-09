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
            'currentPage' => $pagenator->currentPage(),
            'lastPage' => $pagenator->lastPage(),
            'perPage' => $pagenator->perPage(),
            'total' => $pagenator->total(),
            'hasPages' => $pagenator->hasPages(),
            'hasNextPage' => !is_null($pagenator->nextPageUrl()),
            'next_url' => $pagenator->nextPageUrl(),
            'hasPreviousPage' => !is_null($pagenator->previousPageUrl()),
            'previousUrl' => $pagenator->previousPageUrl(),
            'pageName' => $pagenator->getPageName(),
        ];
    }
}
