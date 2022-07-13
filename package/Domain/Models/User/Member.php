<?php
namespace Packages\Domain\Models\User;

use Carbon\Carbon;

class Member
{
    protected ?MemberId $id;
    private string $name;
    private string $nickname;
    private string $email;
    private int $gender;
    private Carbon $date_of_birth;

    function __construct(
        ?MemberId $id,
        string $name,
        string $nickname,
        ?string $email,
        int $gender,
        Carbon $date_of_birth,
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->nickname = $nickname;
        $this->email = $email;
        $this->gender = $gender;
        $this->date_of_birth = $date_of_birth;
    }

    public function getId():int{
        if(is_null($this->id)){
            throw new \Exception('IDが存在しません。');
        }
        return $this->id->getId();
    }

    public function getName():string{
        return $this->name;
    }

    public function getNickName():string{
        return $this->nickname;
    }

    public function getEmail():string {
        return $this->email;
    }

    public function getGender():int{
        return $this->gender;
    }

    public function getDateOfBirth():Carbon{
        return $this->date_of_birth;
    }

}