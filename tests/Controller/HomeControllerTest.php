<?php

namespace App\Tests\Controller;

use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\ORMDatabaseTool;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{
    private ?KernelBrowser $client = null;

    private ?ORMDatabaseTool $databaseTool = null;

    public function setUp(): void
    {
        parent::setUp();

        $this->client = self::createClient();

        $this->databaseTool = self::getContainer()->get(DatabaseToolCollection::class)->get();

        $this->databaseTool->loadAliceFixture([
            \dirname(__DIR__) . '/Fixtures/ProductFixtures.yaml',
        ]);
    }

    public function testHomePageResponse(): void
    {
        $this->client->request('GET', '/');

        $this->assertResponseStatusCodeSame(200);
    }

    public function testCountProductHomePage(): void
    {
        $crawler = $this->client->request('GET', '/');

        $this->assertCount(4, $crawler->filter('.card-product'));
    }

    public function tearDown(): void
    {
        parent::tearDown();

        $this->client = null;
    }
}
