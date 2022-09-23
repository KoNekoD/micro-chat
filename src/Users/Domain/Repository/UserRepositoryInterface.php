<?php

declare(strict_types=1);

namespace App\Users\Domain\Repository;

use App\Users\Domain\Entity\User;
use App\Users\Domain\Exception\UserNotFoundException;

interface UserRepositoryInterface
{
    public function create(User $user): void;

    /**
     * @throws UserNotFoundException
     */
    public function findByUlid(string $ulid): User;
}
