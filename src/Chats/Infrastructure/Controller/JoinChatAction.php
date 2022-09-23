<?php

declare(strict_types=1);

namespace App\Chats\Infrastructure\Controller;

use App\Chats\Domain\Exception\ChatNotFoundException;
use App\Chats\Domain\Factory\ChatParticipantFactory;
use App\Chats\Domain\Repository\ChatParticipantRepositoryInterface;
use App\Chats\Domain\Repository\ChatRepositoryInterface;
use App\Shared\Domain\Security\UserFetcherInterface;
use App\Users\Domain\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/chat/{chat_ulid}/join', name: 'api_chat_join', methods: ['POST'])]
class JoinChatAction
{
    public function __construct(
        private readonly UserFetcherInterface $userFetcher,
        private readonly ChatRepositoryInterface $chatRepository,
        private readonly ChatParticipantFactory $chatParticipantFactory,
        private readonly ChatParticipantRepositoryInterface $chatParticipantRepository,
    ) {
    }

    public function __invoke(string $chat_ulid): JsonResponse
    {
        /** @var User $user */
        $user = $this->userFetcher->getAuthUser();

        try {
            $chat = $this->chatRepository->findByUlid($chat_ulid);

            $participant = $this->chatParticipantFactory->create($chat, $user);
            $this->chatParticipantRepository->add($participant);
        } catch (ChatNotFoundException $exception) {
            return new JsonResponse(['reason' => $exception->getMessage()], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse(['result' => 'ok']);
    }
}
