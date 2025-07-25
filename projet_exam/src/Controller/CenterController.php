<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use App\Repository\CenterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManager;

final class CenterController extends AbstractController
{
    #[Route('/center/{id}', name: 'app_show_center')]
    public function show(
        int                    $id,
        Request                $request,
        CenterRepository       $centerRepository,
        CommentRepository      $commentRepository,
        EntityManagerInterface $em

    ): Response
    {
        $center = $centerRepository->findOneBy(['id' => $id]);
        if ($center === null) {
            $this->addFlash('danger', 'Ce centre n\existe pas !');
            return $this->redirectToRoute('app_home');
        }
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute('app_chow_center', ['id' => $id]);
        }
        $averageRating = $commentRepository->findAverageRatingByCenter($center);


        return $this->render('center/show.html.twig', [
            'center' => $center,
            'averageRating' => $averageRating,
            'comments' => $center->getComments(),
            'form' => $form->createView(),

        ]);
    }
}
