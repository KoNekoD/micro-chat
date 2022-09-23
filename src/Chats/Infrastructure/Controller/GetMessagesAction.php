<?php

declare(strict_types=1);

namespace App\Chats\Infrastructure\Controller;

use App\Chats\Application\DTO\MessageListDTO;
use App\Chats\Domain\Exception\ChatNotFoundException;
use App\Chats\Domain\Repository\ChatRepositoryInterface;
use App\Chats\Domain\Repository\MessageRepositoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/chat/{chat_ulid}/message/get')]
class GetMessagesAction
{
    public function __construct(
        private readonly ChatRepositoryInterface $chatRepository,
        private readonly MessageRepositoryInterface $messageRepository,
    ) {
    }

    public function __invoke(Request $request, string $chat_ulid): JsonResponse
    {
        $page = $request->query->getInt('page', 1);

        try {
            $chat = $this->chatRepository->findByUlid($chat_ulid);
        } catch (ChatNotFoundException $e) {
            return new JsonResponse(['reason' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }

        $messages = $this->messageRepository->findByChat($chat, $page);

        return new JsonResponse(['result' => MessageListDTO::fromListEntity($messages)
                ->extractArray(),
        ]);
    }
}
