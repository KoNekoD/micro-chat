<?php

declare(strict_types=1);

namespace App\Chats\Domain\Factory;

use App\Chats\Domain\Entity\Chat;
use App\Chats\Domain\Entity\ChatParticipant;
use App\Users\Domain\Entity\User;

class ChatParticipantFactory
{
    public function create(Chat $chat, User $user): ChatParticipant
    {
        return new ChatParticipant($chat, $user);
    }
}
