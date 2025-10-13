<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use App\Repository\CenterRepository;
use App\Service\CommentFilter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

final class CenterController extends AbstractController
{
    #[Route('/center/{id}/comments', name: 'center_all_comments', requirements: ['id' => '\d+'])]
    public function allComments(
        int $id,
        Request $request,
        CenterRepository $centerRepository,
        CommentRepository $commentRepository,
        PaginatorInterface $paginator
    ): Response {
        $center = $centerRepository->find($id);

        if (!$center) {
            $this->addFlash('danger', 'Ce centre n\'existe pas.');
            return $this->redirectToRoute('app_home');
        }

        $query = $commentRepository->createQueryBuilder('c')
            ->where('c.center = :center')
            ->setParameter('center', $center)
            ->orderBy('c.publicationDate', 'DESC')
            ->getQuery();

        $comments = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            6
        );

        return $this->render('center/all_comments.html.twig', [
            'center' => $center,
            'comments' => $comments,
        ]);
    }

    #[Route('/center/{id}', name: 'app_show_center', requirements: ['id' => '\d+'])]
    public function show(
        int $id,
        Request $request,
        CenterRepository $centerRepository,
        CommentRepository $commentRepository,
        EntityManagerInterface $em,
        CommentFilter $filter
    ): Response {
        $center = $centerRepository->find($id);

        if (!$center) {
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

            $content = $comment->getContent();

            if ($filter->containsForbiddenWords($content)) {
                $this->addFlash('danger', 'Votre commentaire contient des propos inappropriés.');
                return $this->redirectToRoute('app_show_center', ['id' => $id]);
            }

            $comment
                ->setPublicationDate(new \DateTime())
                ->setUser($user)
                ->setCenter($center);
            $comment->setIsApproved(false);
            $em->persist($comment);
            $em->flush();

            $this->addFlash('success', 'Votre commentaire a été ajouté avec succès.');
            return $this->redirectToRoute('app_show_center', ['id' => $id]);
        }

        $averageRating = $commentRepository->findAverageRatingByCenter($center);
        $approvedComments = $center->getComments()->filter(fn($c) => $c->isApproved());

        return $this->render('center/show.html.twig', [
            'center' => $center,
            'averageRating' => $averageRating,
            'comments' =>  $approvedComments,
            'form' => $form->createView(),
        ]);
    }
}
