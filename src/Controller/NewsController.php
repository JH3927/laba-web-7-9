<?php

namespace App\Controller;

use App\Entity\News;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;

use Doctrine\Persistence\ManagerRegistry;
use App\Form\NewsFormType;
use Symfony\Component\String\Slugger\SluggerInterface;
class NewsController extends AbstractController
{
    #[Route('/createNews', name: 'app_create_news')]
    public function register(ManagerRegistry $doctrine, Request $request, SluggerInterface $slugger): Response
    {
        if ($this->getUser() == null ) {
            return $this->redirectToRoute('app_auth');
       }
        $newsItem = new News();
        $form = $this->createForm(NewsFormType::class, $newsItem);
        $form->handleRequest($request);
        $user = $this->getUser();
        if ($form->isSubmitted() && $form->isValid()) {
            $newsItem = $form->getData();
            $date = new \DateTime('@'.strtotime('now + 3 hours'));
            $newsItem->setDate($date);
            $newsItem->setViews(0);
            $newsItem->setUser($user);
            $filename = $form->get('fotopath')->getData();
            if ($filename) {
                $originalFilename = pathinfo($filename->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$filename->guessExtension();
                try {
                    $filename->move(
                        $this->getParameter('newsfoto_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    return $this->render('Forms/News-form/index.html.twig', [
                        'form' => $form->createView(),
                    ]);
                }
                $newsItem->setfotopath($newFilename);
            }
            $manager = $doctrine->getManager();
            $manager->persist($newsItem);
            $manager->flush();
            return $this->redirectToRoute('app_index');
        }
        return $this->render('Forms/News-form/index.html.twig', [
            'createNewsForm' => $form->createView(),
        ]);
    }
}
