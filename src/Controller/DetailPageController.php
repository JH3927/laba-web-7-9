<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\News;
use App\Entity\User;
use App\Entity\Comments;

use App\Form\NewsFormType;
use App\Form\CommentsFormType;
use App\Form\RegistrationFormType;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class DetailPageController extends AbstractController
{
    #[Route('/news/{id}', name: 'app_detail')]
    public function index($id, ManagerRegistry $doctrine, Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, AuthenticationUtils $authenticationUtils): Response
    {
        $manager = $doctrine->getManager();
        $repository = $doctrine->getRepository(News::class);
        $newsItem = $repository->find($id);
        if($newsItem->getActive() == false){
            return $this->redirect('/');
        }
        $newsUser = $newsItem->getUser();
        if($newsUser != $this->getUser() && $this->getUser() != null)
        {
            $viewsCount = $newsItem->getViews();
            $newsItem->setViews($viewsCount + 1);
            $manager->persist($newsItem);
            $manager->flush();
        }
        $comments = $newsItem->getComments();
        $comment = new Comments();
        $currentUser = $this->getUser();
        $commentsForm = $this->createForm(CommentsFormType::class, $comment);
        $commentsForm->handleRequest($request);
        if ($commentsForm->isSubmitted() && $commentsForm->isValid())
        {
            $date = new \DateTime('@'.strtotime('now + 3 hours'));
            $comment->setDateLoad($date);
            $comment->setActive(false);
            $comment->setUser($currentUser);
            $comment->setNewsItem($newsItem);
            $entityManager->persist($comment);
            $entityManager->flush();
            return $this->redirect('/#');

        }
        return $this->render('detail/index.html.twig', [
            'i' => $newsItem,
            'comments' => $comments,
            'commentsForm' => $commentsForm->createView(),

        ]);
    }
}
