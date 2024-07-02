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

    public function testRegisterWithGoodCredentials(): void
    {
        $crawler = $this->client->request('GET', '/register');

        $form = $crawler->selectButton("S'inscrire")->form([
            'user[firstName]' => 'John',
            'user[lastName]' => 'Doe',
            'user[email]' => 'johnnyyy@test.com',
            'user[password][first]' => 'John1234_!',
            'user[password][second]' => 'John1234_!',
        ]);

        $this->client->submit($form);

        $user = self::getContainer()->get(UserRepository::class)
            ->findOneBy(['email' => 'johnnyyy@test.com']);
        
        $this->assertNotNull($user);

        $this->assertResponseRedirects('/login');
    }

    public function testRegisterFormWithWrongPasswords(): void
    {
        $crawler = $this->client->request('GET', '/register');

        $form = $crawler->selectButton("S'inscrire")->form([
            'user[firstName]' => 'az',
            'user[lastName]' => 'az',
            'user[email]' => 'az@test.com',
            'user[password][first]' => 'as',
            'user[password][second]' => 'a',
        ]);

        $this->client->submit($form);

        $this->assertSelectorTextContains('.invalid-feedback', 'Les mots de passe doivent être identiques.');
    }

    public function testRegisterFormWithMatchingPasswordsAndWrongCaracters(): void
    {
        $crawler = $this->client->request('GET', '/register');

        $form = $crawler->selectButton("S'inscrire")->form([
            'user[firstName]' => 'azzaeeee',
            'user[lastName]' => 'azzaezae',
            'user[email]' => 'azzzeee@test.com',
            'user[password][first]' => 'anthony42',
            'user[password][second]' => 'anthony42',
        ]);

        $this->client->submit($form);

        $this->assertSelectorTextContains('.invalid-feedback',  'Votre mot de passe doit contenir au moins une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial, et faire plus de 8 caractères.');
    }
    // Cette valeur n'est pas une adresse email valide.
    public function testRegisterFormWithBadEmail(): void
    {
        $crawler = $this->client->request('GET', '/register');

        $form = $crawler->selectButton("S'inscrire")->form([
            'user[firstName]' => 'az',
            'user[lastName]' => 'az',
            'user[email]' => 'aztest.com',
            'user[password][first]' => 'as',
            'user[password][second]' => 'as',
        ]);

        $this->client->submit($form);

        $this->assertResponseStatusCodeSame(422);
        
        $this->assertSelectorTextContains('.invalid-feedback', 'Cette valeur n\'est pas une adresse email valide.');
    }

    public function tearDown(): void
    {
        parent::tearDown();

        $this->databaseTool = null;
        $this->client = null;
    }
}