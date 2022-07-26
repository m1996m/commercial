<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\ProduitCommande;
use App\Form\CommandeType;
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
class CommandeController extends AbstractController
{
    /**
     * @Route("/commande", name="commande_index", methods={"GET"})
     */
    public function index(CommandeRepository $commandeRepository): Response
    {
        $defaultContext=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($oject,$format,$context){
                return "Symfony 5";
            }
        ];
        return $this->json($commandeRepository->MesCommande($this->getUser()->getCentre()->getDomaine(),$this->getUser()->getId()),200,[],$defaultContext);
    }

    /**
     * @Route("/commande/new", name="commande_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager,ProduitRepository $produitRepository,CommandeRepository $commandeRepository): Response
    {
        $commande = new Commande();
        $content=$request->getContent();
        $form=json_decode($content,true);
        $commande->setUser($this->getUser());
        $commande->setCreatedAt(new \DateTime());
        $commande->setStatut("Encours");
        $commande->setDomaine($this->getUser()->getCentre()->getDomaine());
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $reference=substr(str_shuffle($chars),0,8);
        $commande->setReference($reference);
        $entityManager->persist($commande);
        $entityManager->flush();
        foreach($form as $produit)
        {
            $produitCommande = new ProduitCommande();
            $content=$request->getContent();
            $form=json_decode($content,true);
            //$idProdut=$produitRepository->idProduit($form['designation'],$form['type'],$this->getUser()->getCentre()->getNom());
            $idCommande=$commandeRepository->idCommande($reference);
            $produitCommande->setProduit($produitRepository->find($produit['idProduit']));
            $produitCommande->setCommande($commandeRepository->find($idCommande));
            $produitCommande->setQuantite($produit['quantite']);
            $entityManager->persist($produitCommande);
            $entityManager->flush();
        }
        return $this->json('Ajout reussi', 200);
    }

    /**
     * @Route("/mesCommande{reference}", name="mesCommande", methods={"GET"})
     */
    public function mesCommande(ProduitCommandeRepository $commandeRepository,$reference): Response
    {
        $defaultContext=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($oject,$format,$context){
                return "Symfony 5";
            }
        ];

        return $this->json($commandeRepository->getAllOneProduitCommande($reference),200,[],$defaultContext);
    }

    /**
     * @Route("/{id}/edit", name="commande_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Commande $commande, EntityManagerInterface $entityManager): Response
    {
        $defaultContext=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($oject,$format,$context){
                return "Symfony 5";
            }
        ];
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('commande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commande/edit.html.twig', [
            'commande' => $commande,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="commande_delete", methods={"POST"})
     */
    public function delete(Request $request, Commande $commande, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commande->getId(), $request->request->get('_token'))) {
            $entityManager->remove($commande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('commande_index', [], Response::HTTP_SEE_OTHER);
    }
}
