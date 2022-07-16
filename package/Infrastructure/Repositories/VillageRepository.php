<?php
namespace Packages\Infrastructure\Repositories;

use App\Models\Village as ModelsVillage;
use Exception;
use Illuminate\Support\Facades\DB;
use Packages\Domain\Interfaces\Repositories\VillageRepositoryInterface;
use Packages\Domain\Models\Village\Village;

class VillageRepository implements VillageRepositoryInterface
{
    public function save(Village $village) : Village{

        DB::beginTransaction();
        try {
            $created_village = ModelsVillage::create([
                'phase_id' => $village->phase()->phase(),
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
    }
}