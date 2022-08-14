<?php
namespace Packages\Domain\Models\User\UserInfo;
class Gender
{
    public const GENDER_MAN  = 1;
    public const GENDER_MAN_NAME  = '男性';
    public const GENDER_WOMAN  = 2;
    public const GENDER_WOMAN_NAME  = '女性';
    public const GENDER_LGBT  = 3;
    public const GENDER_LGBT_NAME  = 'LGBT';

    protected int $gender;

    function __construct(int $gender) {
        $this->gender = $gender;
    }

    public function id() : int{
        return $this->gender;
    }

    public function name() : string{
        switch ($this->gender) {
            case self::GENDER_MAN:
                return self::GENDER_MAN_NAME;        
            case self::GENDER_WOMAN:
                return self::GENDER_WOMAN_NAME; 
            case self::GENDER_LGBT:
                return self::GENDER_LGBT_NAME;     
        }
        throw new \Exception("存在しない性別です。", 1);
        
    }
}