<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\ClientCentre;
use App\Entity\Produitvendu;
use App\Entity\Rayon;
use App\Entity\Vente;
use App\Form\VenteType;
use App\Repository\ProduitvenduRepository;
use App\Repository\VenteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class VenteController extends AbstractController
{
     /**
     * @Route("/getAndEditVente/{id}", name="vente_edit", methods={"GET","POST"})
     */
    public function edit(Request $request,Vente $vente,ProduitvenduRepository $repos): Response
    {
        $defaultContext=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet,$format,$context){
                return "Symfony 5";
            }
        ];
        $entityManager = $this->getDoctrine()->getManager();
        $request=$request->getContent();
        $form=json_decode($request,true);
        $client=$entityManager->getRepository(Client::class)->find($form['client']);
        //$vente->setCreatedAt(new \DateTime());
        $vente->setQuantite($form['quantite']);
        $vente->setClient($client);
        $this->getDoctrine()->getManager()->flush();
        //Mise à jour de la quantite dans le rayon
        $rayons=new Rayon();
        $rayons=$entityManager->getRepository(Rayon::class)->find($form['rayon']);
        $rayons->setQuantite($rayons->getQuantite()-$form['quantite']);
        $this->getDoctrine()->getManager()->flush();
        //Mise à produit vendu
        $produitVendu=new Produitvendu();
        $rayon=$entityManager->getRepository(Rayon::class)->find($form['rayon']);
        $produitVendu=$repos->getproduitVendu($vente->getId(),$rayon);
        $produitVendu->setVente($vente);
        $produitVendu->setRayon($rayon);
        $this->getDoctrine()->getManager()->flush();
        //Mise à jour client centre
        $clientCentre=new ClientCentre();
        $clientCentre->setClient($client);
        $clientCentre->setCentre($rayons->getProduitStock()->getStock()->getCentre());
        $this->getDoctrine()->getManager()->flush();
        return $this->json('Modification reussie',200, [],$defaultContext);
    }

}