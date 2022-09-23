<?php

declare(strict_types=1);

namespace App\Chats\Domain\Factory;

use App\Chats\Domain\Entity\Chat;

class ChatFactory
{
    public function create(string $name): Chat
    {
        return new Chat($name);
    }
}
