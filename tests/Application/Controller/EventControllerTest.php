<?php

namespace App\Tests\Application\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EventControllerTest extends WebTestCase
{
    public function testListDisplayPage(): void
    {
        $client = static::createClient();
        $client->request('GET', '/en/back-office/event/list');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('body .table');
    }

    public function testCreateDisplayPage(): void
    {
        $client = static::createClient();
        $client->request('GET', '/en/back-office/event/create');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('body .form-group');
    }

    public function testShowDisplayPage(): void
    {
        $client = static::createClient();
        $client->request('GET', '/en/event/1');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('body .event');
    }

    public function testEditDisplayPage(): void
    {
        $client = static::createClient();
        $client->request('GET', '/en/back-office/event/1/edit');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('body .form-group');
    }

    public function testCreateSubmitFormSuccess(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/en/back-office/event/create');

        $this->assertResponseIsSuccessful();

        $form = $crawler->selectButton('Submit')->form([
            'event[name]' => 'My test event',
            'event[program]' => 'My test event program',
            'event[startDate]' => (new \DateTime('now'))->format('Y-m-d H:i:s'),
            'event[endDate]' => (new \DateTime('now + 1 hour'))->format('Y-m-d H:i:s'),
        ]);

        $client->submit($form);

        $this->assertResponseRedirects('/en/back-office/event/list');
        $client->followRedirect();

        $this->assertSelectorTextContains('.alert--success', 'Success');
        $this->assertSelectorExists('body .table');
    }
}
