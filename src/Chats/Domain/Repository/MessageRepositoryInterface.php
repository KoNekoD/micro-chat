<?php

declare(strict_types=1);

namespace App\Chats\Domain\Repository;

use App\Chats\Domain\Entity\Chat;
use App\Chats\Domain\Entity\Message;

interface MessageRepositoryInterface
{
    public function create(Message $message): void;

    /** @return array<Message> */
    public function findByChat(Chat $chat, int $page): iterable;
}
