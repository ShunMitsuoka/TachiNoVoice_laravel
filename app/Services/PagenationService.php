<?php

namespace App\Services;

use Packages\Domain\Models\Collections\BaseCollection;

class PagenationService{

    static public function makePagenationResponse(
        array $data,
        BaseCollection $collection,
    ){
        $result['data'] = $data;
        $result['page_info'] = $collection->info();
        return $result;
    }

}