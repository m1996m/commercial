<?php

namespace App\Controller;

use App\Entity\Fournisseur;
use App\Entity\Produit;
use App\Entity\ProduitStock;
use App\Entity\Stock;
use App\Entity\TypeProduit;
use App\Entity\User;
use App\Form\ProduitStockType;
use App\Form\ProduitType;
use App\Repository\ProduitStockRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class ProduitStockController extends AbstractController
{
    /**
     * @Route("/produit/stock", name="produit_stock_index", methods={"GET"})
     */
    public function index(ProduitStockRepository $produitStockRepository): Response
    {
        $defaultContext=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet,$format,$contex){
                return "Symfony 5";
            },
        ];
        return $this->json($produitStockRepository->findAll(),200,[],$defaultContext);
    }

    /**
     * @Route("/produit/stock/new", name="produit_stock_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $produitStock = new ProduitStock();
        $request=$request->getContent();
        $form=json_decode($request,true);
        $entityManager = $this->getDoctrine()->getManager();
        $produit=$entityManager->getRepository(Produit::class)->find($form['produit']);
        $user=$entityManager->getRepository(User::class)->find($form['user']);
        $fournisseur=$entityManager->getRepository(Fournisseur::class)->find($form['fournisseur']);
        $stock=$entityManager->getRepository(Stock::class)->find($form['stock']);
        $produitStock->setPUV($form['puv']);
        $produitStock->setPUA($form['pua']);
        $produitStock->setQuantite($form['quantite']);
        $produitStock->setCreateAt(new \DateTime());
        $produitStock->setProduit($produit);
        $produitStock->setStock($stock);
        $produitStock->setUser($user);
        $produitStock->setFournisseur($fournisseur);
        $entityManager->persist($produitStock);
        $entityManager->flush();
        return $this->json('Ajout reussi',200);
    }

    /**
     * @Route("/getOneProduitStock/{id}", name="produit_stock_show", methods={"GET"})
     */
    public function show(ProduitStock $produitStock): Response
    {
        $defaultContext=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet,$format,$contex){
                return "Symfony 5";
            },
        ];
        return $this->json($produitStock,200,[],$defaultContext);
    }

    /**
     * Permet de rechercher un produit un groupe de produit dans le stock produit
     * @Route("/getProduit", name="getProduit", methods={"GET"})
     */
    public function getProduit(Request $request,ProduitStockRepository $repos): Response
    {
        $request=$request->getContent();
        $content=json_decode($request,true);
        $entityManager = $this->getDoctrine()->getManager();
        $produit=$entityManager->getRepository(Produit::class)->find($content['produit']);
        $stock=$entityManager->getRepository(Stock::class)->find($content['stock']);
        $defaultContext=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet,$format,$contex){
                return "Symfony 5";
            },
        ];
        return $this->json($repos->getProduit($produit,$stock),200,[],$defaultContext);
    }

    /**
     * @Route("/getEtatStockProduit", name="etatStock", methods={"GET"})
     */
    public function getEtatStockProduit(Request $request,ProduitStockRepository $repos): Response
    {
        $request=$request->getContent();
        $content=json_decode($request,true);
        $entityManager = $this->getDoctrine()->getManager();
        $stock=$entityManager->getRepository(Stock::class)->find($content['stock']);
        $defaultContext=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet,$format,$contex){
                return "Symfony 5";
            },
        ];
        return $this->json($repos->getEtatStockProduit($stock),200,[],$defaultContext);
    }

    /**
     * @Route("/getAndEditProduitStock/{id}", name="produit_stock_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ProduitStock $produitStock): Response
    {
        $defaultContext=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet,$format,$contex){
                return "Symfony 5";
            },
        ];
        $request=$request->getContent();
        $form=json_decode($request,true);
        $entityManager = $this->getDoctrine()->getManager();
        $produit=$entityManager->getRepository(Produit::class)->find($form['produit']);
        $user=$entityManager->getRepository(User::class)->find($form['user']);
        $fournisseur=$entityManager->getRepository(Fournisseur::class)->find($form['fournisseur']);
        $stock=$entityManager->getRepository(Stock::class)->find($form['stock']);
        $produitStock->setPUV($form['puv']);
        $produitStock->setPUA($form['pua']);
        $produitStock->setQuantite($form['quantite']);
        $produitStock->setCreateAt(new \DateTime());
        $produitStock->setProduit($produit);
        $produitStock->setStock($stock);
        $produitStock->setUser($user);
        $produitStock->setFournisseur($fournisseur);
        $this->getDoctrine()->getManager()->flush();
        return $this->json($produitStock,200, [], $defaultContext);
    }

    /**
     * @Route("/getDelete/produitStock/{id}", name="produit_stock_delete", methods={"POST"})
     */
    public function delete(Request $request, ProduitStock $produitStock): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($produitStock);
        $entityManager->flush();
        return $this->json('Suppression reussie', 200);
    }
}
