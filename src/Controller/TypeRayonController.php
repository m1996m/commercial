<?php

namespace App\Controller;

use App\Entity\TypeRayon;
use App\Form\TypeRayonType;
use App\Repository\CentreRepository;
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
        return $this->json($typeRayonRepository->getAllTypeRayon(1),200);
    }

    /**
     * @Route("/type/rayon/new", name="type_rayon_new", methods={"GET","POST"})
     */
    public function new(Request $request,CentreRepository $repos): Response
    {
        $typeRayon = new TypeRayon();
        $request=$request->getContent();
        $form=json_decode($request,true);
        $centre=$repos->find(1);
        $typeRayon->setDesignation($form['designation']);
        $typeRayon->setCentre($centre);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($typeRayon);
        $entityManager->flush();
        return $this->json('Ajout reussi', 200);
    }

    /**
     * @Route("/getOneTypeRayon/{id}", name="type_rayon_show", methods={"GET","POST"})
     */
    public function show(TypeRayonRepository $repos,$id): Response
    {
        return $this->json($repos->getOneTypeRayon(1,$id),200);
    }

    /**
     * @Route("/verificationTypeRayon", name="verificationTypeRayon", methods={"GET","POST"})
     */
    public function verificationTypeRayon(TypeRayonRepository $repos,Request $request): Response
    {
        $request=$request->getContent();
        $content=json_decode($request,true);
        return $this->json($repos->verificationTypeRayon($content['designation'],1),200);
    }

    /**
     * @Route("/getAndEditTypeRayon/{id}", name="type_rayon_edit", methods={"GET","POST"})
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
     * @Route("/getDeleteTypeRayon/{id}", name="type_rayon_delete", methods={"POST"})
     */
    public function delete(Request $request, TypeRayon $typeRayon): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($typeRayon);
        $entityManager->flush();
        return $this->json('Suppression reussie', 200);
    }
}
