<?php

namespace App\Controller;

use App\Entity\Publicite;
use App\Form\PubliciteType;
use App\Repository\PubliciteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

#[Route('/publicite/backoffice')]
class PubliciteBackofficeController extends AbstractController
{
    #[Route('/', name: 'app_publicite_backoffice', methods: ['GET'])]
    public function index(PubliciteRepository $publiciteRepository): Response
    {
        return $this->render('publicite_backoffice/index.html.twig', [
            'publicites' => $publiciteRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_publicite_backoffice_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PubliciteRepository $publiciteRepository): Response
    {
        $publicite = new Publicite();
        $form = $this->createForm(PubliciteType::class, $publicite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $publiciteRepository->save($publicite, true);

            return $this->redirectToRoute('app_publicite_backoffice', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('publicite_backoffice/new.html.twig', [
            'publicite' => $publicite,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_publicite_backoffice_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Publicite $publicite, PubliciteRepository $publiciteRepository): Response
    {
        $form = $this->createForm(PubliciteType::class, $publicite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $publiciteRepository->save($publicite, true);

            return $this->redirectToRoute('app_publicite_backoffice', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('publicite_backoffice/edit.html.twig', [
            'publicite' => $publicite,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_publicite_backoffice_delete', methods: ['POST'])]
    public function delete(Request $request, Publicite $publicite, PubliciteRepository $publiciteRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$publicite->getId(), $request->request->get('_token'))) {
            $publiciteRepository->remove($publicite, true);
        }

        return $this->redirectToRoute('app_publicite_backoffice', [], Response::HTTP_SEE_OTHER);
    }
}