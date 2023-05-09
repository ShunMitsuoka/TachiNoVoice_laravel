<?php

namespace App\Services;

use Packages\Domain\Models\Collections\BaseCollection;

class PagenationService{

    static public function makePagenationResponse(
        array $data,
        BaseCollection $collection,
    ){
        $result['data'] = $data;
        $result['pageInfo'] = $collection->info();
        return $result;
    }

}