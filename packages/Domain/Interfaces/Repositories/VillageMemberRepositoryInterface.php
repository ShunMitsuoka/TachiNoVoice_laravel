<?php
namespace Packages\Domain\Interfaces\Repositories;

interface VillageMemberRepositoryInterface 
{
    public function getAllByVillageId(int $village_id) : array;
}