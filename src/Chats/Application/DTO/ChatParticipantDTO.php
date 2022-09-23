<?php

declare(strict_types=1);

namespace App\Chats\Application\DTO;

use App\Chats\Domain\Entity\ChatParticipant;
use App\Users\Application\DTO\UserDTO;

class ChatParticipantDTO
{
    public function __construct(
        public UserDTO $userDTO,
        public ChatDTO $chatDTO,
    ) {
    }

    public static function fromEntity(ChatParticipant $chatParticipant): self
    {
        return new self(
            UserDTO::fromEntity($chatParticipant->getUser()),
            ChatDTO::fromEntity($chatParticipant->getChat())
        );
    }
}
