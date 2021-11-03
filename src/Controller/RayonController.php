<?php

namespace App\Controller;

use App\Entity\Centre;
use App\Entity\ProduitStock;
use App\Entity\Rayon;
use App\Entity\TypeRayon;
use App\Entity\User;
use App\Form\RayonType;
use App\Repository\RayonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class RayonController extends AbstractController
{
    /**
     * @Route("/rayon", name="rayon_index", methods={"GET"})
     */
    public function index(RayonRepository $rayonRepository): Response
    {
        $defaultContext=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet,$format,$context){
                return "Symfony 5";
            }
        ];
        return $this->json($rayonRepository->findAll(),200,[],$defaultContext);
    }

    /**
     * @Route("/rayon/new", name="rayon_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $ps=new ProduitStock(); 
        $rayon = new Rayon();
        $request=$request->getContent();
        $form=json_decode($request,true);
        $entityManager = $this->getDoctrine()->getManager();
        $produitStock=$entityManager->getRepository(ProduitStock::class)->find($form['produitStock']);
        $user=$entityManager->getRepository(User::class)->find($form['user']);
        $type=$entityManager->getRepository(TypeRayon::class)->find($form['type']);
        $rayon->setCreatedAt(new \DateTime());
        $rayon->setUser($user);
        $rayon->settype($type);
        $rayon->setProduitStock($produitStock);
        $rayon->setQuantite($form['quantite']);            
        $entityManager->persist($rayon);
        $entityManager->flush();
       $ps=$produitStock;
        $ps->setQuantite($ps->getQuantite()-$form['quantite']);
        $this->getDoctrine()->getManager()->flush();
        return $this->json('Ajout reussi', 200);
        
    }

    /**
     * @Route("/getOneRayon/{id}", name="rayon_show", methods={"GET"})
     */
    public function show(Rayon $rayon): Response
    {
        $defaultContext=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet,$format,$context){
                return "Symfony 5";
            }
        ];
        return $this->json($rayon,200,[],$defaultContext);
    }

    /**
     * @Route("/interogationRayon", name="interogationRayon", methods={"GET"})
     */
    public function interogationRayon(Request $request,RayonRepository $repos): Response
    {
        $request=$request->getContent();
        $content=json_decode($request,true);
        $entityManager=$this->getDoctrine()->getManager();
        $centre=$entityManager->getRepository(Centre::class)->find($content['centre']);
        $type=$entityManager->getRepository(TypeRayon::class)->find($content['type']);
        $produitStock=$entityManager->getRepository(ProduitStock::class)->find($content['produitStock']);
        $defaultContext=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet,$format,$context){
                return "Symfony 5";
            }
        ];
        $rayons=[];
        if($content['type']!=" "){
            $rayons=$repos->rechercherProduitRayon($type,$centre);
        }
        if($content['produitStock']!=" "){
            $rayons=$repos->rechercherProduit($produitStock);
        }
        return $this->json($rayons,200,[],$defaultContext);
    }

        /**
     * @Route("/etatRayon", name="etatRayon", methods={"GET"})
     */
    public function etatRayon(Request $request,RayonRepository $repos): Response
    {
        $request=$request->getContent();
        $content=json_decode($request,true);
        $entityManager=$this->getDoctrine()->getManager();
        $centre=$entityManager->getRepository(Centre::class)->find($content['centre']);
        $defaultContext=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet,$format,$context){
                return "Symfony 5";
            }
        ];
        return $this->json($repos->etatRayon($centre),200,[],$defaultContext);
    }

    /**
     * @Route("/getAndEditRayon/{id}", name="rayon_edit", methods={"GET","POST"})
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
        $produitStock=$entityManager->getRepository(ProduitStock::class)->find($form['produitStock']);
        $user=$entityManager->getRepository(User::class)->find($form['user']);
        $type=$entityManager->getRepository(TypeRayon::class)->find($form['type']);
        $rayon->setCreatedAt(new \DateTime());
        $rayon->setUser($user);
        $rayon->setType($type);
        $rayon->setProduitStock($produitStock);
        $rayon->setQuantite($form['quantite']);  
        $this->getDoctrine()->getManager()->flush();
        $ps=$produitStock;
        $ps->setQuantite($ps->getQuantite()-$form['quantite']);
        $this->getDoctrine()->getManager()->flush();
        return $this->json($rayon,200, [], $defaultContext);
    }

    /**
     * @Route("/getDelete/{id}", name="rayon_delete", methods={"POST"})
     */
    public function delete(Request $request, Rayon $rayon): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($rayon);
        $entityManager->flush();
        return $this->json('OK', 200);
    }
}
