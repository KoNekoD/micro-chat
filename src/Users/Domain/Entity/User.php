<?php

declare(strict_types=1);

namespace App\Users\Domain\Entity;

use App\Shared\Domain\Security\AuthUserInterface;
use App\Shared\Domain\Service\UlidService;
use App\Users\Domain\Service\UserPasswordHasherInterface;

class User implements AuthUserInterface
{
    private string $ulid;
    private string $login;
    private string $password;

    public function __construct(string $login)
    {
        $this->ulid = UlidService::generate();
        $this->login = $login;
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

    public function setPassword(
        string $password,
        UserPasswordHasherInterface $passwordHasher,
    ): void {
        $this->password = $passwordHasher->hash($this, $password);
    }

    public function getRoles(): array
    {
        return [
            'ROLE_USER',
        ];
    }

    public function eraseCredentials(): void
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getUserIdentifier(): string
    {
        return $this->login;
    }
}
