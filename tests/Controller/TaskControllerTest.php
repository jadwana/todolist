<?php

namespace App\Tests\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{
    use SetUpTrait;

    public function testListTask()
    {
        // Testing user access
        $this->client->loginUser($this->testUser);
        $this->client->request(Request::METHOD_GET,$this->urlGenerator->generate('task_list'));
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        // Testing admin access
        $this->client->loginUser($this->testAdmin);
        $crawler = $this->client->request(Request::METHOD_GET,$this->urlGenerator->generate('task_list'));
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSame(1, $crawler->filter('html:contains("Créer une tâche")')->count());
    }

    public function testCreateTask()
    {
        // Testing user access
        $this->client->loginUser($this->testUser);
        $this->client->request(Request::METHOD_GET,$this->urlGenerator->generate('task_create'));
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        
        // Testing adding new task
        $this->client->submitForm('Ajouter', [
            'task[title]' => 'titre',
            'task[content]' => 'contenu',
        ]);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $this->client->followRedirect();

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextContains('div.alert-success','La tâche a été bien été ajoutée.');

    }

    public function testEditTask()
    {
        // Testing user access
        $this->client->loginUser($this->testUser);
        $this->client->request(Request::METHOD_GET,$this->urlGenerator->generate('task_edit',['id' => $this->testTaskId]));
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        // Testing updating task
        $this->client->submitForm('Modifier', [
            'task[title]' => 'titre',
            'task[content]' => 'contenu',
        ]);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $this->assertResponseRedirects();
        $this->client->followRedirect();

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextContains('div.alert.alert-success','La tâche a bien été modifiée.');
    }

    public function testToggleTask()
    {
        $this->client->loginUser($this->testUser);
        $this->client->request(Request::METHOD_GET,$this->urlGenerator->generate('task_toggle',['id' => $this->testTaskId]));
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $this->assertResponseRedirects();
        $this->client->followRedirect();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorcount(1, 'div.alert-success');
    }

    public function testUserDeleteHisTask()
    {
        $this->client->loginUser($this->testUser);
        $this->client->request(Request::METHOD_GET,$this->urlGenerator->generate('task_delete',['id' =>$this->testTaskId]));
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $this->assertResponseRedirects();
        $this->client->followRedirect();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorcount(1, 'div.alert-success');
    }

    public function testUserDeleteNotHisTask()
    {
        $this->client->loginUser($this->testUser);
        $this->client->request(Request::METHOD_GET,$this->urlGenerator->generate('task_delete',['id' =>$this->testOtherTaskId]));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
       
    }

    public function testAdminDeleteAnonymousTask()
    {
        $this->client->loginUser($this->testAdmin);
        $this->testAnonymousTask = $this->taskRepository->findOneBy(['user' => null]);
        $this->testAnonymousTaskId = $this->testAnonymousTask->getId();
        $this->client->request(Request::METHOD_GET,$this->urlGenerator->generate('task_delete',['id' =>$this->testAnonymousTaskId]));
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $this->assertResponseRedirects();
        $this->client->followRedirect();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorcount(1, 'div.alert-success');
    }

}