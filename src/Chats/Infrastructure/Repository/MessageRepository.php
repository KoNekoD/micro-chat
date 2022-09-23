<?php

declare(strict_types=1);

namespace App\Chats\Infrastructure\Repository;

use App\Chats\Domain\Entity\Chat;
use App\Chats\Domain\Entity\Message;
use App\Chats\Domain\Repository\MessageRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;

class MessageRepository extends ServiceEntityRepository implements MessageRepositoryInterface
{
    public function __construct(ManagerRegistry $registry, private readonly PaginatorInterface $paginator)
    {
        parent::__construct($registry, Message::class);
    }

    public function create(Message $message): void
    {
        $this->_em->persist($message);
        $this->_em->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function findByChat(Chat $chat, int $page): iterable
    {
        $query = $this->createQueryBuilder('m')
            ->where('m.chat = :chat')
            ->setParameter('chat', $chat)
            ->getQuery();

        return $this->paginator->paginate($query, $page, Message::PER_PAGE)->getItems();
    }
}
