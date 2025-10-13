<?php
namespace App\Controller;

use App\Form\CentreSearchType;
use App\Repository\CenterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class HomeController extends AbstractController
{
#[Route('/', name: 'app_home')]
public function index(Request $request, CenterRepository $centerRepository): Response
{
// Créer le formulaire de recherche
$searchForm = $this->createForm(CentreSearchType::class);
$searchForm->handleRequest($request);
    if ($searchForm->isSubmitted() && $searchForm->isValid()) {
        $query = $searchForm->get('query')->getData();

        // Cherche le centre par nom exact
        $center = $centerRepository->findOneBy(['name' => $query]);

        if ($center) {
            // Redirection vers la page show center
            return $this->redirectToRoute('app_show_center', ['id' => $center->getId()]);
        } else {
            $this->addFlash('warning', 'Aucun centre trouvé avec ce nom.');
        }
    }

// Récupérer les centres (ici les 8 meilleurs pour l'exemple)
$bestCenter = $centerRepository->findBy([], ['name' => 'DESC'], 8);

return $this->render('home/index.html.twig', [
'searchForm' => $searchForm->createView(),
'bestCenter' => $bestCenter,
]);
}
}
