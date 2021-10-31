<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use App\Repository\TypeProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;


class ProduitController extends AbstractController
{
    /**
     * @Route("/produit", name="produit_index", methods={"GET"})
     */
    public function index(ProduitRepository $produitRepository): Response
    {
        $defaultContext=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet,$format,$contex){
                return "Symfony 5";
            },
        ];
        return $this->json($produitRepository->findAll(),200,[],$defaultContext);
    }

    /**
     * @Route("/produit/new", name="produit_new", methods={"GET","POST"})
     */
    public function new(Request $request,TypeProduitRepository $repos): Response
    {
        $produit = new Produit();
        $request=$request->getContent();
        $form=json_decode($request,true);
        $type=$repos->find($form['type']);
        $produit->setDesignation($form['designation']);
        $produit->settype($type);
        $produit->setPUA($form['pua']);
        $produit->setPUV($form['puv']);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($produit);
        $entityManager->flush();
        return $this->json('Ajout reussi', 200);
    }

    /**
     * @Route("/getOneProduit/{id}", name="produit_show", methods={"GET"})
     */
    public function show(Produit $produit): Response
    {
        $defaultContext=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet,$format,$contex){
                return "Symfony 5";
            },
        ];
        return $this->json( $produit,200,[],$defaultContext);
    }

    /**
     * Cette fonction permet de recuperer un objet on fonction du produit choisi lors de l'ajout dans produit article
     * @Route("/rechercherProduitDesignationType", name="rechercherProduitDesignationType", methods={"GET"})
     */
    public function rechercherProduitPrix(ProduitRepository $repos, Request $request, TypeProduitRepository $repo): Response
    {
        $request=$request->getContent();
        $content=json_decode($request,true);
        $defaultContext=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet,$format,$contex){
                return "Symfony 5";
            },
        ];
        return $this->json( $repos->find($content['designation']),200,[],$defaultContext);
    }

    /**
     * @Route("/rechercherProduit", name="rechercherProduit", methods={"GET"})
     */
    public function rechercherProduit(ProduitRepository $repos, Request $request, TypeProduitRepository $repo): Response
    {
        $request=$request->getContent();
        $content=json_decode($request,true);
        $type=$repo->find($content['type']);
        $defaultContext=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet,$format,$contex){
                return "Symfony 5";
            },
        ];
        return $this->json( $repos->rechercherProduit($content['content'],$type),200,[],$defaultContext);
    }

    /**
     * @Route("/getAndEditProduit/{id}", name="produit_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Produit $produit,TypeProduitRepository $repos): Response
    {
        $defaultContext=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet,$format,$contex){
                return "Symfony 5";
            },
        ];
        $request=$request->getContent();
        $form=json_decode($request,true);
        $type=$repos->find($form['type']);
        $produit->setDesignation($form['designation']);
        $produit->settype($type);
        $produit->setPUA($form['pua']);
        $produit->setPUV($form['puv']);
        $this->getDoctrine()->getManager()->flush();
        return $this->json($produit,200, [], $defaultContext);
    }

    /**
     * @Route("/getDeleteProduit/{id}", name="produit_delete", methods={"POST"})
     */
    public function delete(Request $request, Produit $produit): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($produit);
        $entityManager->flush();
        return $this->json('Suppression reussie',200);
    }
}
