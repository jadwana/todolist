<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
    #[Route('/users', name: 'user_list')]
    #[IsGranted('ROLE_ADMIN', message: 'Vous ne pouvez pas accéder à cette page!')]
    /**
     * Show the list of users
     *
     * @param UserRepository $userRepository
     * @return Response
     */
    public function listUser(UserRepository $userRepository): Response
    {
        return $this->render('user/list.html.twig', [
            'users' => $userRepository->findAll()
        ]);
    }

    #[Route('/users/create', name: 'user_create')]
    #[IsGranted('ROLE_ADMIN', message: 'Vous ne pouvez pas accéder à cette page!')]
    /**
     * Create user
     *
     * @param Request $request
     * @param EntityManagerInterface $EntityManage
     * @param UserPasswordHasherInterface $userPasswordHasher
     * @return void
     */
    public function createUser(
        Request $request,
        EntityManagerInterface $EntityManage,
        UserPasswordHasherInterface $userPasswordHasher
    ) {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            $EntityManage->persist($user);
            $EntityManage->flush();

            $this->addFlash('success', "L'utilisateur a bien été ajouté.");

            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/create.html.twig', ['form' => $form->createView()]);
    }

    #[Route('/users/{id}/edit', name: 'user_edit')]
    #[IsGranted('ROLE_ADMIN', message: 'Vous ne pouvez pas accéder à cette page!')]
    /**
     * Update user
     *
     * @param User $user
     * @param Request $request
     * @param UserPasswordHasherInterface $userPasswordHasher
     * @param EntityManagerInterface $EntityManage
     * @return void
     */
    public function editUser(
        User $user,
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        EntityManagerInterface $EntityManage
    ) {
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassWord(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $EntityManage->persist($user);
            $EntityManage->flush();

            $this->addFlash('success', "L'utilisateur a bien été modifié");

            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/edit.html.twig', ['form' => $form->createView(), 'user' => $user]);
    }
}
