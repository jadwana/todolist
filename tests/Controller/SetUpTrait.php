<?php

namespace App\Tests\Controller;

use App\Entity\Task;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

trait SetUpTrait
{
    private KernelBrowser|null $client = null;
    
    protected function setUp(): void
    {
        $this->client= static::createClient();
        $this->userRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);
        $this->testAdmin = $this->userRepository->findOneByUsername('admin');
        $this->testUser = $this->userRepository->findOneByUsername('user');
        $this->testOtherUser = $this->userRepository->findOneByUsername('');
        $this->urlGenerator = $this->client->getContainer()->get('router.default');
        $this->taskRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(Task::class);
        $this->testTask = $this->taskRepository->findOneBy(['user' => $this->testUser]);
        $this->testOtherTask = $this->taskRepository->findOneBy(['user' => $this->testOtherUser]);
        $this->testOtherTaskId = $this->testOtherTask->getId();
        $this->testTaskId = $this->testTask->getId();
    }
}