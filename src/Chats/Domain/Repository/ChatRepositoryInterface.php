<?php

declare(strict_types=1);

namespace App\Chats\Domain\Repository;

use App\Chats\Domain\Entity\Chat;
use App\Chats\Domain\Exception\ChatNotFoundException;

interface ChatRepositoryInterface
{
    public function create(Chat $chat): void;

    /** @throws ChatNotFoundException */
    public function findByUlid(string $ulid): Chat;
}
