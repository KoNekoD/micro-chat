<?php

declare(strict_types=1);

namespace App\Users\Infrastructure\Repository;

use App\Users\Domain\Entity\User;
use App\Users\Domain\Exception\UserNotFoundException;
use App\Users\Domain\Repository\UserRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function create(User $user): void
    {
        $this->_em->persist($user);
        $this->_em->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function findByUlid(string $ulid): User
    {
        $user = $this->find($ulid);

        if (null === $user) {
            throw new UserNotFoundException();
        }

        return $user;
    }
}
