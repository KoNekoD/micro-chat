<?php

declare(strict_types=1);

namespace App\Chats\Domain\Entity;

use App\Users\Domain\Entity\User;

class ChatParticipant
{
    private Chat $chat;
    private User $user;

    public function __construct(Chat $chat, User $user)
    {
        $this->chat = $chat;
        $this->user = $user;
    }

    public function getChat(): Chat
    {
        return $this->chat;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
