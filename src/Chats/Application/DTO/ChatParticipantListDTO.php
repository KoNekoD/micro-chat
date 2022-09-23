<?php

declare(strict_types=1);

namespace App\Chats\Application\DTO;

use App\Chats\Domain\Entity\ChatParticipant;

class ChatParticipantListDTO
{
    /** @var array<ChatParticipantDTO> */
    public array $chatParticipantList;

    public function add(ChatParticipantDTO $chatParticipantDTO): void
    {
        $this->chatParticipantList[] = $chatParticipantDTO;
    }

    /**
     * @param array<ChatParticipant> $list
     */
    public static function fromListEntity(array $list): self
    {
        $self = new self();

        foreach ($list as $participant) {
            $self->add(ChatParticipantDTO::fromEntity($participant));
        }

        return $self;
    }

    /**
     * @param string $column 'chats' or 'users'
     *
     * @return array<int, array<string>>
     */
    public function getColumnArray(string $column): array
    {
        $result = [];
        foreach ($this->chatParticipantList as $chatParticipantDTO) {
            if ('chats' === $column) {
                $result[] = $chatParticipantDTO->chatDTO->extractArray();
            }

            if ('users' === $column) {
                $result[] = $chatParticipantDTO->userDTO->extractArray();
            }
        }

        return $result;
    }
}
