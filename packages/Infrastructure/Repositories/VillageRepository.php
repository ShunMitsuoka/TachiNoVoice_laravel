<?php

namespace Packages\Infrastructure\Repositories;

use App\Models\Phase as ModelPhase;
use App\Models\PhaseSetting as ModelPhaseSetting;
use App\Models\PublicInformation as ModelPublicInformation;
use App\Models\Village as ModelVillage;
use App\Models\VillageMemberRequirement as ModelVillageMemberRequirement;
use App\Models\VillageSetting as ModelVillageSetting;
use App\Models\VillageMember as ModelVillageMember;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Packages\Domain\Interfaces\Repositories\VillageRepositoryInterface;
use Packages\Domain\Models\Collections\BaseCollection;
use Packages\Domain\Models\Filter\JoinningVillageFilter;
use Packages\Domain\Models\Filter\SearchVillageFilter;
use Packages\Domain\Models\User\Member;
use Packages\Domain\Models\User\UserId;
use Packages\Domain\Models\Village\Phase\VillagePhaseEndSetting;
use Packages\Domain\Models\Village\Phase\VillagePhaseId;
use Packages\Domain\Models\Village\Phase\VillagePhase;
use Packages\Domain\Models\Village\Phase\VillagePhaseStartSetting;
use Packages\Domain\Models\Village\Topic\Topic;
use Packages\Domain\Models\Village\Village;
use Packages\Domain\Models\Village\VillageId;
use Packages\Domain\Models\Village\VillageMemberRequirement;
use Packages\Domain\Models\Village\VillagePublicInformation;
use Packages\Domain\Models\Village\VillageSetting;
use Packages\Domain\Services\VillagePhaseService;

class VillageRepository extends LaravelRepository implements VillageRepositoryInterface
{

    public function get(VillageId $village_id): Village
    {
        try {
            $village_info = $this->queryVillageInfo()
                ->where('v.id', $village_id->toInt())->first();
            if (!is_null($village_info)) {
                return $this->getVillageFromRecord($village_info);
            }
        } catch (\Exception $e) {
            logs()->error($e->getMessage());
        }
        return null;
    }

    public function getAll(SearchVillageFilter $filter): array
    {
        $result = [];
        $query = $this->queryVillageInfo();
        if($filter->existkeyword()){
            $query = $query->where('title', 'like', '%' . $filter->keyword . '%');
        }
        $village_records = $this->setJoiningCondition($filter->user_id, $query)->get();
        foreach ($village_records as $record) {
            $result[] = $this->getVillageFromRecord($record);
        }
        return $result;
    }

    public function getAllJoiningVillage(UserId $userId, JoinningVillageFilter $filter) : BaseCollection
    {
        $result = [];
        $query = $this->queryVillageInfo()
        ->whereIn(
            'v.id',
            function ($query) use ($userId) {
                $village_members = ModelVillageMember::select('village_id')->where('user_id', $userId->toInt());
                $query->select('village_id')
                    ->from('hosts')
                    ->union($village_members)
                    ->where('user_id', $userId->toInt());
            }
        );

        if($filter->finished_flg){
            $query = $query->where(function($query) {
                $query->where('p.m_phase_id', VillagePhase::PHASE_SURVEYING_SATISFACTION)
                      ->where('p.m_phase_status_id', VillagePhase::PHASE_STATUS_COMPLETE);
            });
        }else{
            $query = $query->where(function($query) {
                $query->where('p.m_phase_id', '!=', VillagePhase::PHASE_SURVEYING_SATISFACTION)
                      ->orWhere('p.m_phase_status_id', '!=', VillagePhase::PHASE_STATUS_COMPLETE);
            });
        }
        
        $village_records = $query->paginate($filter->record_number);

        foreach ($village_records as $record) {
            $result[] = $this->getVillageFromRecord($record);
        }
        return $this->makeBaseCollection($result, $village_records);
    }

    public function save(Village $village): Village
    {
        $created_village = ModelVillage::create([
            'title' => $village->topic()->title(),
            'content' => $village->topic()->content(),
            'note' => $village->topic()->note(),
        ]);
        $village->setId($created_village->id);

        $created_village_setting = ModelVillageSetting::create([
            'village_id' => $village->id()->toInt(),
            'village_member_limit' => $village->setting()->villageMemberLimit(),
            'core_member_limit' => $village->setting()->coreMemberLimit(),
        ]);

        $created_requirement = ModelVillageMemberRequirement::create([
            'village_id' => $village->id()->toInt(),
            'requirement' => $village->requirement()->requirement(),
        ]);

        $created_public_info = ModelPublicInformation::create([
            'village_id' => $village->id()->toInt(),
            'nickname_flg' => $village->publicInformation()->isNicknamePublic(),
            'gender_flg' => $village->publicInformation()->isGenderPublic(),
            'age_flg' => $village->publicInformation()->isAgePublic(),
        ]);

        $created_phase = ModelPhase::create([
            'village_id' => $village->id()->toInt(),
            'm_phase_id' => $village->phase()->phaseNo(),
            'm_phase_status_id' => $village->phase()->phaseStatus(),
        ]);
        if ($village->phase()->existsPhaseStartSetting()) {
            ModelPhaseSetting::create([
                'phase_id' => $created_phase->id,
                'end_flg' => false,
                'by_manual_flg' => $village->phase()->phaseStartSetting()->byManualFlg(),
                'by_instant_flg' => $village->phase()->phaseStartSetting()->byInstantFlg(),
                'by_date_flg' => $village->phase()->phaseStartSetting()->byDateFlg(),
                'border_date' => $village->phase()->phaseStartSetting()->borderDate(),
            ]);
        }
        if ($village->phase()->existsPhaseEndSetting()) {
            ModelPhaseSetting::create([
                'phase_id' => $created_phase->id,
                'end_flg' => true,
                'by_manual_flg' => $village->phase()->phaseEndSetting()->byManualFlg(),
                'by_limit_flg' => $village->phase()->phaseEndSetting()->byLimitFlg(),
                'by_date_flg' => $village->phase()->phaseEndSetting()->byDateFlg(),
                'border_date' => $village->phase()->phaseEndSetting()->borderDate(),
            ]);
        }

        return new Village(
            new VillageId($created_village->id),
            VillagePhaseService::getVillagePhase(
                new VillagePhaseId($created_phase->id),
                $created_phase->m_phase_id,
                $created_phase->m_phase_status_id,
                $village->phase()->phaseStartSetting(),
                $village->phase()->phaseEndSetting()
            ),
            new Topic(
                $created_village->title,
                $created_village->content,
                $created_village->note,
            ),
            new VillageSetting(
                $created_village_setting->village_member_limit,
                $created_village_setting->core_member_limit,
            ),
            new VillageMemberRequirement(
                $created_requirement->requirement,
            ),
            new VillagePublicInformation(
                $created_public_info->nickname_flg,
                $created_public_info->gender_flg,
                $created_public_info->age_flg,
            )
        );
    }

    public function update(Village $village): Village
    {
        ModelVillage::where('id', $village->id()->toInt())
            ->update([
                'title' => $village->topic()->title(),
                'content' => $village->topic()->content(),
                'note' => $village->topic()->note(),
            ]);

        ModelVillageSetting::where('village_id', $village->id()->toInt())
            ->update([
                'village_member_limit' => $village->setting()->villageMemberLimit(),
                'core_member_limit' => $village->setting()->coreMemberLimit(),
            ]);

        ModelVillageMemberRequirement::where('village_id', $village->id()->toInt())
            ->update([
                'requirement' => $village->requirement()->requirement(),
            ]);

        ModelPublicInformation::where('village_id', $village->id()->toInt())
            ->update([
                'nickname_flg' => $village->publicInformation()->isNicknamePublic(),
                'gender_flg' => $village->publicInformation()->isGenderPublic(),
                'age_flg' => $village->publicInformation()->isAgePublic(),
            ]);

        $updated_phase = ModelPhase::updateOrCreate([
            'village_id' => $village->id()->toInt(),
            'm_phase_id' => $village->phase()->phaseNo(),
        ], [
            'village_id' => $village->id()->toInt(),
            'm_phase_id' => $village->phase()->phaseNo(),
            'm_phase_status_id' => $village->phase()->phaseStatus(),
        ]);
        if ($village->phase()->existsPhaseStartSetting()) {
            ModelPhaseSetting::updateOrCreate([
                'phase_id' => $updated_phase->id,
                'end_flg' => false,
            ], [
                'phase_id' => $updated_phase->id,
                'end_flg' => false,
                'by_manual_flg' => $village->phase()->phaseStartSetting()->byManualFlg(),
                'by_date_flg' => $village->phase()->phaseStartSetting()->byDateFlg(),
                'by_instant_flg' => $village->phase()->phaseStartSetting()->byInstantFlg(),
                'border_date' => $village->phase()->phaseStartSetting()->borderDate(),
            ]);
        }
        if ($village->phase()->existsPhaseEndSetting()) {
            ModelPhaseSetting::updateOrCreate([
                'phase_id' => $updated_phase->id,
                'end_flg' => true,
            ], [
                'phase_id' => $updated_phase->id,
                'end_flg' => true,
                'by_manual_flg' => $village->phase()->phaseEndSetting()->byManualFlg(),
                'by_limit_flg' => $village->phase()->phaseEndSetting()->byLimitFlg(),
                'by_date_flg' => $village->phase()->phaseEndSetting()->byDateFlg(),
                'border_date' => $village->phase()->phaseEndSetting()->borderDate(),
            ]);
        }
        return new Village(
            new VillageId($village->id()->toInt()),
            VillagePhaseService::getVillagePhase(
                new VillagePhaseId($updated_phase->id),
                $updated_phase->m_phase_id,
                $updated_phase->m_phase_status_id,
                $village->phase()->phaseStartSetting(),
                $village->phase()->phaseEndSetting()
            ),
            $village->topic(),
            $village->setting(),
            $village->requirement(),
            $village->publicInformation(),
            $village->existsMemberInfo() ? $village->memberInfo() : null
        );
    }

    public function checkPermission(Village $village, Member $member): bool
    {
        $query = $this->queryVillageInfo()->where('v.id', $village->id()->toInt());
        $query = $this->setJoiningCondition($member->id(), $query);
        return $query->exists();
    }

    /**
     * Villgaeを作成するために必要なフィールド情報を取得するためのクエリを返す。
     */
    private function queryVillageInfo()
    {
        $maxPhseSubQuery = DB::table('phases as max_phases')
            ->select(
                'max_phases.village_id',
                DB::raw('max(max_phases.m_phase_id) as max_m_phase_id'),
            )
            ->groupBy('max_phases.village_id');

        $phseSubQuery = DB::table('phases as sub_phases')
            ->select(
                'sub_phases.id',
                'sub_phases.village_id',
                'sub_phases.m_phase_id',
                'sub_phases.m_phase_status_id',
            )
            ->joinSub($maxPhseSubQuery, 'max_phases', function ($join) {
                $join->on('max_phases.village_id', 'sub_phases.village_id')
                    ->where('max_phases.max_m_phase_id', '=', DB::raw('sub_phases.m_phase_id'));
            });

        $query = ModelVillage::from('villages as v')
            ->select(
                'v.id as village_id',
                'v.title',
                'v.content',
                'v.note',
                'p.id as phase_id',
                'p.m_phase_id',
                'p.m_phase_status_id',
                'vs.core_member_limit',
                'vs.village_member_limit',
                'vmr.requirement',
                'pi.nickname_flg',
                'pi.gender_flg',
                'pi.age_flg',
            )
            ->joinSub($phseSubQuery, 'p', 'p.village_id', 'v.id')
            ->join('village_member_requirements as vmr', 'vmr.village_id', 'v.id')
            ->join('village_settings as vs', 'vs.village_id', 'v.id')
            ->join('public_informations as pi', 'pi.village_id', 'v.id')
            ->orderBy('v.updated_at', 'DESC');
        return $query;
    }

    /**
     * queryVillageInfo関数を使用して取得したフィールド情報から
     * Villageクラスを作成する。
     */
    private function getVillageFromRecord($village_info): Village
    {
        $phase_start = ModelPhaseSetting::from('phase_settings as ps')
            ->join('phases as p', 'ps.phase_id', 'p.id')
            ->where('ps.phase_id', $village_info->phase_id)
            ->where('ps.end_flg', false)
            ->first();
        $phase_end = ModelPhaseSetting::from('phase_settings as ps')
            ->join('phases as p', 'ps.phase_id', 'p.id')
            ->where('ps.phase_id', $village_info->phase_id)
            ->where('ps.end_flg', true)
            ->first();

        $phase_start_setting = null;
        if (!is_null($phase_start)) {
            $phase_start_setting = new VillagePhaseStartSetting(
                $phase_start->by_manual_flg,
                $phase_start->by_date_flg,
                $phase_start->by_instant_flg,
                !is_null($phase_start->border_date) ? new Carbon($phase_start->border_date) : null,
            );
        }

        $phase_end_setting = null;
        if (!is_null($phase_end)) {
            $phase_end_setting = new VillagePhaseEndSetting(
                $phase_end->by_manual_flg,
                $phase_end->by_limit_flg,
                $phase_end->by_date_flg,
                !is_null($phase_end->border_date) ? new Carbon($phase_end->border_date) : null,
            );
        }

        return new Village(
            new VillageId($village_info->village_id),
            VillagePhaseService::getVillagePhase(
                new VillagePhaseId($village_info->phase_id),
                $village_info->m_phase_id,
                $village_info->m_phase_status_id,
                $phase_start_setting,
                $phase_end_setting,
            ),
            new Topic(
                $village_info->title,
                $village_info->content,
                $village_info->note,
            ),
            new VillageSetting(
                $village_info->village_member_limit,
                $village_info->core_member_limit,
            ),
            new VillageMemberRequirement(
                $village_info->requirement,
            ),
            new VillagePublicInformation(
                $village_info->nickname_flg,
                $village_info->gender_flg,
                $village_info->age_flg,
            )
        );
    }

    /**
     * ログインユーザが参加条件を満たしているかを以下の順で確認する
     * ①メンバー募集フェーズかどうか
     * ②既にメンバーかどうか
     * ③メンバー上限に達しているかどうか
     */
    private function setJoiningCondition(?UserId $userId, $query)
    {
        try {
            // ①メンバー募集フェーズかどうか(フェーズが開始されていること。)
            $query = $query->where('p.m_phase_id', VillagePhase::PHASE_RECRUITMENT_OF_MEMBER);
            $query = $query->where('p.m_phase_status_id', VillagePhase::PHASE_STATUS_IN_PROGRESS);

            // ②既にメンバーかどうか
            $query = $query->whereNotIn(
                'v.id',
                function ($query) use ($userId) {
                    $village_members = ModelVillageMember::select('village_id')->where('user_id', $userId->toInt());
                    $query->select('village_id')
                        ->from('hosts')
                        ->union($village_members)
                        ->where('user_id', $userId->toInt());
                }
            );
            // ③メンバー上限に達しているかどうか
            $query = $query->where('vs.village_member_limit', '>', function ($query_data) {
                $query_data->select(DB::raw('COUNT(vm.user_id)'))
                    ->from('village_members as vm')
                    ->where('v.id', DB::raw('vm.village_id'));
            });

            return $query;
        } catch (\Exception $e) {
            logs()->error($e->getMessage());
        }
        return [];
    }
}
