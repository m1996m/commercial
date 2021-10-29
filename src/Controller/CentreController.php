<?php

namespace App\Controller;

use App\Entity\Centre;
use App\Form\CentreType;
use App\Repository\CentreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/centre")
 */
class CentreController extends AbstractController
{
    /**
     * @Route("/", name="centre_index", methods={"GET"})
     */
    public function index(CentreRepository $centreRepository): Response
    {
        return $this->render('centre/index.html.twig', [
            'centres' => $centreRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="centre_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $centre = new Centre();
        $form = $this->createForm(CentreType::class, $centre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($centre);
            $entityManager->flush();

            return $this->redirectToRoute('centre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('centre/new.html.twig', [
            'centre' => $centre,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="centre_show", methods={"GET"})
     */
    public function show(Centre $centre): Response
    {
        return $this->render('centre/show.html.twig', [
            'centre' => $centre,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="centre_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Centre $centre): Response
    {
        $form = $this->createForm(CentreType::class, $centre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('centre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('centre/edit.html.twig', [
            'centre' => $centre,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="centre_delete", methods={"POST"})
     */
    public function delete(Request $request, Centre $centre): Response
    {
        if ($this->isCsrfTokenValid('delete'.$centre->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($centre);
            $entityManager->flush();
        }

        return $this->redirectToRoute('centre_index', [], Response::HTTP_SEE_OTHER);
    }
}
