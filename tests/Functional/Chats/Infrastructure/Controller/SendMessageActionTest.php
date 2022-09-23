<?php

declare(strict_types=1);

namespace App\Tests\Functional\Chats\Infrastructure\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class SendMessageActionTest extends WebTestCase
{
    // Это очень длинное название, сделано чтобы упростить тестирование, одним тестом проверим много :)
    public function test_user_created_chat_invited_second_user_and_message_sent_successfully(): void
    {
        // arrange
        self::ensureKernelShutdown();
        $client = static::createClient();

        $client->jsonRequest(
            'POST',
            '/api/auth/token/login',
            [
                'login' => 'user1',
                'password' => 'password',
            ]
        );

        $data = json_decode($client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR);
        $token_user1 = $data['token'];

        $client->jsonRequest(
            'POST',
            '/api/auth/token/login',
            [
                'login' => 'user2',
                'password' => 'password',
            ]
        );

        $data = json_decode($client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR);
        $token_user2 = $data['token'];

        // act

        $client->setServerParameter('HTTP_AUTHORIZATION', sprintf('Bearer %s', $token_user1));

        $client->jsonRequest(
            'POST',
            '/api/chat/create',
            [
                'chat_name' => 'test_chatname',
            ]
        );

        $client->request('GET', '/api/chat/all');

        // assert 1/3
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        // Chat list
        $data = json_decode($client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR);

        // Chat ulid
        $ulid = $data['result'][0]['ulid'];

        // Join second user in chat
        $client->jsonRequest('POST', '/api/chat/'.$ulid.'/join');

        // Assert 2/3
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        // Send messages to chat
        $client->jsonRequest(
            'POST',
            '/api/chat/'.$ulid.'/message/send',
            [
                'message' => 'textmessage',
            ]
        );


        // Send messages from second user to chat
        $client->setServerParameter('HTTP_AUTHORIZATION', sprintf('Bearer %s', $token_user2));
        $client->jsonRequest(
            'POST',
            '/api/chat/'.$ulid.'/message/send',
            [
                'message' => 'textmessage2',
            ]
        );

        // Get messages from 1 user(page 1)
        $messages = $client->request('GET', '/api/chat/'.$ulid.'/message/send?page=1');

        // assert 3/3
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }
}
