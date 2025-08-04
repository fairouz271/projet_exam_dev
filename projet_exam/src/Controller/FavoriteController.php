<?php

namespace App\Controller;

use App\Entity\Center;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\SecurityBundle\Security;





final class FavoriteController extends AbstractController
{
    #[Route('/center/{id}/toggle-favorite', name: 'center_toggle_favorite')]
    public function toggleFavorite(
        Center $center,
        EntityManagerInterface $em,
        Security $security
    ): Response {
        /** @var User|null $user */
        $user = $security->getUser();

        if (!$user) {
            $this->addFlash('danger', 'Vous devez être connecté pour ajouter un favori.');
            return $this->redirectToRoute('app_login');
        }

        if ($user->getFavoriteCenters()->contains($center)) {
            $user->removeFavoriteCenter($center);
            $this->addFlash('info', 'Centre retiré des favoris.');
        } else {
            $user->addFavoriteCenter($center);
            $this->addFlash('success', 'Centre ajouté aux favoris.');
        }

        $em->flush();

        return $this->redirectToRoute('app_show_center',['id' => $center->getId()]);
    }

#[Route('/mes-favoris', name: 'user_favorites')]
public function myFavorites(Security $security): Response
{
    /** @var User|null $user */
    $user = $security->getUser();

    if (!$user) {
        $this->addFlash('danger', 'Vous devez être connecté pour voir vos favoris.');
        return $this->redirectToRoute('app_login');
    }

    $favorites = $user->getFavoriteCenters();

    return $this->render('favorite/my_favorites.html.twig', [
        'favorites' => $favorites,
    ]);
}
}
