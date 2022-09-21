<?php

declare(strict_types=1);

namespace App\User\Domain\Entity;

use App\Shared\Domain\Service\UlidService;

class User
{
    private string $ulid;
    private string $login;
    private string $password;

    public function __construct(string $login, string $password)
    {
        $this->ulid = UlidService::generate();
        $this->login = $login;
        $this->password = $password;
    }

    public function getUlid(): string
    {
        return $this->ulid;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
