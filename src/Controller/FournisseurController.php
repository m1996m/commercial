<?php

namespace App\Controller;

use App\Entity\Fournisseur;
use App\Form\FournisseurType;
use App\Repository\FournisseurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class FournisseurController extends AbstractController
{
    /**
     * @Route("/fournisseur", name="fournisseur_index", methods={"GET"})
     */
    public function index(FournisseurRepository $fournisseurRepository): Response
    {
        return $this->json($fournisseurRepository->findAll(),200);
    }

    /**
     * @Route("/fournisseur/new", name="fournisseur_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $fournisseur = new Fournisseur();
        $request=$request->getContent();
        $form=json_decode($request,true);
        $fournisseur->setNom($form['nom']);
        $fournisseur->setPrenom($form['prenom']);
        $fournisseur->setTel($form['tel']);
        $fournisseur->setAdresse($form['adresse']);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($fournisseur);
        $entityManager->flush();
        return $this->json('Ajout reussi', 200);
    }

    /**
     * @Route("/getOnefournisseur/{id}", name="fournisseur_show", methods={"GET"})
     */
    public function show(Fournisseur $fournisseur): Response
    {
        return $this->json($fournisseur,200);
    }

    /**
     * @Route("/getAndEditFournisseur/{id}", name="fournisseur_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Fournisseur $fournisseur): Response
    {
        $request=$request->getContent();
        $form=json_decode($request,true);
        $fournisseur->setNom($form['nom']);
        $fournisseur->setPrenom($form['prenom']);
        $fournisseur->setTel($form['tel']);
        $fournisseur->setAdresse($form['adresse']);
        $this->getDoctrine()->getManager()->flush();
        return $this->json('Modification reussie', 200);
    }

    /**
     * @Route("/getDeleteFournisseur/{id}", name="fournisseur_delete", methods={"POST"})
     */
    public function delete(Request $request, Fournisseur $fournisseur): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($fournisseur);
        $entityManager->flush();
        return $this->json('Suppression reussie', 200);
    }

    /**
     * @Route("/rechercherfournisseur", name="rechercherFournisseur", methods={"GET"})
     */
    public function rechercherFournisseur(Request $request, FournisseurRepository $repos): Response
    {
        $request=$request->getContent();
        $content=json_decode($request,true);
        return $this->json($repos->rechercherFournisseur($content['content']),200);
    }
    /**
     * @Route("/verificationUniciteTelFournisseur", name="verificationUniciteTelFournisseur", methods={"GET"})
     */
    public function verificationUniciteTelFournisseur(FournisseurRepository $repos,Request $request): Response
    {
        $request=$request->getContent();
        $content=json_decode($request,true);
        return $this->json($repos->getTel($content['tel']),200);
    }
}
