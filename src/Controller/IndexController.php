<?php

namespace App\Controller;

use App\Entity\News;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(News::class);
        $news = $repository->findAll();

        $result = array_filter($news, function($i, $k) {
            return $i->getActive() == 1;
        }, ARRAY_FILTER_USE_BOTH);

        $newsClean = new ArrayCollection($result);
        return $this->render('index/index.html.twig', [
            'news' => $newsClean,
        ]);
    }
}
