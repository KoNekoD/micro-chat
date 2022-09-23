<?php

declare(strict_types=1);

namespace App\Users\Infrastructure\Service;

use App\Users\Domain\Entity\User;
use App\Users\Domain\Service\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface as UserPasswordHasherInterfaceBase;

class UserPasswordHasher implements UserPasswordHasherInterface
{
    public function __construct(
        private readonly UserPasswordHasherInterfaceBase $passwordHasherBase
    ) {
    }

    public function hash(User $user, string $password): string
    {
        return $this->passwordHasherBase->hashPassword($user, $password);
    }
}
