<?php
namespace Packages\Domain\Models\User;

use Carbon\Carbon;

class User
{
    protected ?UserId $id;
    protected string $name;
    protected ?string $nickname;
    protected string $email;
    protected int $gender;
    protected Carbon $date_of_birth;

    function __construct(
        ?UserId $id,
        string $name,
        ?string $nickname,
        string $email,
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

    public function id(): UserId
    {
        if (is_null($this->id)) {
            throw new \Exception('IDが存在しません。');
        }
        return $this->id;
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

    public function gender(): int
    {
        return $this->gender;
    }

    public function dateOfBirth(): Carbon
    {
        return $this->date_of_birth;
    }
}