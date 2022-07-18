<?php
namespace Packages\Domain\Models\User\UserInfo;

class Gender
{
    public const GENDER_MALE = 1;
    public const GENDER_FEMALE = 2;
    public const GENDER_LESS = 3;

    protected int $gender;

    function __construct(int $gender) {
        $this->gender = $gender;
    }
}