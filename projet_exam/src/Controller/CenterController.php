<?php

namespace App\Controller;


use App\Repository\CommentRepository;
use App\Repository\CenterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CenterController extends AbstractController
{
    #[Route('/center/{id}', name: 'app_show_center')]
    public function show(
        int $id,
        CenterRepository $centerRepository,
        CommentRepository $commentRepository,

    ): Response
    {
        $center = $centerRepository->findOneBy(['id' => $id]);
        if ($center === null) {
            $this->addFlash('danger', 'Ce centre n\existe pas !');
            return $this->redirectToRoute('app_home');
        }
        $comments = $center->getComments();
        $averageRating = $commentRepository->findAverageRatingByCenter($center);

        return $this->render('center/show.html.twig', [
            'center' => $center,
            'averageRating' => $averageRating,
            'comments' => $center->getComments(),
        ]);
    }
}
