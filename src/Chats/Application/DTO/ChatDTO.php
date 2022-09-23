<?php

declare(strict_types=1);

namespace App\Chats\Application\DTO;

use App\Chats\Domain\Entity\Chat;

class ChatDTO
{
    public function __construct(public readonly string $ulid, public string $name)
    {
    }

    public static function fromEntity(Chat $chat): self
    {
        return new self($chat->getUlid(), $chat->getName());
    }

    /**
     * @return array<string>
     */
    public function extractArray(): array
    {
        return ['ulid' => $this->ulid, 'name' => $this->name];
    }
}
