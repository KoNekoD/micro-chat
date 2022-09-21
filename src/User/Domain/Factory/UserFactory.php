<?php

declare(strict_types=1);

namespace App\User\Domain\Factory;

use App\User\Domain\Entity\User;

class UserFactory
{
    public function create(string $login, string $password): User
    {
        return new User($login, $password);
    }
}
