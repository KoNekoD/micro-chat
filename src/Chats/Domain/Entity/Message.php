<?php

declare(strict_types=1);

namespace App\Chats\Domain\Entity;

use App\Shared\Domain\Service\UlidService;
use App\Users\Domain\Entity\User;
use DateTimeImmutable;

class Message
{
    private string $ulid;
    private User $from;
    private Chat $chat;
    private string $content;
    private DateTimeImmutable $createdAt;

    public function __construct(User $from, Chat $chat, string $content)
    {
        $this->ulid = UlidService::generate();
        $this->from = $from;
        $this->chat = $chat;
        $this->content = $content;
        $this->createdAt = new DateTimeImmutable('now');
    }

    public function getUlid(): string
    {
        return $this->ulid;
    }

    public function getFrom(): User
    {
        return $this->from;
    }

    public function getChat(): Chat
    {
        return $this->chat;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public const PER_PAGE = 100;
}
