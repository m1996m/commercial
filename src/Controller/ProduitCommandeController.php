<?php

namespace App\Controller;

use App\Entity\ProduitCommande;
use App\Form\ProduitCommandeType;
use App\Repository\CommandeRepository;
use App\Repository\ProduitCommandeRepository;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

/**
 * @Route("/api")
 */
class ProduitCommandeController extends AbstractController
{
    /**
     * @Route("/produit/commande", name="produit_commande_index", methods={"GET"})
     */
    public function index(ProduitCommandeRepository $produitCommandeRepository,Request $request): Response
    {
        $defaultContext=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($oject,$format,$context){
                return "Symfony 5";
            }
        ];
        $content=$request->getContent();
        $form=json_decode($content,true);
        return $this->json($produitCommandeRepository->searchCommande($form['reference']),200,[],$defaultContext);
    }

    /**
     * @Route("/produit/commande/new", name="produit_commande_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager,ProduitRepository $produitRepository,CommandeRepository $commandeRepository): Response
    {
        $produitCommande = new ProduitCommande();
        $content=$request->getContent();
        $form=json_decode($content,true);
        //$idProdut=$produitRepository->idProduit($form['designation'],$form['type'],$this->getUser()->getCentre()->getNom());
       // $idCommande=$commandeRepository->idCommande($form['idCommande']);
        $produitCommande->setProduit($produitRepository->find($form['idProduit']));
        $produitCommande->setCommande($commandeRepository->find($form['idCommande']));
        $produitCommande->setQuantite($form['quantite']);
        $entityManager->persist($produitCommande);
        $entityManager->flush();
        return $this->json('ajout reussie',200);
    }

    /**
     * @Route("/getOneProduitCommande/{reference}", name="produit_commande_show", methods={"GET"})
     */
    public function show(ProduitCommandeRepository $produitCommandeRepository,$id): Response
    {
        $defaultContext=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($oject,$format,$context){
                return "Symfony 5";
            }
        ];
        return $this->json($produitCommandeRepository->getOneProduitCommande($id),200,[],$defaultContext);
    }

    /**
     * @Route("/editProduitCommande/{reference}", name="produit_commande_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, ProduitCommande $produitCommande, EntityManagerInterface $entityManager,ProduitRepository $produitRepository): Response
    {
        $content=$request->getContent();
        $form=json_decode($content,true);
        $idProdut=$produitRepository->idProduit($form['designation'],$form['type'],$this->getUser()->getCentre()->getNom());
        $produitCommande->setProduit($produitRepository->find($idProdut));
        $entityManager->persist($produitCommande);
        $entityManager->flush();
        return $this->json('Modification reussie',200);
    }

    /**
     * @Route("/{id}", name="produit_commande_delete", methods={"POST"})
     */
    public function delete(Request $request, ProduitCommande $produitCommande, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$produitCommande->getId(), $request->request->get('_token'))) {
            $entityManager->remove($produitCommande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('produit_commande_index', [], Response::HTTP_SEE_OTHER);
    }
}
