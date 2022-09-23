<?php

declare(strict_types=1);

namespace App\Chats\Infrastructure\Controller;

use App\Chats\Application\DTO\ChatParticipantListDTO;
use App\Chats\Domain\Repository\ChatParticipantRepositoryInterface;
use App\Shared\Domain\Security\UserFetcherInterface;
use App\Users\Domain\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/chat/all', 'api_chat_get_all', methods: ['GET'])]
class GetChatListAction
{
    public function __construct(
        private readonly UserFetcherInterface $userFetcher,
        private readonly ChatParticipantRepositoryInterface $chatParticipantRepository,
    ) {
    }

    public function __invoke(): JsonResponse
    {
        /** @var User $user */
        $user = $this->userFetcher->getAuthUser();

        $chatParticipantList = $this->chatParticipantRepository->findByUser($user);

        return new JsonResponse(['result' => ChatParticipantListDTO::fromListEntity($chatParticipantList)
                ->getColumnArray('chats'),
        ]);
    }
}
