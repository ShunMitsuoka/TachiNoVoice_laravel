<?php

namespace App\Http\Controllers\Api\Member\User;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Api\Member\UserSettingRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Packages\Domain\Interfaces\Repositories\UserRepositoryInterface;
use Packages\Domain\Models\User\User;
use Packages\Domain\Models\User\UserId;
use Packages\Domain\Models\User\UserInfo\Gender;


class UserApiController extends BaseApiController
{
    protected UserRepositoryInterface $user_repository;
    function __construct(
        UserRepositoryInterface $user_repository,
    ) {
        $this->user_repository = $user_repository;
    }

    // /**
    //  * Display a listing of the resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    public function index(Request $request)
    {
        $member = $this->getLoginMember();
        return $this->makeSuccessResponse([
            'user_id' => $member->id()->toInt(),
            'user_name' => $member->name(),
            'nickname' => $member->nickname(),
            'email' => $member->email(),
            'gender' => $member->gender()->id(),
            'birthyear' => $member->birthYear(),
            'birthmonth' => $member->birthMonth(),
            'birthday' => $member->birthDay(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $formData = $request;
        return $this->makeSuccessResponse([]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }
    public function update(UserSettingRequest $request)
    {
        $formData = $request;
        $user =  new User(
            new UserId($formData->userId),
            $formData->user_name,
            $formData->nickname,
            $formData->email,
            new Gender($formData->gender),
            new Carbon($formData->birthyear . '-' . $formData->birthmonth . '-' . $formData->birthday),

        );
        if ($formData->password != '') {
            $user->setPassword($formData->password);
        }
        if ($this->user_repository->update($user)) {
            return $this->makeSuccessResponse([]);
        } else {
            return $this->makeErrorResponse([]);
        }
    }
}
