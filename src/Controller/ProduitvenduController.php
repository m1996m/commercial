<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\ClientCentre;
use App\Entity\Produitvendu;
use App\Entity\Rayon;
use App\Entity\Vente;
use App\Form\ProduitvenduType;
use App\Repository\ProduitvenduRepository;
use App\Repository\UserRepository;
use App\Repository\VenteRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class ProduitvenduController extends AbstractController
{
    /**
     * @Route("/vente", name="vente_index", methods={"GET"})
     */
    public function index(ProduitvenduRepository $venteRepository): Response
    {
        $defaultContext=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet,$format,$context){
                return "Symfony 5";
            }
        ];
        return $this->json($venteRepository->getAll(1),200,[],$defaultContext);
    }

    /**
     * @Route("/vente/new", name="vente_new", methods={"GET","POST"})
     */
    public function new(Request $request, VenteRepository $repos,UserRepository $userRepository): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $request=$request->getContent();
        $contents=json_decode($request,true);
        $vente = new Vente();
        $user=$userRepository->find(1);
        foreach($contents as $content){
            $client=$entityManager->getRepository(Client::class)->find($content['idClient']);
            $vente->setCreatedAt(new \DateTime());
            $vente->setClient($client);
            $remise=0;
            if(!empty($content['remise'])){
                $remise=$content['remise'];
            }
            $vente->setRemise($remise);
            $entityManager->persist($vente);
            $vente->setUser($user);
            $entityManager->flush();
            $forms=$content['form'];
        }
        foreach($forms as $form){
            //Mise à jour de la quantite dans le rayon
            $rayons=new Rayon();
            $rayons=$entityManager->getRepository(Rayon::class)->find($form['idRayon']);
            if($rayons->getPrise()!=null){
                $rayons->setPrise($rayons->getPrise()+$form['quantiteVendu']);
            }else{
                $rayons->setPrise($form['quantiteVendu']);
            }
            $this->getDoctrine()->getManager()->flush();
            //Ajout du produit vendu
            $produitVendu=new Produitvendu();
            $rayon=$entityManager->getRepository(Rayon::class)->find($form['idRayon']);
            $ventes=$repos->rechercherDernierObjet();
            $produitVendu->setVente($ventes);
            $produitVendu->setRayon($rayon);
            $produitVendu->setQuantite($form['quantiteVendu']);
            $entityManager->persist($produitVendu);
            $entityManager->flush();
       }
        return $this->json('Ajout reussi', 200);
    }

    /**
     * @Route("/getOneVente/{id}", name="vente_show", methods={"GET"})
     */
    public function show($id, ProduitvenduRepository $repos): Response
    {
        $vente=$repos->getOneVente($id,1);
        $defaultContext=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet,$format,$context){
                return "Symfony 5";
            }
        ];
        return $this->json($repos->getOneVente($id,1),200,[],$defaultContext);
    }

    /**
     * @Route("/rechercherVente", name="rechercherVente", methods={"GET","POST"})
     */
    public function rechercherVente(Request $request, ProduitvenduRepository $repos): Response
    {
        $request=$request->getContent();
        $content=json_decode($request,true);
        $defaultContext=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet,$format,$context){
                return "Symfony 5";
            }
        ];
        return $this->json($repos->rechercherVente($content['designation'],1,1),200,[],$defaultContext);
    }

    /**
     * @Route("/mesventes", name="mesventes", methods={"GET","POST"})
     */
    public function mesVentes( ProduitvenduRepository $repos): Response
    {
        $defaultContext=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet,$format,$context){
                return "Symfony 5";
            }
        ];
        return $this->json($repos->mesVente(1),200,[],$defaultContext);
    }
     /**
     * @Route("/getAndEditVente/{id}", name="vente_edit", methods={"GET","POST"})
     */
    public function edit(Request $request,Produitvendu $produitVendu,VenteRepository $venteRepository): Response
    {
        $defaultContext=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet,$format,$context){
                return "Symfony 5";
            }
        ];
        $entityManager = $this->getDoctrine()->getManager();
        $request=$request->getContent();
        $form=json_decode($request,true);
        $client=$entityManager->getRepository(Client::class)->find($form['idClient']);
        //$vente->setCreatedAt(new \DateTime());
        $vente =new Vente();
        $vente=$venteRepository->find($produitVendu->getVente()->getId());
        $vente->setClient($client);
        $this->getDoctrine()->getManager()->flush();
        // $rayons->setQuantite($rayons->getQuantite()-$form['quantiteVendu']);
        // $this->getDoctrine()->getManager()->flush();
        //Mise à produit vendu
        //$produitVendu->setVente($vente);
        // $produitVendu->setRayon($rayons);
        // $this->getDoctrine()->getManager()->flush();

         //verification si le si le stock ou la quantite a été changé 
        //Mise à jour de la quantite dans le rayon
         $rayons=new Rayon();
         $rayon=$entityManager->getRepository(Rayon::class)->find($form['idRayon']);
         $rayons=$rayon;
         $ancien=0;
         $quantite=0;
         $ancienneIdRayon=$entityManager->getRepository(Rayon::class)->find($form['ancienneIdRayon']);
         if($form['idRayon']!=$form['ancienneIdRayon']){
             //Cas ou le stock a été modifié
             $ancien=sqrt($form['ancienneQuantite']-$ancienneIdRayon->getPrise());
             $quantite=$form['quantiteVendu']+$rayons->getPrise();
         }else{
             if($form['ancienneQuantite']<=$form['quantiteVendu']){
                 $quantite=$rayons->getPrise()-$form['quantiteVendu'];
             }else{
                 $quantite=sqrt($form['quantiteVendu']-$form['ancienneQuantite'])+$rayons->getPrise();
             }
         }
         if($form['idRayon']!=$form['ancienneIdRayon']){
             //Mise à sur l'ancienne valeur
             $rayons=$ancienneIdRayon;
             $rayons->setPrise($ancien);
             $this->getDoctrine()->getManager()->flush();
             $rayons=$rayon;
             $rayons->setPrise($quantite);
         }else{
             //Mise à sur la nouvelle valeur
             $ps=$rayon;
             $ps->setPrise($quantite);
         }
         $this->getDoctrine()->getManager()->flush();
        return $this->json('Modification reussie',200, [],$defaultContext);
    }

    /**
     * @Route("/caisseVente", name="caisseVente", methods={"GET","POST"})
     */
    public function caisseVente(Request $request,ProduitvenduRepository $repos): Response
    {
        $request=$request->getContent();
        $content=json_decode($request,true);
        $entityManager=$this->getDoctrine()->getManager();
        //$client=$entityManager->getRepository(Client::class)->find($content['content']);        
        $defaultContext=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet,$format,$context){
                return "Symfony 5";
            }
        ];
        return $this->json($repos->caisse(1,$content['date1'],$content['date2']),200,[],$defaultContext);
    }

    /**
     * @Route("/venteEncours", name="venteEncours", methods={"GET","POST"})
     */
    public function venteEncours(Request $request,ProduitvenduRepository $repos): Response
    {

        $request=$request->getContent();
        $content=json_decode($request,true);
        $entityManager=$this->getDoctrine()->getManager();
        //$client=$entityManager->getRepository(Client::class)->find($content['content']);        
        $defaultContext=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet,$format,$context){
                return "Symfony 5";
            }
        ];
        return $this->json($repos->venteAnneEncours(1),200,[],$defaultContext);
    }

    /**
     * @Route("/venteMensuelle", name="venteMensuelle", methods={"GET","POST"})
     */
    public function venteMensuelle(Request $request,ProduitvenduRepository $repos): Response
    {

        $request=$request->getContent();
        $content=json_decode($request,true);
        $entityManager=$this->getDoctrine()->getManager();
        //$client=$entityManager->getRepository(Client::class)->find($content['content']);        
        $defaultContext=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet,$format,$context){
                return "Symfony 5";
            }
        ];
        return $this->json($repos->venteMensuelle(1),200,[],$defaultContext);
    }

    // /**
    //  * @Route("/mesachats", name="mesachats", methods={"GET","POST"})
    //  */
    // public function mesAchats(Request $request,ProduitvenduRepository $repos): Response
    // {
    //     $request=$request->getContent();
    //     $content=json_decode($request,true);
    //     $entityManager=$this->getDoctrine()->getManager();
    //     $client=$entityManager->getRepository(Client::class)->find($content['content']);        
    //     $achats=$repos->mesAchat($this->getUser());
    //     $defaultContext=[
    //         AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet,$format,$context){
    //             return "Symfony 5";
    //         }
    //     ];
    //     return $this->json($repos->mesAchat($client),200,[],$defaultContext);
    // }
    /**
     * @Route("/getDeleteVente/{id}", name="vente_delete", methods={"POST"})
     */
    public function delete(Request $request, Vente $vente): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($vente);
        $entityManager->flush();
        return $this->json('Suppression reussie', 200);
    }
}
