<?php

namespace App\Controller;

use App\Entity\Centre;
use App\Form\CentreType;
use App\Repository\CentreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CentreController extends AbstractController
{
    /**
     * @Route("/centre", name="centre_index", methods={"GET"})
     */
    public function index(CentreRepository $centreRepository): Response
    {
        $centres=$centreRepository->findAll();

        return $this->json($centres,200);
    }

    /**
     * @Route("/centre/new", name="centre_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $centre = new Centre();
        $request=$request->getContent();
        $form=json_decode($request,true);
        $centre->setNom($form['nom']);
        $centre->setAdresse($form['adresse']);
        $centre->setTel($form['tel']);
        $centre->setVille($form['ville']);
        $centre->setPays($form['pays']);
        $centre->setEmail($form['email']);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($centre);
        $entityManager->flush();
        return $this->json('Ajout reussi',200);
    }

    /**
     * @Route("/getCentre/{id}", name="centre_show", methods={"GET"})
     */
    public function show(Centre $centre): Response
    {
        return $this->json($centre,200);
    }
    

    /**
     * @Route("/rechercherCentre", name="rechercherCentre", methods={"GET"})
     */
    public function rechercherCentre(CentreRepository $repos, Request $request): Response
    {
        $request=$request->getContent();
        $valeur=json_decode($request,true);
        return $this->json($repos->rechercherCentre($valeur['content']),200);
    }
    /**
     * @Route("/modificationCentre/{id}", name="centre_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Centre $centre): Response
    {
        $request=$request->getContent();
        $form=json_decode($request,true);
        $centre->setNom($form['nom']);
        $centre->setAdresse($form['adresse']);
        $centre->setTel($form['tel']);
        $centre->setVille($form['ville']);
        $centre->setPays($form['pays']);
        $centre->setEmail($form['email']);
        $this->getDoctrine()->getManager()->flush();
        return $this->json($centre,200);
    }

    /**
     * @Route("/centre/{id}", name="centre_delete", methods={"POST"})
     */
    public function delete(Request $request, Centre $centre): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($centre);
        $entityManager->flush();
        return $this->json('Suppression bien reussie',200);
    }
}
