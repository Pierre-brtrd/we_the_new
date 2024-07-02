<?php

namespace App\Tests\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\ORMDatabaseTool;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    private ?KernelBrowser $client = null;

    private ?ORMDatabaseTool $databaseTool = null;

    public function setUp(): void
    {
        parent::setUp();

        $this->client = self::createClient();

        $this->databaseTool = self::getContainer()->get(DatabaseToolCollection::class)->get();

        $this->databaseTool->loadAliceFixture([
            \dirname(__DIR__) . '/Fixtures/UserFixtures.yaml',
        ]);
    }

    private function getAdminUser(): User
    {
        return self::getContainer()->get(UserRepository::class)
            ->findOneBy(['email' => 'admin@test.com']);
    }

    private function getEditorUser(): User
    {
        return self::getContainer()->get(UserRepository::class)
            ->findOneBy(['email' => 'editor@test.com']);
    }

    public function testResponseLoginPage(): void
    {
        $this->client->request('GET', '/login');

        $this->assertResponseStatusCodeSame(200);
    }

    public function testLoginFormWithGoodCredentials(): void
    {
        $crawler = $this->client->request('GET', '/login');

        $form = $crawler->selectButton('Se connecter')->form([
            '_username' => 'admin@test.com',
            '_password' => 'Test1234!',
        ]);

        $this->client->submit($form);

        $this->assertResponseRedirects('/');
    }

    public function testLoginFormWithBadCredentials(): void
    {
        $crawler = $this->client->request('GET', '/login');

        $form = $crawler->selectButton('Se connecter')->form([
            '_username' => 'admin@test.com',
            '_password' => 'test',
        ]);

        $this->client->submit($form);

        $this->client->followRedirect();

        $this->assertSelectorTextContains('.alert.alert-danger', 'Identifiants invalides.');
    }

    public function testAdminUserPageWithNotConnected(): void
    {
        $this->client->request('GET', '/admin/users');

        $this->assertResponseRedirects('/login');
    }

    public function testAdminUserPageWithAdminUser(): void
    {
        $this->client->loginUser($this->getAdminUser());

        $this->client->request('GET', '/admin/users');

        $this->assertResponseStatusCodeSame(200);
    }

    public function testAdminUserPageWithEditorUser(): void
    {
        $this->client->loginUser($this->getEditorUser());

        $this->client->request('GET', '/admin/users');

        $this->assertResponseStatusCodeSame(403);
    }

    public function testResponseRegisterPage(): void
    {
        $this->client->request('GET', '/register');

        $this->assertResponseStatusCodeSame(200);
    }

    public function testSubmitRegisterFormWithGoodInformations(): void
    {
        $crawler = $this->client->request('GET', '/register');

        $form = $crawler->selectButton('S\'inscrire')->form([
            'user[firstName]' => 'test',
            'user[lastName]' => 'test',
            'user[email]' => 'test@test.com',
            'user[password][first]' => 'Test1234!',
            'user[password][second]' => 'Test1234!',
        ]);

        $this->client->submit($form);

        $this->assertResponseRedirects('/login');

        $user = self::getContainer()->get(UserRepository::class)->findOneBy(['email' => 'test@test.com']);

        $this->assertNotNull($user);
    }

    public function testSubmitRegisterFormWithBadEmail(): void
    {
        $crawler = $this->client->request('GET', '/register');

        $form = $crawler->selectButton('S\'inscrire')->form([
            'user[firstName]' => 'test',
            'user[lastName]' => 'test',
            'user[email]' => 'test',
            'user[password][first]' => 'Test1234!',
            'user[password][second]' => 'Test1234!',
        ]);

        $this->client->submit($form);

        $this->assertResponseStatusCodeSame(422);

        $this->assertSelectorTextContains('form .invalid-feedback', 'Cette valeur n\'est pas une adresse email valide.');
    }

    public function testSubmitRegisterFormWithBadPassword(): void
    {
        $crawler = $this->client->request('GET', '/register');

        $form = $crawler->selectButton('S\'inscrire')->form([
            'user[firstName]' => 'test',
            'user[lastName]' => 'test',
            'user[email]' => 'test@test.com',
            'user[password][first]' => 'test',
            'user[password][second]' => 'test',
        ]);

        $this->client->submit($form);

        $this->assertResponseStatusCodeSame(422);

        $this->assertSelectorTextContains('form .invalid-feedback', 'Votre mot de passe doit contenir au moins une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial, et faire plus de 8 caractères.');
    }

    public function tearDown(): void
    {
        parent::tearDown();

        $this->databaseTool = null;
        $this->client = null;
    }
}
