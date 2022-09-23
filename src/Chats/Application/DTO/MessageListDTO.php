<?php

declare(strict_types=1);

namespace App\Chats\Application\DTO;

use App\Chats\Domain\Entity\Message;

class MessageListDTO
{
    /** @var array<MessageDTO> */
    public array $messageList;

    public function add(MessageDTO $messageListDTO): void
    {
        $this->messageList[] = $messageListDTO;
    }

    /**
     * @param array<Message> $list
     */
    public static function fromListEntity(array $list): self
    {
        $self = new self();

        foreach ($list as $message) {
            $self->add(MessageDTO::fromEntity($message));
        }

        return $self;
    }

    /** @return array<array<string|int>> */
    public function extractArray(): array
    {
        $result = [];

        foreach ($this->messageList as $messageDTO) {
            $result[] = $messageDTO->extractArray();
        }

        return $result;
    }
}
