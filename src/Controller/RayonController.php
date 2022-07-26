<?php

namespace App\Controller;

use App\Entity\ProduitStock;
use App\Entity\Rayon;
use App\Entity\TypeRayon;
use App\Entity\User;
use App\Repository\CentreRepository;
use App\Repository\ProduitStockRepository;
use App\Repository\RayonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("ROLE_USER")
 */

class RayonController extends AbstractController
{
    /**
     * @Route("/api/rayon", name="rayon_index", methods={"GET","POST"})
     */
    public function index(RayonRepository $rayonRepository,Request $request): Response
    {
        $defaultContext=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet,$format,$context){
                return "Symfony 5";
            }
        ];
        return $this->json($rayonRepository->getAll($this->getUser()->getCentre()->getId()),200,[],$defaultContext);
    }

    /**
     * @Route("/api/rayon/new", name="rayon_new", methods={"GET","POST"})
     */
    public function new(Request $request,RayonRepository $rayonRepository, ProduitStockRepository $produitStockRepository): Response
    {
        $request=$request->getContent();
        $forms=json_decode($request,true);
        $entityManager = $this->getDoctrine()->getManager();

        $ps=new ProduitStock(); 
        $produitStock="";
        $prise=0;
        foreach($forms as $form){
            $rayon = new Rayon();
            if(empty($form['idProduitStock'])){
                $produitStock=$produitStockRepository->find($produitStockRepository->getIDProduitStock($form['idProduit']));
                $prise=(int)$form['prise'];
            }else{
                $produitStock=$produitStockRepository->find($form['idProduitStock']);
            }
            //$user=$entityManager->getRepository(User::class)->find($form['user']);
            $type=$entityManager->getRepository(TypeRayon::class)->find($form['idType']);
            $rayon->setCreatedAt(new \DateTime());
            $rayon->setUser($this->getUser());
            $rayon->settype($type);
            $rayon->setPrise(0);
            $rayon->setProduitStock($produitStock);
            $rayon->setQuantite($form['quantite']-$prise);            
            $entityManager->persist($rayon);
            $entityManager->flush();
            $ps=$produitStock;
            $ps->setPrise($form['quantite']+$produitStock->getPrise());
            $this->getDoctrine()->getManager()->flush();
        }
        return $this->json('Ajout reussi', 200);
        
    }

        /**
     * @Route("/api/addOne", name="addOne", methods={"GET","POST"})
     */
    public function addOne(Request $request,RayonRepository $rayonRepository, ProduitStockRepository $produitStockRepository): Response
    {
        $request=$request->getContent();
        $form=json_decode($request,true);
        $entityManager = $this->getDoctrine()->getManager();
        $ps=new ProduitStock(); 
        $prise=0;
        $rayon = new Rayon();
        $produitStock=$produitStockRepository->find($produitStockRepository->getIDProduitStock($form['idProduit']));
        $prise=(int)$form['prise'];
        //$user=$entityManager->getRepository(User::class)->find($form['user']);
        $type=$entityManager->getRepository(TypeRayon::class)->find($form['idType']);
        $rayon->setCreatedAt(new \DateTime());
        $rayon->setUser($this->getUser());
        $rayon->settype($type);
        $rayon->setPrise(0);
        $rayon->setProduitStock($produitStock);
        $rayon->setQuantite((int)$form['quantite']-$prise);            
        $entityManager->persist($rayon);
        $entityManager->flush();
        // $ps=$produitStock;
        // $ps->setPrise($form['quantite']+$produitStock->getPrise());
        $this->getDoctrine()->getManager()->flush();
        return $this->json('Ajout reussi', 200);
        
    }

    /**
     * @Route("/api/getOneRayon/{id}", name="rayon_show", methods={"GET","POST"})
     */
    public function show(RayonRepository $rayonRepository,$id,CentreRepository $centreReposi): Response
    {
        $defaultContext=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet,$format,$context){
                return "Symfony 5";
            }
        ];
        return $this->json($rayonRepository->getOneRayon(1,$this->getUser()->getCentre()->getId()),200,[],$defaultContext);
    }

    /**
     * @Route("/api/interogationRayon", name="interogationRayon", methods={"GET","POST"})
     */
    public function interogationRayon(Request $request,RayonRepository $repos): Response
    {
        $request=$request->getContent();
        $content=json_decode($request,true);
        $defaultContext=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet,$format,$context){
                return "Symfony 5";
            }
        ];
        $rayons=[];
        if($content['idType']!=null){
            $rayons=$repos->rechercherProduitRayon($content['idType'],$this->getUser()->getCentre()->getId());
        }
        if($content['designation']!=null){
            $rayons=$repos->rechercherProduit($content['designation'],$this->getUser()->getCentre()->getId());
        }
        return $this->json($rayons,200,[],$defaultContext);
    }

    /**
     * @Route("/api/etatRayon", name="etatRayon", methods={"GET","POST"})
     */
    public function etatRayon(Request $request,RayonRepository $repos): Response
    {
        $request=$request->getContent();
        $content=json_decode($request,true);
        $entityManager=$this->getDoctrine()->getManager();
        $defaultContext=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet,$format,$context){
                return "Symfony 5";
            }
        ];
        return $this->json($repos->etatRayon($this->getUser()->getCentre()->getId()),200,[],$defaultContext);
    }

    /**
     * @Route("/api/ventedata", name="ventedata", methods={"GET","POST"})
     */
    public function vente(Request $request,RayonRepository $repos): Response
    {
        $request=$request->getContent();
        $content=json_decode($request,true);
        $defaultContext=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet,$format,$context){
                return "Symfony 5";
            }
        ];
        return $this->json($repos->vente($content['idRayon']),200,[],$defaultContext);
    }

    /**
     * @Route("/api/rechercherProduit", name="rechercherProduit", methods={"GET","POST"})
     */
    public function rechercherProduit(Request $request,RayonRepository $repos): Response
    {
        $request=$request->getContent();
        $content=json_decode($request,true);
        $defaultContext=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet,$format,$context){
                return "Symfony 5";
            }
        ];
        return $this->json($repos->rechercherProduit($content['content'],$this->getUser()->getCentre()->getId()),200,[],$defaultContext);
    }

    /**
     * @Route("/api/verificationQuantite", name="verificationQuantite", methods={"GET","POST"})
     */
    public function verificationQuantite(Request $request,RayonRepository $repos): Response
    {
        $request=$request->getContent();
        $contents=json_decode($request,true);
        $defaultContext=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet,$format,$context){
                return "Symfony 5";
            }
        ];
        foreach($contents as $content){
            return $this->json($repos->verificationQuantite($content['idRayon'],$content['quantiteVendu']));
        }
    }

    /**
     * @Route("/api/totalQuantite", name="totalQuantite", methods={"GET","POST"})
     */
    public function totalQuantite(Request $request,RayonRepository $repos): Response
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

    /**
     * @Route("/api/totaldata", name="totaldata", methods={"GET","POST"})
     */
    public function totaldata(Request $request,RayonRepository $repos): Response
    {
        $request=$request->getContent();
        $content=json_decode($request,true);
        $defaultContext=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet,$format,$context){
                return "Symfony 5";
            }
        ];
        return $this->json($repos->totaldata($content['idProduit']),200,[],$defaultContext);
    }

    /**
     * @Route("/api/tdata", name="tdata", methods={"GET","POST"})
     */
    public function tdata(Request $request,ProduitStockRepository $repos): Response
    {
        $request=$request->getContent();
        $content=json_decode($request,true);
        $defaultContext=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet,$format,$context){
                return "Symfony 5";
            }
        ];
        return $this->json($repos->totaldata($content['idProduit']),200,[],$defaultContext);
    }
    /**
     * @Route("/api/getAndEditRayon/{id}", name="rayon_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Rayon $rayon,ProduitStock $ps): Response
    {
        $defaultContext=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet,$format,$context){
                return "Symfony 5";
            }
        ];
        $ps=new ProduitStock(); 
        $request=$request->getContent();
        $form=json_decode($request,true);
        $entityManager = $this->getDoctrine()->getManager();
        $produitStock=$entityManager->getRepository(ProduitStock::class)->find($form['idProduitStock']);
        $type=$entityManager->getRepository(TypeRayon::class)->find($form['idType']);
        $rayon->setType($type);
        $rayon->setProduitStock($produitStock);
        $rayon->setQuantite($form['quantite']); 
        $this->getDoctrine()->getManager()->flush();
        //verification si le si le stock ou la quantite a été changé 
        $ps=$produitStock;
        $ancien=0;
        $quantite=0;
        $ancienneIdProduitStock=$entityManager->getRepository(ProduitStock::class)->find($form['ancienneIdProduitStock']);
        if($form['idProduitStock']!=$form['ancienneIdProduitStock']){
            //Cas ou le stock a été modifié
            $ancien=sqrt($form['ancienneQuantite']-$ancienneIdProduitStock->getPrise());
            $quantite=$form['quantite']+$ps->getPrise();
        }else{
            if($form['ancienneQuantite']<=$form['quantite']){
                $quantite=$form['ancienneQuantite']-$form['quantite']+$ps->getPrise();
            }else{
                $quantite=sqrt($form['quantite']-$form['ancienneQuantite'])+$ps->getPrise();
            }
        }
        if($form['idProduitStock']!=$form['ancienneIdProduitStock']){
            //Mise à sur l'ancienne valeur
            $ps=$ancienneIdProduitStock;
            $ps->setPrise($ancien);
            $this->getDoctrine()->getManager()->flush();
            $ps=$produitStock;
            $ps->setPrise($quantite);
        }else{
            //Mise à sur la nouvelle valeur
            $ps=$produitStock;
            $ps->setPrise($quantite);
        }
        $this->getDoctrine()->getManager()->flush();
        return $this->json("Modification reussie",200, [], $defaultContext);
    }

    /**
     * @Route("/api/remplacerRayonEtStockProduit", name="remplacerRayonEtStockProduit", methods={"GET","POST"})
     */
    public function remplacerRayonEtStockProduit(Request $request, RayonRepository $rayonRepository): Response
    {
        $defaultContext=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet,$format,$context){
                return "Symfony 5";
            }
        ];
        $request=$request->getContent();
        $forms=json_decode($request,true);
        $rayon=new Rayon(); 
        $prise=0;
        foreach($forms as $form){
            
            if(empty($form['prise'])){
                $prise=0;
            }else{
                $prise=$form['prise'];
            }
            $rayo=$rayonRepository->find($form['idRayon']);
            $rayon=$rayo;
            $rayon->setQuantite($prise);  
            $this->getDoctrine()->getManager()->flush();
        }
        return $this->json("Modification reussie",200, [], $defaultContext);
    }

    /**
     * @Route("/api/getDelete/{id}", name="rayon_delete", methods={"POST"})
     */
    public function delete(Request $request, Rayon $rayon): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($rayon);
        $entityManager->flush();
        return $this->json('OK', 200);
    }
}
