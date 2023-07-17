<?php


namespace App\Tests\Controller;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{

    use SetUpTrait;

    public function testHomepage()
    {
        $crawler = $this->client->request(Request::METHOD_GET,$this->urlGenerator->generate('homepage'));
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextContains('h1','Bienvenue sur Todo List, l\'application vous permettant de gérer l\'ensemble de vos tâches sans effort !');
        $this->assertSelectorTextContains('a.btn.btn-success', 'Se connecter');
        $this->assertSame(1, $crawler->filter('a.btn')->count());
        $this->client->clickLink('Se connecter');
        $this->assertSelectorTextContains('h1','Connectez-vous');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testHomepageWithUser()
    {
        $this->client->loginUser($this->testUser);
        $crawler = $this->client->request(Request::METHOD_GET,$this->urlGenerator->generate('homepage'));
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextContains('a.btn.btn-danger', 'Se déconnecter');
        $this->assertSame(5, $crawler->filter('a.btn')->count());
        
    }

    public function testHomepageLinkCreateTask()
    {
        $this->client->loginUser($this->testUser);
        $this->client->request(Request::METHOD_GET,$this->urlGenerator->generate('homepage'));
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->client->clickLink('Créer une tâche');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextContains('a.btn.btn-primary', 'Retour à la liste des tâches');
    }

    public function testHomepageLinkTaskList()
    {
        $this->client->loginUser($this->testUser);
        $this->client->request(Request::METHOD_GET,$this->urlGenerator->generate('homepage'));
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->client->clickLink('Consulter les tâches');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextContains('h3', 'Liste de toutes les tâches');
    }

    public function testHomepageLinkTaskFinish()
    {
        $this->client->loginUser($this->testUser);
        $this->client->request(Request::METHOD_GET,$this->urlGenerator->generate('homepage'));
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->client->clickLink('Consulter les tâches terminées');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextContains('h3', 'Liste des tâches terminées');
    }

    public function testHomepageLinkTaskUnfinish()
    {
        $this->client->loginUser($this->testUser);
        $this->client->request(Request::METHOD_GET,$this->urlGenerator->generate('homepage'));
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->client->clickLink('Consulter les tâches à faire');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextContains('h3', 'Liste des tâches à faire');
    }

    public function testHomepageWithAdmin()
    {
        $this->client->loginUser($this->testAdmin);
        $crawler = $this->client->request(Request::METHOD_GET,$this->urlGenerator->generate('homepage'));
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextContains('a.btn.btn-primary', 'Gestion des utilisateurs');
        $this->assertSame(6, $crawler->filter('a.btn')->count());
        
    }
}