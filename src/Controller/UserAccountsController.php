<?php

namespace App\Controller;

use App\Entity\Cities;
use App\Entity\User;
use App\Form\CitiesType;
use App\Form\UserAccountsAirlineType;
use App\Form\UserAccountsType;
use App\Repository\CitiesRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/userAccount')]
final class UserAccountsController extends AbstractController
{
    #[Route(name: 'app_user_accounts_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('admin/templates/user_accounts/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_accounts_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserAccountsType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $isAirline = in_array('ROLE_AIRLINE', $user->getRoles());
            if ($isAirline) {
                return $this->redirectToRoute('app_user_accounts_edit_set_airline', ['id' => $user->getId()], Response::HTTP_SEE_OTHER);
            }
            return $this->redirectToRoute('app_user_accounts_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/templates/user_accounts/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit/setAirline', name: 'app_user_accounts_edit_set_airline', methods: ['GET', 'POST'])]
    public function setAirline(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserAccountsAirlineType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('app_user_accounts_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/templates/user_accounts/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }


    #[Route('/{id}', name: 'app_user_accounts_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_accounts_index', [], Response::HTTP_SEE_OTHER);
    }
}
