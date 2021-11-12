<?php

namespace App\Controller;

use App\Entity\Fournisseur;
use App\Entity\FournisseurCentre;
use App\Form\FournisseurType;
use App\Repository\CentreRepository;
use App\Repository\FournisseurCentreRepository;
use App\Repository\FournisseurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class FournisseurController extends AbstractController
{
    /**
     * @Route("/fournisseur", name="fournisseur_index", methods={"GET"})
     */
    public function index(FournisseurRepository $fournisseurRepository): Response
    {
        $defaultContext=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet,$format,$context){
                return "Symfony 5";
            }
        ];
        return $this->json($fournisseurRepository->findAll(),200,[],$defaultContext);
    }

    /**
     * @Route("/fournisseur/new", name="fournisseur_new", methods={"GET","POST"})
     */
    public function new(Request $request,FournisseurRepository $repos,CentreRepository $reposCentre): Response
    {
        $fournisseur = new Fournisseur();
        $request=$request->getContent();
        $form=json_decode($request,true);
        $fournisseur->setNom($form['nom']);
        $fournisseur->setPrenom($form['prenom']);
        $fournisseur->setTel($form['tel']);
        $fournisseur->setAdresse($form['adresse']);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($fournisseur);
        $entityManager->flush();
        $fournisseurCentre = new FournisseurCentre();
        $fournisseur=$repos->findOneBy(['tel'=>$form['tel']]);
        $fournisseurCentre->setCentre($this->getUser()->getCentre());
        $fournisseurCentre->setFournisseur($fournisseur);
        $entityManager->persist($fournisseur);
        $entityManager->flush();
        return $this->json('Ajout reussi', 200);
    }

    /**
     * @Route("/getOnefournisseur/{id}", name="fournisseur_show", methods={"GET"})
     */
    public function show(Fournisseur $fournisseur): Response
    {
        $defaultContext=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet,$format,$context){
                return "Symfony 5";
            }
        ];
        return $this->json($fournisseur,200,[],$defaultContext);
    }

    /**
     * @Route("/getAndEditFournisseur/{id}", name="fournisseur_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Fournisseur $fournisseur,FournisseurCentreRepository $fc,FournisseurRepository $repos,CentreRepository $reposCentre): Response
    {
        $defaultContext=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet,$format,$context){
                return "Symfony 5";
            }
        ];
        $request=$request->getContent();
        $form=json_decode($request,true);
        $fournisseur->setNom($form['nom']);
        $fournisseur->setPrenom($form['prenom']);
        $fournisseur->setTel($form['tel']);
        $fournisseur->setAdresse($form['adresse']);
        $this->getDoctrine()->getManager()->flush();
        return $this->json('Modification reussie', 200,[],$defaultContext);
    }

    /**
     * @Route("/getDeleteFournisseur/{id}", name="fournisseur_delete", methods={"POST"})
     */
    public function delete(Request $request, Fournisseur $fournisseur): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($fournisseur);
        $entityManager->flush();
        return $this->json('Suppression reussie', 200);
    }

    /**
     * @Route("/rechercherfournisseur", name="rechercherFournisseur", methods={"GET"})
     */
    public function rechercherFournisseur(Request $request, FournisseurRepository $repos): Response
    {
        $defaultContext=[
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER=>function($objet,$format,$context){
                return "Symfony 5";
            }
        ];
        $request=$request->getContent();
        $content=json_decode($request,true);
        return $this->json($repos->rechercherFournisseur($content['content']),200,[],$defaultContext);
    }
}
