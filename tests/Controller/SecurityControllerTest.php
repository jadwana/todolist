<?php


namespace App\Tests\Controller;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{

    use SetUpTrait;

    public function testLoginpage()
    {
        $this->client->request(Request::METHOD_GET,$this->urlGenerator->generate('app_login'));
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextContains('h1','Connectez-vous');
    }    

     public function testLoginOk()
    {
        $this->client->request(Request::METHOD_GET,$this->urlGenerator->generate('app_login'));
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->client->submitForm('Se connecter', [
            'username' => 'user',
            'password' => 'user',
        ]);
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $this->assertResponseRedirects();
        $this->client->followRedirect();

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSelectorTextContains('h1','Bienvenue sur Todo List, l\'application vous permettant de gérer l\'ensemble de vos tâches sans effort !');
     }

     public function testLoginKo()
     {
         $this->client->request(Request::METHOD_GET,$this->urlGenerator->generate('app_login'));
         $this->assertResponseStatusCodeSame(Response::HTTP_OK);
         $this->client->submitForm('Se connecter', [
             'username' => 'user',
             'password' => 'bad',
         ]);
         $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
         $this->assertResponseRedirects();
         $this->client->followRedirect();
 
         $this->assertResponseStatusCodeSame(Response::HTTP_OK);
         $this->assertSelectorExists('.alert-danger');
      }

      public function testLoginOut()
      {
        $this->client->loginUser($this->testUser);
        $this->client->request(Request::METHOD_GET,$this->urlGenerator->generate('app_logout'));
        
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
      }
    
}