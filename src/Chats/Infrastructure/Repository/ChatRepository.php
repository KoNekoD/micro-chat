<?php

declare(strict_types=1);

namespace App\Chats\Infrastructure\Repository;

use App\Chats\Domain\Entity\Chat;
use App\Chats\Domain\Exception\ChatNotFoundException;
use App\Chats\Domain\Repository\ChatRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ChatRepository extends ServiceEntityRepository implements ChatRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Chat::class);
    }

    public function create(Chat $chat): void
    {
        $this->_em->persist($chat);
        $this->_em->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function findByUlid(string $ulid): Chat
    {
        $chat = $this->find($ulid);

        if (null === $chat) {
            throw new ChatNotFoundException();
        }

        return $chat;
    }
}
