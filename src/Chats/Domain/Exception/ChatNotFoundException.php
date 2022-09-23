<?php

declare(strict_types=1);

namespace App\Chats\Domain\Exception;

use Exception;

class ChatNotFoundException extends Exception
{
    public function __construct(string $message = 'Chat not found')
    {
        parent::__construct($message);
    }
}
