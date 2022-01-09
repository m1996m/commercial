<?php

namespace App\Controller;

use App\Entity\Centre;
use App\Entity\Fournisseur;
use App\Entity\FournisseurCentre;
use App\Entity\Produit;
use App\Entity\ProduitStock;
use App\Entity\Stock;
use App\Entity\User;
use App\Repository\CentreRepository;
use App\Repository\FournisseurCentreRepository;
use App\Repository\ProduitStockRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class ProduitStockController extends AbstractController
{
    /**
     * @Route("/api/produit/stock", name="produit_stock_index", methods={"GET"})
     */
    public function index(ProduitStockRepository $produitStockRepository,CentreRepository $repos): Response
    {
        $defaultContext=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet,$format,$contex){
                return "Symfony 5";
            },
        ];
        return $this->json($produitStockRepository->getAll($this->getUser()->getCentre()->getId()),200,[],$defaultContext);
    }

    /**
     * @Route("/api/produit/stock/new", name="produit_stock_new", methods={"GET","POST"})
     */
    public function new(Request $request,FournisseurCentreRepository $repos): Response
    {
        $request=$request->getContent();
        $forms=json_decode($request,true);
        foreach($forms as $form){
            $prise=0;
            if(sizeof($form)==11){
                $prise=$form['prise1'];
            }
            $produitStock = new ProduitStock();
            $entityManager = $this->getDoctrine()->getManager();
            $produit=$entityManager->getRepository(Produit::class)->find($form['idProduit']);
            $user=$entityManager->getRepository(User::class)->find(1);
            $fournisseur=$entityManager->getRepository(Fournisseur::class)->find($form['idf']);
            $stock=$entityManager->getRepository(Stock::class)->find($form['ids']);
            $produitStock->setPUV($form['PUV']);
            $produitStock->setPUA($form['PUA']);
            $produitStock->setPrise(0);
            $produitStock->setQuantite((int)$form['quantity']-$prise);
            $produitStock->setCreateAt(new \DateTime());
            $produitStock->setProduit($produit);
            $produitStock->setStock($stock);
            $produitStock->setUser($this->getUser());
            $produitStock->setFournisseur($fournisseur);
            $entityManager->persist($produitStock);
            $entityManager->flush();
        }
        
        //Ajout du fournisseur centre
        // $clientCentre=new FournisseurCentre();
        // $clientCentre->setFournisseur($fournisseur);
        // $clientCentre->setCentre($produitStock->getStock()->getCentre());
        // $entityManager->persist($clientCentre);
        // $entityManager->flush();
        return $this->json('Ajout reussi',200);
    }

    /**
     * @Route("/api/getOneProduitStock/{id}", name="produit_stock_show", methods={"GET","POST"})
     */
    public function show(ProduitStockRepository $repos,$id): Response
    {
        $defaultContext=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet,$format,$contex){
                return "Symfony 5";
            },
        ];
        return $this->json($repos->getOneProduitStock($id),200,[],$defaultContext);
    }

    /**
     * Permet de rechercher un produit un groupe de produit dans le stock produit
     * @Route("/api/getProduit", name="getProduit", methods={"GET","POST"})
     */
    public function getProduit(Request $request,ProduitStockRepository $repos): Response
    {
        $request=$request->getContent();
        $content=json_decode($request,true);
        $defaultContext=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet,$format,$contex){
                return "Symfony 5";
            },
        ];
        return $this->json($repos->getProduit($content['content'],1),200,[],$defaultContext);
    }

    /**
     * @Route("/api/getEtatStockProduit", name="etatStock", methods={"GET","POST"})
     */
    public function getEtatStockProduit(Request $request,ProduitStockRepository $repos,CentreRepository $centrer): Response
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
        return $this->json($repos->getEtatStockProduit($stock,$this->getUser()->getCentre()),200,[],$defaultContext);
    }

    /**
     * @Route("/api/verificationQuantites", name="verificationQuantites", methods={"GET","POST"})
     */
    public function verificationQuantite(Request $request,ProduitStockRepository $repos,CentreRepository $centrer): Response
    {
        $request=$request->getContent();
        $content=json_decode($request,true);
        $defaultContext=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet,$format,$contex){
                return "Symfony 5";
            },
        ];
        return $this->json($repos->verificationQuantite($content['idProduitStock'],$content['quantite']),200,[],$defaultContext);
    }

    /**
     * @Route("/api/stockdata", name="stockdata", methods={"GET","POST"})
     */
    public function stockdata(Request $request,ProduitStockRepository $repos,CentreRepository $centrer): Response
    {
        $request=$request->getContent();
        $content=json_decode($request,true);
        $defaultContext=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet,$format,$contex){
                return "Symfony 5";
            },
        ];
        return $this->json($repos->stock($content['idProduitStock']),200,[],$defaultContext);
    }

    /**
     * @Route("/api/getProduitsearchIntantane", name="getProduitsearchIntantane", methods={"GET","POST"})
     */
    public function getProduitsearchIntantane(Request $request,ProduitStockRepository $repos,CentreRepository $centrer): Response
    {
        $request=$request->getContent();
        $content=json_decode($request,true);
        $defaultContext=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet,$format,$contex){
                return "Symfony 5";
            },
        ];
        return $this->json($repos->getProduitsearchIntantane($content['idProduitStock'],$this->getUser()->getCentre()->getId()),200,[],$defaultContext);
    }
    /**
     * @Route("/api/getAndEditProduitStock/{id}", name="produit_stock_edit", methods={"GET","POST"})
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
        $produit=$entityManager->getRepository(Produit::class)->find($form['idProduit']);
        //$user=$entityManager->getRepository(User::class)->find($form['idUser']);
        $fournisseur=$entityManager->getRepository(Fournisseur::class)->find($form['idf']);
        $stock=$entityManager->getRepository(Stock::class)->find($form['ids']);
        $produitStock->setPUV($form['PUV']);
        $produitStock->setPUA($form['PUA']);
        $produitStock->setQuantite($form['quantity']);
        $produitStock->setProduit($produit);
        $produitStock->setStock($stock);
        //$produitStock->setUser($user);
        $produitStock->setFournisseur($fournisseur);
        $this->getDoctrine()->getManager()->flush();
        //Ajout du fournisseur centre
        $clientCentre=new FournisseurCentre();
        $clientCentre->setFournisseur($fournisseur);
        $clientCentre->setCentre($this->getUser()->getCentre());
        $this->getDoctrine()->getManager()->flush();
        return $this->json("Modification reussie",200, [], $defaultContext);
    }

    /**
     * @Route("/api/remplacerProduit", name="remplacerProduit", methods={"GET","POST"})
     */
    public function remplacerProduit(Request $request, ProduitStockRepository $produitStockRepository): Response
    {
        $defaultContext=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet,$format,$contex){
                return "Symfony 5";
            },
        ];
        $produitStock=new ProduitStock();
        $request=$request->getContent();
        $forms=json_decode($request,true);
        $prise=0;
        foreach($forms as $form){
            if(empty($form['prise1'])){
                $prise=0;
            }else{
                $prise=$form['prise1'];
            }
            $produit=$produitStockRepository->find($form['idProduitStock']);
            $produitStock=$produit;
            $produitStock->setPUV($form['PUV']);
            $produitStock->setPUA($form['PUA']);
            $produitStock->setQuantite($prise);
            $this->getDoctrine()->getManager()->flush();
        }
         return $this->json("Modification reussie",200, [], $defaultContext);
    }

    /**
     * @Route("/api/getDelete/produitStock/{id}", name="produit_stock_delete", methods={"POST"})
     */
    public function delete(ProduitStock $produitStock): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($produitStock);
        $entityManager->flush();
        return $this->json('Suppression reussie', 200);
    }

    /**
     * @Route("/api/tQuantite", name="tQuantite", methods={"GET","POST"})
     */
    public function totalQuantite(Request $request,ProduitStockRepository $repos): Response
    {
        $request=$request->getContent();
        $content=json_decode($request,true);
        $defaultContext=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet,$format,$context){
                return "Symfony 5";
            }
        ];
        return $this->json($repos->totalQuantite($content['idProduit']),200,[],$defaultContext);
    }
    
}
