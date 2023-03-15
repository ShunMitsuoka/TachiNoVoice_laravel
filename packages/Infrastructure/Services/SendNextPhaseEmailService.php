<?php
namespace Packages\Infrastructure\Services;

use App\Mail\EndPhaseEmail;
use App\Mail\NextPhaseEmail;
use App\Models\VillageNotice;
use Illuminate\Support\Facades\Mail;
use Packages\Domain\Interfaces\Repositories\VillageNoticeRepositoryInterface;
use Packages\Domain\Interfaces\Services\SendNextPhaseEmailServiceInterface;
use Packages\Domain\Models\Village\Phase\VillagePhase;
use Packages\Domain\Models\Village\Village;
use Packages\Domain\Services\Casts\MemberCast;

class SendNextPhaseEmailService implements SendNextPhaseEmailServiceInterface
{

    protected VillageNoticeRepositoryInterface $village_notice_repository;

    function __construct(
        VillageNoticeRepositoryInterface $village_notice_repository,
    ) {
        $this->village_notice_repository = $village_notice_repository;
    }

    public function sendNextPhaseEmail(Village $village) : bool
    {
        if ($village->existsMemberInfo()) {
            $village_member_array = $village->memberInfo()->villageMembers();
            $host_array = $village->memberInfo()->hosts();
            $core_member_array = $village->memberInfo()->coreMembers();
            $rise_member_array = $village->memberInfo()->riseMembers();
            $url = config('app.url');
            $url = $url."/member/village/my/details/".$village->id()->toInt();

            switch ($village->phase()->phaseNo()) {
                case VillagePhase::PHASE_DRAWING_CORE_MEMBER:
                    //ホストにメンバー募集が終了したメール送信
                    // $end_phase_name = VillagePhase::PHASE_RECRUITMENT_OF_MEMBER_NAME;
                    // foreach ($host_array as $host) {
                    //     $host = MemberCast::castHost($host);
                    //     Mail::send(new EndPhaseEmail($host, $end_phase_name, $village, $url));
                    // }
                    break;

                case VillagePhase::PHASE_ASKING_OPINIONS_OF_CORE_MEMBER:
                    if ($village->phase()->phaseStatus() == 1) {
                        //コア、ライズメンバーにメンバー抽選が終わったメール送信
                        $end_phase_name = VillagePhase::PHASE_DRAWING_CORE_MEMBER_NAME;
                        foreach ($core_member_array as $core_member) {
                            $core_member = MemberCast::castCoreMember($core_member);
                            Mail::send(new EndPhaseEmail($core_member, $end_phase_name, $village, $url));
                            $content = "【". $village->topic()->title()."】メンバー抽選が終了しました。";
                            $this->village_notice_repository->save($village, $content);
                        }
                        foreach ($rise_member_array as $rise_member) {
                            $rise_member = MemberCast::castRiseMember($rise_member);
                            Mail::send(new EndPhaseEmail($rise_member, $end_phase_name, $village, $url));
                            $content = "【". $village->topic()->title()."】メンバー抽選が終了しました。";
                            $this->village_notice_repository->save($village, $content);
                        }
                    }
                    
                    if ($village->phase()->phaseStatus() == 100) {
                        //コアメンバーにコア意見募集が始まったメール送信
                        foreach ($core_member_array as $core_member) {
                            $core_member = MemberCast::castCoreMember($core_member);
                            Mail::send(new NextPhaseEmail($core_member, $village, $url));
                            $content = "【". $village->topic()->title()."】コア意見募集が開始しました。";
                            $this->village_notice_repository->save($village, $content);
                        }
                    }
                    break;

                case VillagePhase::PHASE_CATEGORIZE_OPINIONS:
                    //ホストにコア意見募集が終了したメール送信
                    // $end_phase_name = VillagePhase::PHASE_ASKING_OPINIONS_OF_CORE_MEMBER_NAME;
                    // foreach ($host_array as $host) {
                    //     $host = MemberCast::castHost($host);
                    //     Mail::send(new EndPhaseEmail($host, $end_phase_name, $village, $url));
                    // }
                    break;
                
                case VillagePhase::PHASE_ASKING_OPINIONS_OF_RIZE_MEMBER:
                    //ライズメンバーにコア意見募集が始まったメール送信
                    foreach ($rise_member_array as $rise_member) {
                        $rise_member = MemberCast::castRiseMember($rise_member);
                        Mail::send(new NextPhaseEmail($rise_member, $village, $url));
                        $content = "【". $village->topic()->title()."】コア意見募集が開始しました。";
                        $this->village_notice_repository->save($village, $content);
                    }
                    break;

                case VillagePhase::PHASE_EVALUATION:
                    //ホストにライズ意見募集が終了したメール送信
                    // $end_phase_name = VillagePhase::PHASE_ASKING_OPINIONS_OF_RIZE_MEMBER_NAME;
                    // foreach ($host_array as $host) {
                    //     $host = MemberCast::castHost($host);
                    //     Mail::send(new EndPhaseEmail($host, $end_phase_name, $village, $url));
                    // }
                    //コア、ライズメンバーに意見評価が始まったメール送信
                    foreach ($core_member_array as $core_member) {
                        $core_member = MemberCast::castCoreMember($core_member);
                        Mail::send(new NextPhaseEmail($core_member, $village, $url));
                        $content = "【". $village->topic()->title()."】意見評価が開始しました。";
                        $this->village_notice_repository->save($village, $content);
                    }
                    foreach ($rise_member_array as $rise_member) {
                        $rise_member = MemberCast::castRiseMember($rise_member);
                        Mail::send(new NextPhaseEmail($rise_member, $village, $url));
                        $content = "【". $village->topic()->title()."】意見評価が開始しました。";
                        $this->village_notice_repository->save($village, $content);
                    }
                    break;

                case VillagePhase::PHASE_DECIDING_POLICY:
                //     //ホストに意見評価が終了したメール送信
                //     $end_phase_name = VillagePhase::PHASE_EVALUATION_NAME;
                //     foreach ($host_array as $host) {
                //         $host = MemberCast::castHost($host);
                //         Mail::send(new EndPhaseEmail($host, $end_phase_name, $village, $url));
                //     }
                    break;

                case VillagePhase::PHASE_SURVEYING_SATISFACTION:
                    //コア、ライズメンバーに満足度調査が始まったメール送信
                    foreach ($core_member_array as $core_member) {
                        $core_member = MemberCast::castCoreMember($core_member);
                        Mail::send(new NextPhaseEmail($core_member, $village, $url));
                        $content = "【". $village->topic()->title()."】満足度調査が開始しました。";
                        $this->village_notice_repository->save($village, $content);
                    }
                    foreach ($rise_member_array as $rise_member) {
                        $rise_member = MemberCast::castRiseMember($rise_member);
                        Mail::send(new NextPhaseEmail($rise_member, $village, $url));
                        $content = "【". $village->topic()->title()."】満足度調査が開始しました。";
                    }
                    break;
            }
        }
        return true;
    }
}