<?php

namespace App\Controller;


use App\Repository\CenterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(CenterRepository $centerRepository): Response
    {
        $bestCenter = $centerRepository->findBy([], ['name' => 'DESC']);

        return $this->render('home/index.html.twig', [
            'bestCenter' => $bestCenter
        ]);
    }
}
