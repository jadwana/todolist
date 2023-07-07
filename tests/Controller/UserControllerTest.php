<?php

namespace App\Tests\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class UserControllerTest extends WebTestCase
{
    use SetUpTrait;

    public function testListUser()
    {
        // Testing user access
        $this->client->loginUser($this->testUser);
        $this->client->request(Request::METHOD_GET,$this->urlGenerator->generate('user_list'));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
        // Testing admin access
        $this->client->loginUser($this->testAdmin);
        $this->client->request(Request::METHOD_GET,$this->urlGenerator->generate('user_list'));
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextContains('h1','Liste des utilisateurs');
    }


    public function testCreateUser()
    {
        // Testing user access
        $this->client->loginUser($this->testUser);
        $this->client->request(Request::METHOD_GET,$this->urlGenerator->generate('user_create'));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
        // Testing admin access
        $this->client->loginUser($this->testAdmin);
        $crawler = $this->client->request(Request::METHOD_GET,$this->urlGenerator->generate('user_create'));
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextContains('h1','Créer un utilisateur');
        // Testing adding new user
        $form = $crawler->selectButton('Ajouter')->form();
        $form['user[username]'] = 'autre';
        $form['user[password][first]'] = 'autre';
        $form['user[password][second]'] = 'autre';
        $form['user[email]'] = 'autre@autre.org';
        $form['user[roles][1]']->tick();
        $this->client->submit($form);

       
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $this->client->followRedirect();

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextContains('div.alert.alert-success','L\'utilisateur a bien été ajouté.');

    }

    public function testEditUser()
    {
        // Testing user access
        $this->client->loginUser($this->testUser);
        $this->testUserId = $this->testUser->getId();
        $this->client->request(Request::METHOD_GET,$this->urlGenerator->generate('user_edit',['id' => $this->testUserId]));
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
        // Testing admin access
        $this->client->loginUser($this->testAdmin);
        $this->client->request(Request::METHOD_GET,$this->urlGenerator->generate('user_edit',['id' => $this->testUserId] ));
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        // Testing updating user
        $this->client->submitForm('Modifier', [

            'user[username]' => 'testmodif',
            'user[password][first]' => '123',
            'user[password][second]' => '123',
            'user[email]' => 'modif@test.fr',
        ]);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $this->assertResponseRedirects();
        $this->client->followRedirect();

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextContains('div.alert.alert-success','L\'utilisateur a bien été modifié');
    }


}