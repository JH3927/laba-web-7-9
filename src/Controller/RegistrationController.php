<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

class RegistrationController extends AbstractController
{
    #[Route('/registration', name: 'app_registration')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $newUser = new User();
        $form = $this->createForm(RegistrationFormType::class, $newUser);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $newUser->setPassword(
            $userPasswordHasher->hashPassword(
                    $newUser,
                    $form->get('plainPassword')->getData()
                )
            );
            $newUser->setRoles([
                'ROLE_USER'
            ]);

            $newUser->setApiToken(Uuid::v1()->toRfc4122());
            $entityManager->persist($newUser);
            $entityManager->flush();
            return $this->redirect('/');
        }
        return $this->render('registration/registration.html.twig', [
            'formregistration' => $form->createView(),
        ]);
    }
}
