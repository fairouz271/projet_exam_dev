<?php

namespace App\Controller;

use App\Entity\Center;
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
            $em->persist($center);
            $em->flush();

            $this->addFlash('success', 'Centre ajouté avec succès !');
            return $this->redirectToRoute('admin_center_index');
        }

        return $this->render('admin_center/new_center.html.twig', [
            'form' => $form,
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
            $em->flush();
            $this->addFlash('success', 'Centre modifié avec succès !');

            return $this->redirectToRoute('admin_center_index');
        }

        return $this->render('admin_center/edit_center.html.twig', [
            'form' => $form,
            'center' => $center,
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
