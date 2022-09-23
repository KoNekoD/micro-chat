<?php

declare(strict_types=1);

namespace App\Chats\Domain\Repository;

use App\Chats\Domain\Entity\Chat;
use App\Chats\Domain\Entity\ChatParticipant;
use App\Chats\Domain\Exception\ChatParticipantNotFoundException;
use App\Users\Domain\Entity\User;

interface ChatParticipantRepositoryInterface
{
    public function add(ChatParticipant $particimant): void;

    /**
     * @throws ChatParticipantNotFoundException
     */
    public function findOne(User $user, Chat $chat): ChatParticipant;

    /** @return array<ChatParticipant> */
    public function findByUser(User $user): array;
}
