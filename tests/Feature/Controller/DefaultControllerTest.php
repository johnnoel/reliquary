<?php

declare(strict_types=1);

namespace App\Tests;

use App\Entity\User;
use App\Service\MessageService;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class DefaultControllerTest extends WebTestCase
{
    public function testIndexExists(): void
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function testBodyReport(): void
    {
        $client = static::createClient();
        $messageService = static::$container->get(MessageService::class);

        $messageService->assignMessage('123456789', 'Test User', 'i', 'fell', 'hq');

        $client->request('GET', '/123456789');
        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertStringContainsString('Test User', $client->getResponse()->getContent());

        $messageService->removeMessage('123456789');
    }

    public function testBodyReport404s(): void
    {
        $client = static::createClient();
        $client->request('GET', '/123456789');
        $this->assertTrue($client->getResponse()->isNotFound());
    }

    public function testChooseMessageExists(): void
    {
        $client = static::createClient();
        $client->loginUser(new User('Test User', '123456789'));
        $client->request('GET', '/choose-message');

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function testChooseMessage(): void
    {
        $client = static::createClient();
        $client->loginUser(new User('Test User', '123456789'));
        $client->request('POST', '/choose-message', [
            'p1' => 'i',
            'p2' => 'fell',
            'p3' => 'hq',
        ]);

        $this->assertTrue($client->getResponse()->isRedirect('/123456789'));
        $client->followRedirect();
        $this->assertStringContainsString('Test User', $client->getResponse()->getContent());

        $messageService = static::$container->get(MessageService::class);
        $messageService->removeMessage('123456789');
    }

    public function testChooseMessageJson(): void
    {
        $client = static::createClient();
        $client->loginUser(new User('Test User', '123456789'));
        $client->request('POST', '/choose-message.json', [
            'p1' => 'i',
            'p2' => 'fell',
            'p3' => 'hq',
        ]);

        $this->assertSame(Response::HTTP_CREATED, $client->getResponse()->getStatusCode());

        $messageService = static::$container->get(MessageService::class);
        $messageService->removeMessage('123456789');
    }

    /**
     * @dataProvider choosMessageFailsProvider
     */
    public function testChooseMessageFails(array $postData): void
    {
        $client = static::createClient();
        $client->loginUser(new User('Test User', '123456789'));
        $client->request('POST', '/choose-message', $postData);

        $this->assertSame(Response::HTTP_BAD_REQUEST, $client->getResponse()->getStatusCode());
    }

    public function choosMessageFailsProvider(): array
    {
        return [
            'empty' => [ [] ],
            'only p1' => [ [ 'p1' => 'i' ] ],
            'only p2' => [ [ 'p2' => 'fell' ] ],
            'only p3' => [ [ 'p3' => 'hq' ] ],
            'only p1 & p2' => [ [ 'p1' => 'i', 'p2' => 'fell' ] ],
            'only p1 & p3' => [ [ 'p1' => 'i', 'p3' => 'hq' ] ],
            'only p2 & p3' => [ [ 'p2' => 'fell', 'p3' => 'hq' ] ],
            'bad p1' => [ [ 'p1' => 'testest', 'p2' => 'fell', 'p3' => 'hq' ] ],
            'bad p2' => [ [ 'p1' => 'i', 'p2' => 'testest', 'p3' => 'hq' ] ],
            'bad p3' => [ [ 'p1' => 'i', 'p2' => 'fell', 'p3' => 'testest' ] ],
        ];
    }

    public function testChooseMessageFailsExistingMessage(): void
    {
        $client = static::createClient();
        $messageService = static::$container->get(MessageService::class);

        $messageService->assignMessage('123456789', 'Test User', 'i', 'fell', 'hq');

        $client->loginUser(new User('Test User', '123456789'));
        $client->request('POST', '/choose-message', [
            'p1' => 'i',
            'p2' => 'fell',
            'p3' => 'hq',
        ]);

        $this->assertSame(Response::HTTP_CONFLICT, $client->getResponse()->getStatusCode());

        $messageService->removeMessage('123456789');
    }

    public function testChooseMessageNotLoggedIn(): void
    {
        $client = static::createClient();
        $client->request('GET', '/choose-message');

        $this->assertTrue($client->getResponse()->isRedirect());
    }

    public function testIsMessageAvailable(): void
    {
        $client = static::createClient();
        $messageService = static::$container->get(MessageService::class);

        $messageService->assignMessage('123456789', 'Test User', 'i', 'fell', 'hq');

        $client->request('GET', '/is-message-available?p1=i&p2=fell&p3=hq');
        $this->assertTrue($client->getResponse()->isSuccessful());

        $client->request('GET', '/is-message-available?p1=i&p2=fell&p3=cradle');
        $this->assertTrue($client->getResponse()->isNotFound());

        $messageService->removeMessage('123456789');
    }

    /**
     * @dataProvider isMessageAvailableFailsProvider
     */
    public function testIsMessageAvailableFails(?string $p1, ?string $p2, ?string $p3): void
    {
        $client = static::createClient();
        $messageService = static::$container->get(MessageService::class);

        $messageService->assignMessage('123456789', 'Test User', 'i', 'fell', 'hq');

        $client->request('GET', '/is-message-available?p1=' . $p1 . '&p2=' . $p2 . '&p3=' . $p3);
        $this->assertSame(Response::HTTP_BAD_REQUEST, $client->getResponse()->getStatusCode());

        $messageService->removeMessage('123456789');
    }

    public function isMessageAvailableFailsProvider(): array
    {
        return [
            [ null, null, null ],
            [ 'i', null, null ],
            [ null, 'fell', null ],
            [ null, null, 'hq' ],
            [ 'i', 'fell', null ],
            [ 'i', null, 'hq' ],
            [ null, 'fell', 'hq' ],
            'invalid p1' => [ 'testest', null, null ],
            'invalid p2' => [ null, 'testest', null ],
            'invalid p3' => [ null, null, 'testest' ],
        ];
    }

    public function testRandom(): void
    {
        $client = static::createClient();
        $messageService = static::$container->get(MessageService::class);

        $messageService->assignMessage('123456789', 'Test User', 'i', 'fell', 'hq');

        $client->request('GET', '/random');
        $this->assertTrue($client->getResponse()->isRedirect('/123456789'));

        $messageService->removeMessage('123456789');
    }

    public function testRandomNoMessages(): void
    {
        $client = static::createClient();

        $client->request('GET', '/random');
        $this->assertTrue($client->getResponse()->isRedirect('/'));
    }
}
