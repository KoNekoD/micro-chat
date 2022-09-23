<?php

declare(strict_types=1);

namespace App\Chats\Infrastructure\Controller;

use App\Chats\Domain\Exception\ChatNotFoundException;
use App\Chats\Domain\Factory\MessageFactory;
use App\Chats\Domain\Repository\ChatRepositoryInterface;
use App\Chats\Domain\Repository\MessageRepositoryInterface;
use App\Shared\Domain\Security\UserFetcherInterface;
use App\Users\Domain\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/chat/{chat_ulid}/message/send', name: 'api_chat_message_send', methods: ['POST'])]
class SendMessageAction
{
    public function __construct(
        private readonly UserFetcherInterface $userFetcher,
        private readonly ChatRepositoryInterface $chatRepository,
        private readonly MessageFactory $messageFactory,
        private readonly MessageRepositoryInterface $messageRepository,
    ) {
    }

    public function __invoke(Request $request, string $chat_ulid): JsonResponse
    {
        /** @var User $user */
        $user = $this->userFetcher->getAuthUser();

        $data = $request->toArray();

        try {
            $chat = $this->chatRepository->findByUlid($chat_ulid);
        } catch (ChatNotFoundException $e) {
            return new JsonResponse(['reason' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }

        // Creating a message
        $message = $this->messageFactory->create($user, $chat, $data['message']);
        $this->messageRepository->create($message);

        return new JsonResponse(['result' => 'ok']);
    }
}
