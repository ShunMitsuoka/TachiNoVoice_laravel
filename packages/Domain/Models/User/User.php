<?php

namespace Packages\Domain\Models\User;

use Carbon\Carbon;
use Packages\Domain\Models\Common\_Entity;
use Packages\Domain\Models\User\UserInfo\Gender;

class User extends _Entity
{
    public const GENDER_MAN  = 1;
    public const GENDER_WOMAN  = 2;
    public const GENDER_LGBT  = 3;

    protected ?UserId $id;
    protected string $name;
    protected ?string $nickname;
    protected string $email;
    protected ?string $password;
    protected Gender $gender;
    protected Carbon $date_of_birth;


    function __construct(
        ?UserId $id,
        string $name,
        ?string $nickname,
        string $email,
        Gender $gender,
        Carbon $date_of_birth,

    ) {
        $this->id = $id;
        $this->name = $name;
        $this->nickname = $nickname;
        $this->email = $email;
        $this->gender = $gender;
        $this->date_of_birth = $date_of_birth;
        $this->password = null;
    }

    public function setId(int $id)
    {
        if (!is_null($this->id)) {
            throw new \Exception('IDが既に存在しています。');
        }
        $this->id = new UserId($id);
    }
    public function getPassword()
    {
        return $this->password;
    }
    public function setPassword(string $password)
    {
        $this->password = $password;
    }
    public function hasPassword()
    {
        return (!is_null($this->password) && $this->password !== '');
    }

    public function name(): string
    {
        return $this->name;
    }

    public function nickname(): string
    {
        if (is_null($this->nickname)) {
            return $this->name();
        }
        return $this->nickname;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function gender(): Gender
    {
        return $this->gender;
    }

    public function dateOfBirth(): Carbon
    {
        return $this->date_of_birth;
    }

    public function birthYear(): int
    {
        return $this->date_of_birth->year;
    }

    public function birthMonth(): int
    {
        return $this->date_of_birth->month;
    }

    public function birthDay(): int
    {
        return $this->date_of_birth->day;
    }

    public function age(): int
    {
        return $this->date_of_birth->age;
    }
}
