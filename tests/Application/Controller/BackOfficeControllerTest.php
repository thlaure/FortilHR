<?php

namespace App\Tests\Application\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BackOfficeControllerTest extends WebTestCase
{
    public function testBackOfficeHomepage(): void
    {
        $client = static::createClient();
        $client->request('GET', '/en/back-office');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('body .main-container.backoffice');
    }
}
