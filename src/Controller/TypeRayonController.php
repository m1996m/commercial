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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("ROLE_USER")
 */

class TypeRayonController extends AbstractController
{
    /**
     * @Route("/api/type/rayon", name="type_rayon_index", methods={"GET"})
     */
    public function index(TypeRayonRepository $typeRayonRepository): Response
    {
        return $this->json($typeRayonRepository->getAllTypeRayon($this->getUser()->getCentre()->getId()),200);
    }

    /**
     * @Route("/api/type/rayon/new", name="type_rayon_new", methods={"GET","POST"})
     */
    public function new(Request $request,CentreRepository $repos): Response
    {
        $typeRayon = new TypeRayon();
        $request=$request->getContent();
        $form=json_decode($request,true);
        $typeRayon->setDesignation($form['designation']);
        $typeRayon->setCentre($this->getUser()->getCentre());
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($typeRayon);
        $entityManager->flush();
        return $this->json('Ajout reussi', 200);
    }

    /**
     * @Route("/api/getOneTypeRayon/{id}", name="type_rayon_show", methods={"GET","POST"})
     */
    public function show(TypeRayonRepository $repos,$id): Response
    {
        return $this->json($repos->getOneTypeRayon($this->getUser()->getCentre()->getId(),$id),200);
    }

    /**
     * @Route("/api/verificationTypeRayon", name="verificationTypeRayon", methods={"GET","POST"})
     */
    public function verificationTypeRayon(TypeRayonRepository $repos,Request $request): Response
    {
        $request=$request->getContent();
        $content=json_decode($request,true);
        return $this->json($repos->verificationTypeRayon($content['designation'],$this->getUser()->getCentre()->getId()),200);
    }

    /**
     * @Route("/api/getAndEditTypeRayon/{id}", name="type_rayon_edit", methods={"GET","POST"})
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
     * @Route("/api/getDeleteTypeRayon/{id}", name="type_rayon_delete", methods={"POST"})
     */
    public function delete(Request $request, TypeRayon $typeRayon): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($typeRayon);
        $entityManager->flush();
        return $this->json('Suppression reussie', 200);
    }
}
