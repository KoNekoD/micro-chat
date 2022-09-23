<?php

declare(strict_types=1);

namespace App\Chats\Application\DTO;

use App\Chats\Domain\Entity\Message;

class MessageDTO
{
    public function __construct(
      public string $ulid,
      public string $content,
      public int $createdAt,
    ) {
    }

    public static function fromEntity(Message $message): self
    {
        return new self(
            $message->getUlid(),
            $message->getContent(),
            $message->getCreatedAt()->getTimestamp(),
        );
    }

    /**
     * @return array<string|int>
     */
    public function extractArray(): array
    {
        return ['ulid' => $this->ulid, 'content' => $this->content, 'createdAt' => $this->createdAt];
    }
}
