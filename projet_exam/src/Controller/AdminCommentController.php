<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/comments')]
class AdminCommentController extends AbstractController
{
    #[Route('/', name: 'admin_comments_list')]
    public function index(CommentRepository $commentRepository): Response
    {
        $comments = $commentRepository->findBy([], ['publicationDate' => 'DESC']);

        return $this->render('admin/comments/index.html.twig', [
            'comments' => $comments,
        ]);
    }

    #[Route('/approve/{id}', name: 'admin_comment_approve')]
    public function approve(Comment $comment, EntityManagerInterface $em): Response
    {
        $comment->setIsApproved(true);
        $em->flush();

        $this->addFlash('success', 'Commentaire approuvé !');
        return $this->redirectToRoute('admin_comments_list');
    }

    #[Route('/delete/{id}', name: 'admin_comment_delete')]
    public function delete(Comment $comment, EntityManagerInterface $em): Response
    {
        $em->remove($comment);
        $em->flush();

        $this->addFlash('info', 'Commentaire supprimé.');
        return $this->redirectToRoute('admin_comments_list');
    }
}
