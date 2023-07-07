<?php

namespace App\Controller;

use App\Entity\Task;
use AppBundle\Form\TaskType;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TaskController extends AbstractController
{
    #[Route('/tasks', name: 'task_list')]
    #[IsGranted('ROLE_USER', message: 'Vous ne pouvez pas accéder à cette page!')]
    public function listTask(TaskRepository $taskRepository): Response
    {
        return $this->render('task/list.html.twig', [
            'tasks' => $taskRepository->findAll()
        ]);
    }

    #[Route('/tasks/create', name: 'task_create')]
    #[IsGranted('ROLE_USER', message: 'Vous ne pouvez pas accéder à cette page!')]
    public function createTask(Request $request, EntityManagerInterface $entityManager)
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task->setUser($this->getUser());
            $entityManager->persist($task);
            $entityManager->flush();

            $this->addFlash('success', 'La tâche a été bien été ajoutée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/create.html.twig', ['form' => $form->createView()]);
    }
   
    #[Route('/tasks/{id}/edit', name: 'task_edit')]
    #[IsGranted('ROLE_USER', message: 'Vous ne pouvez pas accéder à cette page!')]
    public function editTask(Task $task, Request $request, EntityManagerInterface $entityManager)
    {
        $this->denyAccessUnlessGranted('TASK_EDIT', $task);
        
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($task);
            $entityManager->flush();

            $this->addFlash('success', 'La tâche a bien été modifiée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/edit.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
        ]);
    }

    #[Route('/tasks/{id}/toggle', name: 'task_toggle')]
    #[IsGranted('ROLE_USER', message: 'Vous ne pouvez pas accéder à cette page!')]
    public function toggleTask(Task $task, EntityManagerInterface $entityManager)
    {
        $task->toggle(!$task->isDone());
        $entityManager->persist($task);
        $entityManager->flush();

        $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle()));

        return $this->redirectToRoute('task_list');
    }

    #[Route('/tasks/{id}/delete', name: 'task_delete')]
    #[IsGranted('ROLE_USER', message: 'Vous ne pouvez pas accéder à cette page!')]
    public function deleteTask(Task $task, EntityManagerInterface $entityManager)
    {
        $this->denyAccessUnlessGranted('TASK_DELETE', $task);
        
            $entityManager->remove($task);
            $entityManager->flush();
            $this->addFlash('success', 'La tâche a bien été supprimée.');
            return $this->redirectToRoute('task_list');
        
    }
}
