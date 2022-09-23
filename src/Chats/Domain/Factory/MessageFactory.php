<?php

declare(strict_types=1);

namespace App\Chats\Domain\Factory;

use App\Chats\Domain\Entity\Chat;
use App\Chats\Domain\Entity\Message;
use App\Users\Domain\Entity\User;

class MessageFactory
{
    public function create(User $from, Chat $chat, string $content): Message
    {
        return new Message($from, $chat, $content);
    }
}
