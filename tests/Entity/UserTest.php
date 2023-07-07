<?php


namespace App\Tests\Entity;


use App\Entity\Task;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserTest extends WebTestCase
{
    private $user;
    private $task;

    public function setUp(): void
    {
        $this->user = new User();
        $this->task = new Task();
    }

    public function testId(): void
    {
        $this->assertNull($this->user->getId());
    }

    public function testUsername(): void
    {
        $this->user->setUsername('pseudo');
        $this->assertSame('pseudo', $this->user->getUsername());
        $this->assertSame('pseudo', $this->user->getUserIdentifier());
    }

    public function testPassword(): void
    {
        $this->user->setPassword('123');
        $this->assertSame('123', $this->user->getPassword());
    }

    

    public function testEmail(): void
    {
        $this->user->setEmail('test@mail.fr');
        $this->assertSame('test@mail.fr', $this->user->getEmail());
    }

    public function testRoles(): void
    {
        $this->user->setRoles(['ROLE_USER']);
        $this->assertSame(['ROLE_USER'], $this->user->getRoles());
    }

    public function testTask()
    {
        $this->user->addTask($this->task);
        $this->assertCount(1, $this->user->getTask());

        $tasks = $this->user->getTask();
        $this->assertSame($this->user->getTask(), $tasks);

        $this->user->removeTask($this->task);
        $this->assertCount(0, $this->user->getTask());
    }

    public function testEraseCredentials(): void
    {
        $this->assertNull($this->user->eraseCredentials());
    }

    
}