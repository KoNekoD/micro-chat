<?php

declare(strict_types=1);

namespace App\Chats\Infrastructure\Controller;

use App\Chats\Domain\Factory\ChatFactory;
use App\Chats\Domain\Factory\ChatParticipantFactory;
use App\Chats\Domain\Repository\ChatParticipantRepositoryInterface;
use App\Chats\Domain\Repository\ChatRepositoryInterface;
use App\Shared\Domain\Security\UserFetcherInterface;
use App\Users\Domain\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/chat/create', name: 'api_chat_create', methods: ['POST'])]
class CreateChatAction
{
    public function __construct(
        private readonly UserFetcherInterface $userFetcher,
        private readonly ChatFactory $chatFactory,
        private readonly ChatParticipantFactory $participantFactory,
        private readonly ChatRepositoryInterface $chatRepository,
        private readonly ChatParticipantRepositoryInterface $chatParticipantRepository,
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $this->userFetcher->getAuthUser();

        $chat_name = $request->request->get('chat_name', '');

        if (null === $chat_name) {
            return new JsonResponse(['reason' => 'No set chat_name field'], Response::HTTP_BAD_REQUEST);
        }

        // Creating chat
        $chat = $this->chatFactory->create($chat_name);
        $this->chatRepository->create($chat);

        // Adding creator to chat
        $participant = $this->participantFactory->create($chat, $user);
        $this->chatParticipantRepository->add($participant);

        return new JsonResponse(['result' => 'ok']);
    }
}
