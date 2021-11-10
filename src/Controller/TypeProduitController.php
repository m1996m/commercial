<?php

namespace App\Controller;

use App\Entity\TypeProduit;
use App\Form\TypeProduitType;
use App\Repository\TypeProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class TypeProduitController extends AbstractController
{
    /**
     * @Route("/type/produit", name="type_produit_index", methods={"GET"})
     */
    public function index(TypeProduitRepository $typeProduitRepository): Response
    {
        return $this->json($typeProduitRepository->findAll(),200);
    }

    /**
     * @Route("/type/produit/new", name="type_produit_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $typeProduit = new TypeProduit();
        $request=$request->getContent();
        $form=json_decode($request,true);
        $typeProduit->settype($form['type']);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($typeProduit);
        $entityManager->flush();
        return $this->json('Ajout reussi', 200);
    }

    /**
     * @Route("/getOneTypeProduit/{id}", name="type_produit_show", methods={"GET"})
     */
    public function show(TypeProduit $typeProduit): Response
    {
        return $this->json($typeProduit,200);
    }

    /**
     * @Route("/getAndEditTypeProduit/{id}", name="type_produit_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TypeProduit $typeProduit): Response
    {
        $request=$request->getContent();
        $form=json_decode($request,true);
        $typeProduit->settype($form['type']);
        $this->getDoctrine()->getManager()->flush();
        return $this->json('modification reussie', 200);
    }

    /**
     * @Route("/getDelete/{id}", name="type_produit_delete", methods={"POST"})
     */
    public function delete(Request $request, TypeProduit $typeProduit): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($typeProduit);
        $entityManager->flush();
        return $this->json('Suppression reussie', 200);
    }
    /**
     * @Route("/verificationUniciteTypeProduit", name="verificationUniciteTypeProduit", methods={"GET"})
     */
    public function verificationUniciteTypeProduit(TypeProduitRepository $repos,Request $request): Response
    {
        $request=$request->getContent();
        $content=json_decode($request,true);
        return $this->json($repos->findOneBy(['type'=>$content['type']]),200);
    }
}
