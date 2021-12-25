<?php

namespace App\Controller;

use App\Entity\Centre;
use App\Entity\TypeProduit;
use App\Form\TypeProduitType;
use App\Repository\CentreRepository;
use App\Repository\TypeProduitRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\CssSelector\Node\AbstractNode;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class TypeProduitController extends AbstractController
{
    /**
     * @Route("/type/produit", name="type_produit_index", methods={"GET"})
     */
    public function index(TypeProduitRepository $typeProduitRepository,CentreRepository $repos): Response
    {
        $defaultContext=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($object,$format,$content){
                return "Symfony 5";
            }
        ];
        return $this->json($typeProduitRepository->getAll(1),200,[],$defaultContext);
    }

    /**
     * @Route("/type/produit/new", name="type_produit_new", methods={"GET","POST"})
     */
    public function new(Request $request,CentreRepository $repos): Response
    {
        $typeProduit = new TypeProduit();
        $request=$request->getContent();
        $form=json_decode($request,true);
        $typeProduit->settype($form['type']);
        $centre=$repos->find(1);
        $typeProduit->setCentre($centre);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($typeProduit);
        $entityManager->flush();
        return $this->json('Ajout reussi', 200);
    }

    /**
     * @Route("/getOneTypeProduit/{id}", name="type_produit_show", methods={"GET"})
     */
    public function show(TypeProduitRepository $typeProduitRepository,$id): Response
    {
        $defaultContext=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet,$format,$context){
                return "Symfony 5";
            }
        ];
        return $this->json($typeProduitRepository->getOneTypeProduit($id),200,[],$defaultContext);
    }

    /**
     * @Route("/getAndEditTypeProduit/{id}", name="type_produit_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TypeProduit $typeProduit): Response
    {
        $defaultContext=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet,$format,$context){
                return "Symfony 5";
            }
        ];
        $request=$request->getContent();
        $form=json_decode($request,true);
        $typeProduit->settype($form['type']);
        $this->getDoctrine()->getManager()->flush();
        return $this->json('modification reussie', 200,[],$defaultContext);
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
     * @Route("/verificationUniciteTypeProduit", name="verificationUniciteTypeProduit", methods={"GET","POST"})
     */
    public function verificationUniciteTypeProduit(TypeProduitRepository $repos,Request $request): Response
    {
        $defaultContext=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet,$format,$context){
                return "Symfony 5";
            }
        ];
        $request=$request->getContent();
        $content=json_decode($request,true);
        return $this->json($repos->verificationTypeProduit($content['type']),200,[],$defaultContext);
    }
}
