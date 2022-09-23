<?php

declare(strict_types=1);

namespace App\Chats\Application\DTO;

use App\Chats\Domain\Entity\Chat;

class ChatListDTO
{
    /** @var array<ChatDTO> */
    public array $chatDTOList;

    public function add(ChatDTO $chatDTO): void
    {
        $this->chatDTOList[] = $chatDTO;
    }

    /**
     * @param array<Chat> $chats
     */
    public static function fromListEntity(array $chats): self
    {
        $self = new self();

        foreach ($chats as $chat) {
            $self->add(ChatDTO::fromEntity($chat));
        }

        return $self;
    }
}
