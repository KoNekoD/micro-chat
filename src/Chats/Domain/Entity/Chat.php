<?php

declare(strict_types=1);

namespace App\Chats\Domain\Entity;

use App\Shared\Domain\Service\UlidService;

class Chat
{
    private string $ulid;
    private string $name;

    public function __construct(string $name)
    {
        $this->ulid = UlidService::generate();
        $this->name = $name;
    }

    public function getUlid(): string
    {
        return $this->ulid;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
