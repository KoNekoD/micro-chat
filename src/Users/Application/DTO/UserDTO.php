<?php

declare(strict_types=1);

namespace App\Users\Application\DTO;

use App\Users\Domain\Entity\User;

class UserDTO
{
    public function __construct(public readonly string $ulid, public string $login)
    {
    }

     public static function fromEntity(User $user): UserDTO
     {
         return new self($user->getUlid(), $user->getLogin());
     }

     /**
      * @return array<string>
      */
     public function extractArray(): array
     {
         return ['ulid' => $this->ulid, 'login' => $this->login];
     }
}
