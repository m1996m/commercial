<?php

namespace App\Controller;

use App\Entity\TypeRayon;
use App\Form\TypeRayonType;
use App\Repository\TypeRayonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TypeRayonController extends AbstractController
{
    /**
     * @Route("/type/rayon", name="type_rayon_index", methods={"GET"})
     */
    public function index(TypeRayonRepository $typeRayonRepository): Response
    {
        return $this->json($typeRayonRepository->findAll(),200);
    }

    /**
     * @Route("/type/rayon/new", name="type_rayon_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $typeRayon = new TypeRayon();
        $request=$request->getContent();
        $form=json_decode($request,true);
        $typeRayon->setDesignation($form['designation']);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($typeRayon);
        $entityManager->flush();
        return $this->json('Ajout reussi', 200);
    }

    /**
     * @Route("/getTypeRayon/{id}", name="type_rayon_show", methods={"GET"})
     */
    public function show(TypeRayon $typeRayon): Response
    {
        return $this->json($typeRayon,200);
    }

    /**
     * @Route("/verificationTypeRayon", name="verificationTypeRayon", methods={"GET"})
     */
    public function verificationTypeRayon(TypeRayonRepository $repos,Request $request): Response
    {
        $request=$request->getContent();
        $content=json_decode($request,true);
        return $this->json($repos->verificationTypeRayon($content['designation']),200);
    }

    /**
     * @Route("/getAndEdittypeRayon/{id}", name="type_rayon_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TypeRayon $typeRayon): Response
    {
        $request=$request->getContent();
        $form=json_decode($request,true);
        $typeRayon->setDesignation($form['designation']);
        $this->getDoctrine()->getManager()->flush();
        return $this->json($typeRayon, 200);
    }

    /**
     * @Route("/getDelete/{id}", name="type_rayon_delete", methods={"POST"})
     */
    public function delete(Request $request, TypeRayon $typeRayon): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($typeRayon);
        $entityManager->flush();
        return $this->json('Suppression reussie', 200);
    }
}
