<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Task;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
   
    
    public function __construct(
        private UserPasswordHasherInterface $passwordEncoder,
    ) {
    }

    public function load(ObjectManager $manager): void
    {   
        $faker = Faker\Factory::create('fr_FR');
        // Admin
        $admin = new User();
        $admin->setEmail('admin@demo.fr');
        $admin->setUsername('admin');
        $admin->setPassword(
            $this->passwordEncoder->hashPassword($admin, 'admin')
        );
        $admin->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);

        // User
        $user = new User;
        $user->setEmail('user@user.fr');
        $user->setUsername('user');
        $user->setRoles(['ROLE_USER']);
        $user->setPassword(
            $this->passwordEncoder->hashPassword($user, 'user')
        );
        $manager->persist($user);

        // Other user
        $other = new User;
        $other->setEmail('otheruser@user.fr');
        $other->setUsername('other');
        $other->setRoles(['ROLE_USER']);
        $other->setPassword(
            $this->passwordEncoder->hashPassword($other, 'other')
        );
        $manager->persist($other);


        // Tasks
        for($i=0;$i<3;$i++){
            $task = new Task();
            $task->setUser($user);
            $task->setTitle($faker->sentence());
            $task->setContent($faker->text(500));
            $task->setCreatedAt(new \DateTimeImmutable());
            $task->isDone();
            $task->toggle(boolval(rand(0,1)));
            $manager->persist($task);
        }

        for($i=0;$i<3;$i++){
            $task = new Task();
            $task->setUser($other);
            $task->setTitle($faker->sentence());
            $task->setContent($faker->text(500));
            $task->setCreatedAt(new \DateTimeImmutable());
            $task->isDone();
            $task->toggle(boolval(rand(0,1)));
            $manager->persist($task);
        }

        for($i=0;$i<3;$i++){
            $task = new Task();
            // $task->setUser($other);
            $task->setTitle($faker->sentence());
            $task->setContent($faker->text(500));
            $task->setCreatedAt(new \DateTimeImmutable());
            $task->isDone();
            $task->toggle(boolval(rand(0,1)));
            $manager->persist($task);
        }

        $manager->flush();
    }
}
