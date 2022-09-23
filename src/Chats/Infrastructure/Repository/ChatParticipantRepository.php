<?php

declare(strict_types=1);

namespace App\Chats\Infrastructure\Repository;

use App\Chats\Domain\Entity\Chat;
use App\Chats\Domain\Entity\ChatParticipant;
use App\Chats\Domain\Exception\ChatParticipantNotFoundException;
use App\Chats\Domain\Repository\ChatParticipantRepositoryInterface;
use App\Users\Domain\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

class ChatParticipantRepository extends ServiceEntityRepository implements ChatParticipantRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChatParticipant::class);
    }

    public function add(ChatParticipant $particimant): void
    {
        $this->_em->persist($particimant);
        $this->_em->flush();
    }

    /**
     * {@inheritDoc}
     *
     * @throws NonUniqueResultException
     */
    public function findOne(User $user, Chat $chat): ChatParticipant
    {
        try {
            return $this->createQueryBuilder('cp')
                ->where('cp.user = :user')
                ->andWhere('cp.chat = :chat')
                ->setParameters(['user' => $user, 'chat' => $chat])
                ->getQuery()
                ->getSingleResult();
        } catch (NoResultException) {
            throw new ChatParticipantNotFoundException();
        }
    }

    /** {@inheritDoc} */
    public function findByUser(User $user): array
    {
        return $this->createQueryBuilder('cp')
            ->where('cp.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }
}
