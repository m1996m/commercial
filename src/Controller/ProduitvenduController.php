<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\ClientCentre;
use App\Entity\Produitvendu;
use App\Entity\Rayon;
use App\Entity\Vente;
use App\Form\ProduitvenduType;
use App\Repository\ProduitvenduRepository;
use App\Repository\VenteRepository;
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
        return $this->json($venteRepository->getAll(),200,[],$defaultContext);
    }

    /**
     * @Route("/vente/new", name="vente_new", methods={"GET","POST"})
     */
    public function new(Request $request, VenteRepository $repos): Response
    {
        $vente = new Vente();
        $entityManager = $this->getDoctrine()->getManager();
        $request=$request->getContent();
        $form=json_decode($request,true);
        $client=$entityManager->getRepository(Client::class)->find($form['client']);
        $vente->setCreatedAt(new \DateTime());
        $vente->setQuantite($form['quantite']);
        $vente->setClient($client);
        $entityManager->persist($vente);
        $entityManager->flush();
        //Mise à jour de la quantite dans le rayon
        $rayons=new Rayon();
        $rayons=$entityManager->getRepository(Rayon::class)->find($form['rayon']);
        $rayons->setQuantite($rayons->getQuantite()-$form['quantite']);
        $this->getDoctrine()->getManager()->flush();
        //Ajout du produit vendu
        $produitVendu=new Produitvendu();
        $rayon=$entityManager->getRepository(Rayon::class)->find($form['rayon']);
        $ventes=$repos->rechercherDernierObjet();
        $produitVendu->setVente($ventes);
        $produitVendu->setRayon($rayon);
        $entityManager->persist($produitVendu);
        $entityManager->flush();
        //Ajout du client centre
        $clientCentre=new ClientCentre();
        $clientCentre->setClient($client);
        $clientCentre->setCentre($rayons->getProduitStock()->getStock()->getCentre());
        $entityManager->persist($clientCentre);
        $entityManager->flush();
        return $this->json('Ajout reussi', 200);
    }

    /**
     * @Route("/getOneVente/{id}", name="vente_show", methods={"GET"})
     */
    public function show(Produitvendu $produitVendu, ProduitvenduRepository $repos): Response
    {
        $vente=$repos->getOne($produitVendu->getId());
        $defaultContext=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet,$format,$context){
                return "Symfony 5";
            }
        ];
        return $this->json($vente,200,[],$defaultContext);
    }

    /**
     * @Route("/mesventes", name="mesventes", methods={"GET"})
     */
    public function mesVentes( ProduitvenduRepository $repos): Response
    {
        $ventes=$repos->mesVente($this->getUser());
        $defaultContext=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet,$format,$context){
                return "Symfony 5";
            }
        ];
        return $this->json($ventes,200,[],$defaultContext);
    }
    /**
     * @Route("/mesachats", name="mesachats", methods={"GET"})
     */
    public function mesAchats(Request $request,ProduitvenduRepository $repos): Response
    {
        $request=$request->getContent();
        $content=json_decode($request,true);
        $entityManager=$this->getDoctrine()->getManager();
        $client=$entityManager->getRepository(Client::class)->find($content['content']);        
        $achats=$repos->mesAchat($this->getUser());
        $defaultContext=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet,$format,$context){
                return "Symfony 5";
            }
        ];
        return $this->json($repos->mesAchat($client),200,[],$defaultContext);
    }
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
