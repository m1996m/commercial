<?php

namespace App\Controller;

use App\Entity\Centre;
use App\Repository\CentreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class CentreController extends AbstractController
{
    /**
     * @Route("/api/centre", name="centre_index", methods={"GET"})
     */
    public function index(CentreRepository $centreRepository): Response
    {
        $defaultContext=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet,$format,$context){
                return "Symfony 5";
            }
        ];
        $centres=$centreRepository->getAll();

        return $this->json($centres,200,[],$defaultContext);
    }

    /**
     * @Route("/centre/new", name="centre_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $centre = new Centre();
        $request=$request->getContent();
        $form=json_decode($request,true);
        $centre->setNom($form['nom']);
        $centre->setAdresse($form['adresse']);
        $centre->setTel($form['tel']);
        $centre->setVille($form['ville']);
        $centre->setPays($form['pays']);
        $centre->setEmail($form['email']);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($centre);
        $entityManager->flush();
        return $this->json('Ajout reussi',200);
    }

    /**
     * @Route("/api/getOneCentre/{id}", name="centre_show", methods={"GET"})
     */
    public function show(CentreRepository $centreRepository,$id): Response
    {
        $defaultContext=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet,$format,$context){
                return "Symfony 5";
            }
        ];
        return $this->json($centreRepository->getOneCentre($id),200,[],$defaultContext);
    }
    

    /**
     * @Route("/api/rechercherCentre", name="rechercherCentre", methods={"GET","POST"})
     */
    public function rechercherCentre(CentreRepository $repos, Request $request): Response
    {
        $defaultContext=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet,$format,$context){
                return "Symfony 5";
            }
        ];
        $request=$request->getContent();
        $valeur=json_decode($request,true);
        return $this->json($repos->rechercherCentre($valeur['content']),200,[],$defaultContext);
    }
    /**
     * @Route("/api/getAndOrEditCentre/{id}", name="centre_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Centre $centre): Response
    {
        $defaultContext=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet,$format,$context){
                return "Symfony 5";
            }
        ];
        $request=$request->getContent();
        $form=json_decode($request,true);
        $centre->setNom($form['nom']);
        $centre->setAdresse($form['adresse']);
        $centre->setTel($form['tel']);
        $centre->setVille($form['ville']);
        $centre->setPays($form['pays']);
        $centre->setEmail($form['email']);
        $this->getDoctrine()->getManager()->flush();
        return $this->json($centre,200,[],$defaultContext);
    }

    /**
     * @Route("/api/getDeleteCentre/{id}", name="centre_delete", methods={"POST"})
     */
    public function delete(Request $request, Centre $centre): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($centre);
        $entityManager->flush();
        return $this->json('Suppression bien reussie',200);
    }

    /**
     * @Route("/api/verificationUniciteTelCentre", name="verificationUniciteTelCentre", methods={"GET","POST"})
     */
    public function verificationUniciteTel(CentreRepository $repos,Request $request): Response
    {
        $request=$request->getContent();
        $content=json_decode($request,true);
        return $this->json($repos->getTel($content['tel']),200);
    }

    /**
     * @Route("/api/verificationUniciteEmail", name="verificationUniciteEmail", methods={"GET","POST"})
     */
    public function verificationUniciteEmail(CentreRepository $repos,Request $request): Response
    {
        $request=$request->getContent();
        $content=json_decode($request,true);
        return $this->json($repos->getemail($content['email']),200);
    }
}
