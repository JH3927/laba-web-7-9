<?php

namespace App\Controller\Admin;

use App\Entity\Comments;
use App\Entity\News;
use App\Entity\User;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;


class DashboardController extends AbstractDashboardController
{

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $isGranted = $this->isGranted('ROLE_ADMIN');


        if (!$isGranted)
            return $this->redirect('/');


        $routeBuilder = $this->container->get(AdminUrlGenerator::class);
        $url = $routeBuilder->setController(NewsCrudController::class)->generateUrl();

        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Laba8');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToRoute('Назад к сайту', 'fa fa-home', 'app_index');
        yield MenuItem::linkToCrud('Новости', 'fas fa-globe', News::class);
        yield MenuItem::linkToCrud('Пользователи', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('Комментарии', 'fas fa-comments', Comments::class);
    }
}
