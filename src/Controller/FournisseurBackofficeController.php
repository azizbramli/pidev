<?php

namespace App\Controller;

use App\Entity\Fournisseur;
use App\Form\FournisseurType;
use App\Repository\FournisseurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/fournisseur/backoffice')]
class FournisseurBackofficeController extends AbstractController
{
    #[Route('/', name: 'app_fournisseur_backoffice', methods: ['GET'])]
    public function index(FournisseurRepository $fournisseurRepository): Response
    {
        return $this->render('fournisseur_backoffice/index.html.twig', [
            'fournisseurs' => $fournisseurRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_fournisseur_backoffice_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FournisseurRepository $fournisseurRepository): Response
    {
        $fournisseur = new Fournisseur();
        $form = $this->createForm(FournisseurType::class, $fournisseur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fournisseurRepository->save($fournisseur, true);

            return $this->redirectToRoute('app_fournisseur_backoffice', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('fournisseur_backoffice/new.html.twig', [
            'fournisseur' => $fournisseur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_fournisseur_backoffice_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Fournisseur $fournisseur, FournisseurRepository $fournisseurRepository): Response
    {
        $form = $this->createForm(FournisseurType::class, $fournisseur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fournisseurRepository->save($fournisseur, true);

            return $this->redirectToRoute('app_fournisseur_backoffice', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('fournisseur_backoffice/edit.html.twig', [
            'fournisseur' => $fournisseur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_fournisseur_backoffice_delete', methods: ['POST'])]
    public function delete(Request $request, Fournisseur $fournisseur, FournisseurRepository $fournisseurRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$fournisseur->getId(), $request->request->get('_token'))) {
            $fournisseurRepository->remove($fournisseur, true);
        }

        return $this->redirectToRoute('app_fournisseur_backoffice', [], Response::HTTP_SEE_OTHER);
    }
}