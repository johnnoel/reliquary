<?php

declare(strict_types=1);

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndexExists(): void
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function testBodyReportExists(): void
    {
        $client = static::createClient();
        $client->request('GET', '/123456789');

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function testChooseMessageExists(): void
    {
        $client = static::createClient();
        $client->request('GET', '/choose-message');

        $this->assertTrue($client->getResponse()->isSuccessful());
    }
}
