<?php

namespace App\Controller;

use App\Entity\Center;
use App\Entity\Adress;
use App\Form\CenterType;
use App\Repository\CenterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/center')]
class AdminCenterController extends AbstractController
{
    #[Route('/', name: 'admin_center_index')]
    public function index(CenterRepository $centerRepository): Response
    {
        $centers = $centerRepository->findAll();

        return $this->render('admin_center/index.html.twig', [
            'centers' => $centers,
        ]);
    }

    #[Route('/new', name: 'admin_center_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $center = new Center();
        $form = $this->createForm(CenterType::class, $center);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Création automatique de l'adresse à partir des champs non mappés
            $adress = new Adress();
            $adress->setAdress($form->get('adress_adress')->getData());
            $adress->setLongitude($form->get('adress_longitude')->getData());
            $adress->setAltitude($form->get('adress_altitude')->getData());

            $center->setAdress($adress);
            $imageFile = $form->get('imagePath')->getData();
            if ($imageFile) {
                $newFilename = uniqid('center_') . '.' . $imageFile->guessExtension();
                $imageFile->move(
                    $this->getParameter('centers_directory'), // public/uploads/centers
                    $newFilename
                );
                $center->setImagePath($newFilename);
            }

            // Persistance : cascade persist sur Center s'occupe de l'adresse
            $em->persist($center);
            $em->flush();

            $this->addFlash('success', 'Centre ajouté avec succès !');
            return $this->redirectToRoute('admin_center_index');
        }

        return $this->render('admin_center/new_center.html.twig', [
            'form' => $form->createView(),
            'center' => $center,
        ]);
    }


    #[Route('/{id}', name: 'admin_center_show')]
    public function show(Center $center): Response
    {
        return $this->render('admin_center/show_center.html.twig', [
            'center' => $center,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_center_edit')]
    public function edit(Request $request, Center $center, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(CenterType::class, $center);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $imageFile = $form->get('imagePath')->getData();

            if ($imageFile) {
                // Génération d’un nom unique
                $newFilename = uniqid('center_') . '.' . $imageFile->guessExtension();

                // Déplacement du fichier dans le dossier uploads/centers
                $imageFile->move(
                    $this->getParameter('centers_directory'),
                    $newFilename
                );

                // Mise à jour du nom du fichier dans l'entité
                $center->setImagePath($newFilename);
            }


            $em->flush();
            $this->addFlash('success', 'Centre modifié avec succès !');

            return $this->redirectToRoute('admin_center_index');
        }

        return $this->render('admin_center/edit_center.html.twig', [
            'form' => $form->createView(),
            'center' => $center,
            'submitLabel' => 'Modifier',
        ]);
    }


    #[Route('/{id}/delete', name: 'admin_center_delete', methods: ['POST'])]
    public function delete(Request $request, Center $center, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete'.$center->getId(), $request->request->get('_token'))) {
            $em->remove($center);
            $em->flush();
            $this->addFlash('success', 'Centre supprimé avec succès !');
        }

        return $this->redirectToRoute('admin_center_index');
    }
}
