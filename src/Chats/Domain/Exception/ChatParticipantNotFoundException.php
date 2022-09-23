<?php

declare(strict_types=1);

namespace App\Chats\Domain\Exception;

use Exception;

class ChatParticipantNotFoundException extends Exception
{
    public function __construct(string $message = 'Participant from requested data not found!')
    {
        parent::__construct($message);
    }
}
