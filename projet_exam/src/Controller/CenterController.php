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
    #[Route('/center/{id}/comments', name: 'center_all_comments', requirements: ['id' => '\d+'])]
    public function allComments(
        int $id,
        CenterRepository $centerRepository,
        CommentRepository $commentRepository
    ): Response {
        $center = $centerRepository->find($id);
        if (!$center) {
            $this->addFlash('danger', 'Ce centre n\'existe pas.');
            return $this->redirectToRoute('app_home');
        }

        $comments = $commentRepository->findBy(
            ['center' => $center],
            ['publicationDate' => 'DESC']
        );

        return $this->render('center/all_comments.html.twig', [
            'center' => $center,
            'comments' => $comments,
        ]);
    }
    #[Route('/center/{id}', name: 'app_show_center',requirements: ['id' => '\d+'])]
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
            $this->addFlash('danger', 'Ce centre n\'existe pas !');
            return $this->redirectToRoute('app_home');
        }
        $comment = new Comment();
        $user = $this->getUser();


        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);



        if ($form->isSubmitted() && $form->isValid()) {
            if (!$user) {
                $this->addFlash('warning', 'Vous devez être connecté pour commenter.');
                return $this->redirectToRoute('app_login');
            }
            $comment->setPublicationDate(new \DateTime());
            $comment->setUser($user);
            $comment->setCenter($center);


            $em->persist($comment);
            $em->flush();

            $this->addFlash('success', 'Ajout de commentaire réussie !');


            return $this->redirectToRoute('app_show_center', ['id' => $id]);
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
