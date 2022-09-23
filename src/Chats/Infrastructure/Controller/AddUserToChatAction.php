<?php

declare(strict_types=1);

namespace App\Chats\Infrastructure\Controller;

use App\Chats\Domain\Exception\ChatNotFoundException;
use App\Chats\Domain\Exception\ChatParticipantNotFoundException;
use App\Chats\Domain\Factory\ChatParticipantFactory;
use App\Chats\Domain\Repository\ChatParticipantRepositoryInterface;
use App\Chats\Domain\Repository\ChatRepositoryInterface;
use App\Shared\Domain\Security\UserFetcherInterface;
use App\Users\Domain\Entity\User;
use App\Users\Domain\Exception\UserNotFoundException;
use App\Users\Domain\Repository\UserRepositoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/chat/{chat_ulid}/invite', name: 'api_chat_invite', methods: ['POST'])]
class AddUserToChatAction
{
    public function __construct(
        private readonly UserFetcherInterface $userFetcher,
        private readonly UserRepositoryInterface $userRepository,
        private readonly ChatRepositoryInterface $chatRepository,
        private readonly ChatParticipantRepositoryInterface $chatParticipantRepository,
        private readonly ChatParticipantFactory $chatParticipantFactory,
    ) {
    }

    public function __invoke(Request $request, string $chat_ulid): JsonResponse
    {
        /** @var User $user */
        $user = $this->userFetcher->getAuthUser();

        $data = $request->toArray();
        $invite_user_ulid = $data['user_ulid'];
        if (null === $invite_user_ulid) {
            return new JsonResponse(['reason' => 'No set invite user_ulid'], Response::HTTP_BAD_REQUEST);
        }

        try {
            $invite_user = $this->userRepository->findByUlid($invite_user_ulid);

            $chat = $this->chatRepository->findByUlid($chat_ulid);

            // Check user in chat
            $this->chatParticipantRepository->findOne($user, $chat);

            // Creating invited participant
            $inviteParticipant = $this->chatParticipantFactory->create($chat, $invite_user);
            $this->chatParticipantRepository->add($inviteParticipant);
        } catch (UserNotFoundException|ChatNotFoundException $e) {
            return new JsonResponse(['reason' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        } catch (ChatParticipantNotFoundException) {
            return new JsonResponse(['reason' => 'You not chat member'], Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse(['result' => 'ok']);
    }
}
