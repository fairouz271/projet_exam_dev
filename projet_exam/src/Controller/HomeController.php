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

        $searchForm = $this->createForm(CentreSearchType::class);
        $searchForm->handleRequest($request);

        $centers = [];
        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            $query = $searchForm->get('query')->getData();

            $centers = $centerRepository->findByNameOrAdress($query);

            if (count($centers) === 1) {
                $center = $centers[0];
                return $this->redirectToRoute('app_show_center', ['id' => $center->getId()]);
            } else {
                $this->addFlash('warning', 'Aucun centre trouvé avec ce nom.');
            }
        }


        $bestCenter = $centerRepository->findBy([], ['name' => 'DESC'], 12);

        return $this->render('home/index.html.twig', [
            'searchForm' => $searchForm->createView(),
            'bestCenter' => $bestCenter,
        ]);
    }
}
