<?php

namespace App\DataFixtures;

use App\Users\Domain\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function __construct(
        private readonly UserFactory $userFactory,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $user_1 = $this->userFactory->create('user1', 'password');
        $user_2 = $this->userFactory->create('user2', 'password');

        $manager->persist($user_1);
        $manager->persist($user_2);

        $manager->flush();
    }
}
